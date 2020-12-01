<?php
//header("Content-type:application/json");

//require_once($siteHD.'inc/def.php');
//require_once('carrinho.php');
require_once('def.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
$host = "127.0.0.1";
$user = "root";
$pass = "root";
$db = "LojaDaLata";
$port = 8889;

$link = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
mysqli_set_charset($link, "utf8mb4");
date_default_timezone_set('America/Sao_Paulo');
*/


//class FreteRapido{
//class FreteRapido extends conexao{
class FreteRapido extends Conexao{
	protected $cnpjLDL = '61160438000121';
	protected $codigo_plataforma = '8r451lat4';
	protected $token = '71f93a24558ffabfed271d9bd2b17343';


	protected function curl($url,$json){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		
                $tentativa = 1;
                while((curl_errno($ch) == 28 or $tentativa == 1) and $tentativa < 50){
                        $data = curl_exec($ch);

                        if($tentativa > 1){
        //                      echo "\n".curl_errno($ch)."\n--> ".$tentativa . " - ".$url ." ";
                                sleep(3);
                        }
                        $tentativa++;
                }


//		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}//curl




	public function getTracking($idCompra){

		$sql = 'SELECT codigoRastreio FROM Compras WHERE id = '.$idCompra;
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);

		$url = 'https://freterapido.com/api/external/embarcador/v1/quotes/'.$r['codigoRastreio'].'/occurrences?token='.$this->token;


		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($data, true);

		/*
		foreach($result as $k=>$v){
			echo "<br><br>" . $v['data_ocorrencia'] . ' - ' . $v['nome'];
		}
		*/

//		print_r($result);
		return $result;

	}





	public function contratarFrete($idCompra){
		$sql = 'SELECT DATE(NOW() + INTERVAL (prazo_producao + 1) DAY) data_coleta
			FROM Compras_X_Produtos cp 
			JOIN Produtos p ON p.id = cp.idProduto
			WHERE cp.idCompra = '.$idCompra.' 
			ORDER BY 1 DESC
			LIMIT 1;';
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);
		$data_coleta = $r['data_coleta'];


		$sql = 'SELECT token_oferta , oferta FROM Transportadoras_Cotacoes WHERE id = (SELECT idTransportadoras_Cotacoes FROM Compras WHERE id = '.$idCompra.');';
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);

		// 	Contratar Frete
		$url = 'https://freterapido.com/api/external/embarcador/v1/quote/ecommerce/'.$r['token_oferta'].'/offer/'.$r['oferta'].'?token='.$this->token;
//echo "<br>URL<br>".$url."<br><br>";

		$sql = 'SELECT CONCAT(nome , " " , sobrenome) nome , email , telefone , logradouro , numero , bairro , complemento , cep , cnpj , cpf , tipo_pessoa , inscricao_estadual
			FROM Users_X_Enderecos WHERE id = (SELECT idUsers_X_Enderecos FROM Compras WHERE id = '.$idCompra.');';
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);

		if($r['tipo_pessoa'] == 'PJ'){
			$cnpj_cpf = $r['cnpj'];
			$inscricao_estadual = $r['inscricao_estadual'];

		}elseif($r['tipo_pessoa'] == 'PF'){
			$cnpj_cpf = $r['cpf'];
		}


// $cep = preg_replace("/[^0-9]/", "", $_POST['cep']);

		$json = array(
			'remetente'=>array(
				'cnpj'=>$this->cnpjLDL
			)
			,'destinatario'=>array(
				'cnpj_cpf'=>preg_replace("/[^0-9]/", "", $cnpj_cpf),
				'nome'=>$r['nome'],
				'email'=>$r['email'],
				'telefone'=> preg_replace("/[^0-9]/", "", $r['telefone']),

				'endereco'=>array(
					'rua'=>$r['logradouro'],
					'numero'=>$r['numero'],
					'bairro'=>$r['bairro'],
					'complemento'=>$r['complemento'],
				
					'cep'=>preg_replace("/[^0-9]/", "", $r['cep'])
				)

			)
			,'numero_pedido'=>$idCompra
			,'data_coleta'=>$data_coleta
			
		);
		
		if(isset($inscricao_estadual)){
			$json['destinatario']['inscricao_estadual'] = preg_replace("/[^0-9]/", "", $inscricao_estadual);
		}

		$json = json_encode($json,true);
//	echo "<br>ENVIO<br>";		print_r($json);		echo "<br><br>";	//exit;
 
		$result = self::curl($url , $json);

		$result = json_decode($result, true); 		
		
//	echo "<br>RETORNO<br>";		print_r($result); 	echo "<br><br>";	//exit;

		$sql = 'UPDATE Compras SET codigoRastreio = "'.$result['id_frete'].'" WHERE id = '.$idCompra.';';
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		return $result['id_frete'];
//		$result = json_decode($result, true); 		echo "<br><br>";		print_r($result); exit;
		// $urlAcompanhamento = 'https://freterapido.com/rastreio/#/'.$result['id_frete'];


		/*
		Exemplo de Envio:
		    {
		      "remetente": {
			"cnpj": "61160438000393"
		      },
		      "destinatario": {
			"cnpj_cpf": "55187608681",
			"nome": "GILSON DA SILVA",
			"email": "gilson@email.com",
			"telefone": "11922228888",
			"endereco": {
			  "rua": "RUA Robert Bosch",
			  "numero": "01",
			  "bairro": "BAIRRO EXEMPLO",
			  "complemento": "APTO 404",
			  "cep": "01141010"
			}
		      },
		      "numero_pedido": "1127848",
		      "nota_fiscal": {
			"numero": "1316813541378980384",
			"serie": "3548",
			"chave_acesso": "9545cd084ce5038b",
			"valor": 50.25
		      },
		      "data_coleta": "2017-04-26"
		    }
		*/
	}//contratarFrete







	public function calculaFreteCEP($cep){


		//	
				$sql = 'SELECT c.idProduto , p.titulo , c.qtde , p.altura , p.largura , p.comprimento , p.peso , p.qtdcaixa,
				(SELECT valorUnitario FROM PrecosQuantidades WHERE idProduto = c.idProduto AND qtde >= c.qtde ORDER BY valorUnitario DESC LIMIT 1) precon
							FROM Carrinho c
							JOIN Produtos p ON p.id = c.idProduto
							WHERE c.idUser = '.$_SESSION['idUser'].';';
				$q = mysqli_query($this->link , $sql);
				$nr = mysqli_num_rows($q);
		
		
		
		
					while($r = mysqli_fetch_assoc($q)){
		
		
		  
						$url = 'https://api.braspress.com/v1/cotacao/calcular/json';
						$username = 'BRASILATA_PRD';
						$senha = '#PT3YO%AY7#Mx&%1';
					  
					  
					  
							//create a new cURL resource
							$ch = curl_init($url);
							
							//setup request to send json via POST
						
							$total = ($r['qtde'] / $r['qtdcaixa']);
							if($total < 1 AND $total > 0.1){
		
							$json2 ='{
								"cnpjRemetente":61160438001101,
								"cnpjDestinatario":30539356867,
								"modal":"R",
								"tipoFrete":"1",
								"cepOrigem":13205700,
								"cepDestino":"'.$cep.'",
								"vlrMercadoria":"'.floatval($r['qtde'] * $r['precon']).'",
								"peso":"'.floatval($r['qtde'] * $r['peso']).'",
								"volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).',
								"cubagem":[
								   {
									  "altura":'.floatval($r['altura'] * $total).',
									  "largura":'.floatval($r['largura']* $total).',
									  "comprimento":'.floatval($r['comprimento']* $total).',
									  "volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).'
								   }
								]
							 }';
						   
								 
							}elseif($total < 0.1){
						
								$json2 ='{
									"cnpjRemetente":61160438001101,
									"cnpjDestinatario":30539356867,
									"modal":"R",
									"tipoFrete":"1",
									"cepOrigem":13205700,
									"cepDestino":"'.$cep.'",
									"vlrMercadoria":"'.floatval($r['qtde'] * $r['precon']).'",
									"peso":"'.floatval($r['qtde'] * $r['peso']).'",
									"volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).',
									"cubagem":[
									   {
										  "altura":'.floatval($r['altura'] * 0.10).',
										  "largura":'.floatval($r['largura']* 0.10).',
										  "comprimento":'.floatval($r['comprimento']* 0.10).',
										  "volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).'
									   }
									]
								 }';
		
							}else{
			
								$json2 ='{
									"cnpjRemetente":61160438001101,
									"cnpjDestinatario":30539356867,
									"modal":"R",
									"tipoFrete":"1",
									"cepOrigem":13205700,
									"cepDestino":"'.$cep.'",
									"vlrMercadoria":"'.floatval($r['qtde'] * $r['precon']).'",
									"peso":"'.floatval($r['qtde'] * $r['peso']).'",
									"volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).',
									"cubagem":[
									   {
										  "altura":"'.floatval($r['altura']).'",
										  "largura":'.floatval($r['largura']).',
										  "comprimento":'.floatval($r['comprimento']).',
										  "volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).'
									   }
									]
								 }';
								 }
						
						
							 $payload = $json2;
						  
							curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); //DOCUMENT
						
							//set the content type to application/json
							curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
								'Content-Type:application/json'));
							
							//return response instead of outputting
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							
							//execute the POST request
						   $results = curl_exec($ch);
						
							// exit;
							//close cURL resource
							curl_close($ch);
					  
							$obj = json_decode($results);
				
		// echo "<br>ENVIO<br>"; print_r($json2);echo "<br><br>";
		
		// 	//		return $json; exit;
		
		
				
		
		
		
		
		
		
		
		
		
		
		
					
				
			}
			echo '<h4 style="color:#4ec66b;font-weight: bold;">  <i class="fa fa-truck"></i> BRASPRESS<span  style=" border-radius:10px; background:#EBEDEF; color:#4F4F4F;font-weight: bold;">  	até '.$obj->prazo.' dias úteis  &nbsp; <i class="fa fa-long-arrow-right"></i> R$'.$obj->totalFrete.'&nbsp;</h4></span>';
		
		}




		public function calculaFreteCEP2($cep){


			//	
					$sql = 'SELECT c.idProduto , p.titulo , c.qtde , p.altura , p.largura , p.comprimento , p.peso , p.qtdcaixa,
					(SELECT valorUnitario FROM PrecosQuantidades WHERE idProduto = c.idProduto AND qtde >= c.qtde ORDER BY valorUnitario DESC LIMIT 1) precon
								FROM Carrinho c
								JOIN Produtos p ON p.id = c.idProduto
								WHERE c.idUser = '.$_SESSION['idUser'].';';
					$q = mysqli_query($this->link , $sql);
					$nr = mysqli_num_rows($q);
			
			
			
			
						while($r = mysqli_fetch_assoc($q)){
			
			
			  
							$url = 'https://api.braspress.com/v1/cotacao/calcular/json';
							$username = 'BRASILATA_PRD';
							$senha = '#PT3YO%AY7#Mx&%1';
						  
						  
						  
								//create a new cURL resource
								$ch = curl_init($url);
								
								//setup request to send json via POST
							
								$total = ($r['qtde'] / $r['qtdcaixa']);
								if($total < 1 AND $total > 0.1){
			
								$json2 ='{
									"cnpjRemetente":61160438001101,
									"cnpjDestinatario":30539356867,
									"modal":"R",
									"tipoFrete":"1",
									"cepOrigem":13205700,
									"cepDestino":"'.$cep.'",
									"vlrMercadoria":"'.floatval($r['qtde'] * $r['precon']).'",
									"peso":"'.floatval($r['qtde'] * $r['peso']).'",
									"volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).',
									"cubagem":[
									   {
										  "altura":'.floatval($r['altura'] * $total).',
										  "largura":'.floatval($r['largura']* $total).',
										  "comprimento":'.floatval($r['comprimento']* $total).',
										  "volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).'
									   }
									]
								 }';
							   
									 
								}elseif($total < 0.1){
							
									$json2 ='{
										"cnpjRemetente":61160438001101,
										"cnpjDestinatario":30539356867,
										"modal":"R",
										"tipoFrete":"1",
										"cepOrigem":13205700,
										"cepDestino":"'.$cep.'",
										"vlrMercadoria":"'.floatval($r['qtde'] * $r['precon']).'",
										"peso":"'.floatval($r['qtde'] * $r['peso']).'",
										"volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).',
										"cubagem":[
										   {
											  "altura":'.floatval($r['altura'] * 0.10).',
											  "largura":'.floatval($r['largura']* 0.10).',
											  "comprimento":'.floatval($r['comprimento']* 0.10).',
											  "volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).'
										   }
										]
									 }';
			
								}else{
				
									$json2 ='{
										"cnpjRemetente":61160438001101,
										"cnpjDestinatario":30539356867,
										"modal":"R",
										"tipoFrete":"1",
										"cepOrigem":13205700,
										"cepDestino":"'.$cep.'",
										"vlrMercadoria":"'.floatval($r['qtde'] * $r['precon']).'",
										"peso":"'.floatval($r['qtde'] * $r['peso']).'",
										"volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).',
										"cubagem":[
										   {
											  "altura":"'.floatval($r['altura']).'",
											  "largura":'.floatval($r['largura']).',
											  "comprimento":'.floatval($r['comprimento']).',
											  "volumes":'.ceil($r['qtde'] / $r['qtdcaixa']).'
										   }
										]
									 }';
									 }
							
							
								 $payload = $json2;
							  
								curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); //DOCUMENT
							
								//set the content type to application/json
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
									'Content-Type:application/json'));
								
								//return response instead of outputting
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								
								//execute the POST request
							   $results = curl_exec($ch);
							
								// exit;
								//close cURL resource
								curl_close($ch);
						  
								$obj = json_decode($results);
					
			// echo "<br>ENVIO<br>"; print_r($json2);echo "<br><br>";
			
			
			
					
			
			
			
			
			
			
			
			
			$sqlfrete='INSERT INTO Transportadoras_Cotacoes (idUser , idTransportadora , token_oferta , oferta , prazo_entrega , validade , custo_frete , preco_frete , servico,selecionado)
			VALUES ("'.$_SESSION['idUser'].'" , "'.$obj->id.'" , "0" , "0" , "'.$obj->prazo.'" , "0" , "0" , CEIL('.$obj->totalFrete.') , "BRASSPRESS","0");';
		mysqli_query($this->link , $sqlfrete);
					
				}
			

			}	
		






	public function calculaFrete($enderecoSelecionado){


//		$tipo_pessoa = 2;
//		$cnpj_cpf = '69111653000144';
//		$inscricao_estadual = '123456';
//		$cep = '99585000';

		$sql = 'UPDATE Transportadoras_Cotacoes SET ativo = 0 WHERE idUser = "'.$_SESSION['idUser'].'";';
		mysqli_query($this->link , $sql);

		//$sql = 'SELECT cnpj , inscricao_estadual , cep , tipo_pessoa FROM Users WHERE id = '.$_SESSION['idUser'].';';
		$sql = 'SELECT cnpj , inscricao_estadual , cep , tipo_pessoa , cpf 
			FROM Users_X_Enderecos
			WHERE id = "'.$enderecoSelecionado.'";';

		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);

		$cep = $r['cep'];


		//$tipo_pessoa = intval($r['tipo_pessoa']);

		if($r['tipo_pessoa'] == 'PF'){
			$tipo_pessoa = 1;
                        $cnpj_cpf = $r['cpf'];

		}elseif($r['tipo_pessoa'] == 'PJ'){
			$tipo_pessoa = 2;
			$cnpj_cpf = $r['cnpj'];
			$inscricao_estadual = $r['inscricao_estadual'];

		}

		$url = 'https://freterapido.com/api/external/embarcador/v1/quote-simulator';

		$sql = 'SELECT *,
		(SELECT valorUnitario FROM PrecosQuantidades WHERE idProduto = c.idProduto AND qtde >= c.qtde ORDER BY valorUnitario DESC LIMIT 1) precon
			FROM Carrinho c
			JOIN Produtos p ON p.id = c.idProduto
			WHERE c.idUser = '.$_SESSION['idUser'].';';
		$q = mysqli_query($this->link , $sql);
		$nr = mysqli_num_rows($q);

		if($nr > 0){	

			$volumes = array();

			while($r = mysqli_fetch_assoc($q)){


				$total = ($r['qtde'] / $r['qtdcaixa']);

if($total < 1 AND $total > 0.1){

	$total = ($r['qtde'] / $r['qtdcaixa']);

	array_push($volumes,array(
		'tipo'=> 20,
		'sku'=> $r['idProduto'],
		'descricao'=> $r['titulo'],
		'quantidade'=> ceil($r['qtde'] / $r['qtdcaixa']),
		'altura'=> floatval($r['altura'] * $total),
		'largura'=> floatval($r['largura']* $total),
		'comprimento'=> floatval($r['comprimento']* $total),
		'peso'=> floatval($r['qtde'] * $r['peso']),
		'valor'=> floatval($r['qtde'] * $r['precon'])
	));



}elseif($total < 0.1){

	array_push($volumes,array(
		'tipo'=> 20,
		'sku'=> $r['idProduto'],
		'descricao'=> $r['titulo'],
		'quantidade'=> ceil($r['qtde'] / $r['qtdcaixa']),
		'altura'=> floatval($r['altura'] * 0.10),
		'largura'=> floatval($r['largura']* 0.10),
		'comprimento'=> floatval($r['comprimento']* 0.10),
		'peso'=> floatval($r['qtde'] * $r['peso']),
		'valor'=> floatval($r['qtde'] * $r['precon'])
	));

}else{
				array_push($volumes,array(
					'tipo'=> 20,
					'sku'=> $r['idProduto'],
					'descricao'=> $r['titulo'],
					'quantidade'=> ceil($r['qtde'] / $r['qtdcaixa']),
					'altura'=> floatval($r['altura']),
					'largura'=> floatval($r['largura']),
					'comprimento'=> floatval($r['comprimento']),
					'peso'=> floatval($r['qtde'] * $r['peso']),
					'valor'=> floatval($r['qtde'] * $r['precon'])
				));
			}

			}//while



			$json = array(
				'remetente'=>array(
					'cnpj'=> $this->cnpjLDL
				)
				,'destinatario'=>array(
					'tipo_pessoa'=>$tipo_pessoa,
					'cnpj_cpf'=> preg_replace("/[^0-9]/", "", $cnpj_cpf),
					
					'endereco'=>array(
						'cep'=>preg_replace("/[^0-9]/", "", $cep)
					)
				)
				,'volumes'=>$volumes
				,'codigo_plataforma'=> $this->codigo_plataforma
				,'token'=> $this->token
				
			  );


			if(isset($inscricao_estadual)){
				$json['destinatario']['inscricao_estadual'] = preg_replace("/[^0-9]/", "", $inscricao_estadual);
			}

			$json = json_encode($json,true);
//echo "<br>ENVIO<br>"; print_r($json);echo "<br><br>";

	//		return $json; exit;
			$result = self::curl($url , $json);

			$result = json_decode($result, true);
//echo "<br>RETORNO<br>"; print_r($result); 

			if(isset($result['transportadoras'])){
				foreach($result['transportadoras'] as $k=>$v){

					$sql = 'SELECT id FROM Transportadoras WHERE cnpj = "'.$v['cnpj'].'" AND logotipo = "'.$v['logotipo'].'" AND transportadora = "'.$v['nome'].'";';
					$q = mysqli_query($this->link , $sql);
					$r = mysqli_fetch_assoc($q);

					if(!is_null($r['id'])){

						$idTransportadora = $r['id'];
					}else{
						$sql = 'INSERT INTO Transportadoras (cnpj , logotipo , transportadora) VALUES ("'.$v['cnpj'].'" , "'.$v['logotipo'].'" , "'.$v['nome'].'");';
						$q = mysqli_query($this->link , $sql);
						$idTransportadora = mysqli_insert_id($this->link);
					}

		/*			
					$sql = 'INSERT INTO Cotacoes_Transportadoras (idUser , token_oferta , logotipo , oferta , cnpj , transportadora , prazo_entrega , validade , custo_frete , preco_frete , servico)
						VALUES ("'.$_SESSION['idUser'].'" , "'.$result['token_oferta'].'" , "'.$v['logotipo'].'" , "'.$v['oferta'].'" , "'.$v['cnpj'].'" , "'.$v['nome'].'" , "'.$v['prazo_entrega'].'" , "'.$v['validade'].'" , "'.$v['custo_frete'].'" , "'.$v['preco_frete'].'" , "'.$v['servico'].'");';
		*/
					$sql = 'INSERT INTO Transportadoras_Cotacoes (idUser , idTransportadora , token_oferta , oferta , prazo_entrega , validade , custo_frete , preco_frete , servico)
						VALUES ("'.$_SESSION['idUser'].'" , "'.$idTransportadora.'" , "'.$result['token_oferta'].'" , "'.$v['oferta'].'" , "'.$v['prazo_entrega'].'" , "'.$v['validade'].'" , "'.$v['custo_frete'].'" , CEIL('.$v['preco_frete'].') , "'.$v['servico'].'");';
					mysqli_query($this->link , $sql);
					
				}//foreach
			}//if
		}else{
			ir($this->site , 'Primeiro coloque algum produto no carrinho.');
		}
//		return $result;

	}//calculaFrete



}//classe





/*
$freteRapido = new FreteRapido();
$fretes = $freteRapido->calculaFreteCEP('04561000');
foreach($fretes['transportadoras'] as $k=>$v){

	echo '<br><br><br><br><br><br>';
	echo '<br>Logotipo: <img src="'.$v['logotipo'].'" width="200">';
	echo '<br>Oferta: '.$v['oferta'];
	echo '<br>CNPJ: '.$v['cnpj'];
	echo '<br>Transportadora: '.$v['nome'];
	echo '<br>Prazo: '.$v['prazo_entrega'].' dias';
	echo '<br>Validade: '.$v['validade'];
	echo '<br>Custo Frete: R$'.$v['custo_frete'];
	echo '<br>Preço Frete: R$'.$v['preco_frete'];
	echo '<br>Serviço: '.$v['servico'];

}
*/


/*
//var_dump($freteRapido->calculaFrete());exit;
$fretes = $freteRapido->calculaFrete();
echo $fretes['token_oferta'];
foreach($fretes['transportadoras'] as $k=>$v){

	echo '<br><br><br><br><br><br>';
	echo '<br>Logotipo: <img src="'.$v['logotipo'].'" width="200">';
	echo '<br>Oferta: '.$v['oferta'];
	echo '<br>CNPJ: '.$v['cnpj'];
	echo '<br>Transportadora: '.$v['nome'];
	echo '<br>Prazo: '.$v['prazo_entrega'].' dias';
	echo '<br>Validade: '.$v['validade'];
	echo '<br>Custo Frete: R$'.$v['custo_frete'];
	echo '<br>Preço Frete: R$'.$v['preco_frete'];
	echo '<br>Serviço: '.$v['servico'];

}
*/


/*
echo '<br><br><pre>';
echo print_r($fretes['transportadoras']);
echo '</pre>';
*/


/*
$freteRapido = new FreteRapido();
$tracking = $freteRapido->getTracking(119);
echo '<pre>';print_r($tracking);
/*
foreach($tracking as $k=>$v){
	echo "<br><br>" . $v['data_ocorrencia'] . ' - ' . $v['nome'];
}
 */





?>

