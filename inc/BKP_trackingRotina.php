<?php
//header("Content-type:application/json");

//require_once($siteHD.'inc/def.php');
//require_once('carrinho.php');
//require_once('def.php');


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


$link = mysqli_connect("localhost", "LojaDaLataDBuser", "mpXt29@2", "LojaDaLataDB") or die('SEM CONEXÃO');
mysqli_set_charset($link, "utf8");





// Seta conexão pra usar classes orientadas à objeto
class Conexao{
	protected $link;
	protected $site;

	function __construct(){
		global $link;
		global $site;
		$this->link = $link;
		$this->site = $site;
	}
}



//class FreteRapido{
//class FreteRapido extends conexao{
class FreteRapido extends Conexao{
	protected $cnpjLDL = '61160438000393';
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


//		$tipo_pessoa = 2;
//		$cnpj_cpf = '69111653000144';
//		$inscricao_estadual = '123456';
//		$cep = '99585000';

		//$tipo_pessoa = intval($r['tipo_pessoa']);

		$tipo_pessoa = 2;
		$cnpj_cpf = $this->cnpjLDL;
		$inscricao_estadual = 123456;



		$url = 'https://freterapido.com/api/external/embarcador/v1/quote-simulator';

		$sql = 'SELECT c.idProduto , p.titulo , c.qtde , p.altura , p.largura , p.comprimento , p.peso , p.preco 
			FROM Carrinho c
			JOIN Produtos p ON p.id = c.idProduto
			WHERE c.idUser = '.$_SESSION['idUser'].';';
		$q = mysqli_query($this->link , $sql);
		$nr = mysqli_num_rows($q);

		if($nr > 0){	

			$volumes = array();

			while($r = mysqli_fetch_assoc($q)){

				array_push($volumes,array(
					'tipo'=> 20,
					'sku'=> $r['idProduto'],
					'descricao'=> $r['titulo'],
					'quantidade'=> intval($r['qtde']),
					'altura'=> floatval($r['altura']),
					'largura'=> floatval($r['largura']),
					'comprimento'=> floatval($r['comprimento']),
					'peso'=> floatval($r['peso']),
					'valor'=> floatval($r['preco'])
				));

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
					$sql = 'INSERT INTO Transportadoras_Cotacoes (idUser , idTransportadora , token_oferta , oferta , prazo_entrega , validade , custo_frete , preco_frete , servico)
						VALUES ("'.$_SESSION['idUser'].'" , "'.$idTransportadora.'" , "'.$result['token_oferta'].'" , "'.$v['oferta'].'" , "'.$v['prazo_entrega'].'" , "'.$v['validade'].'" , "'.$v['custo_frete'].'" , CEIL('.$v['preco_frete'].') , "'.$v['servico'].'");';
					mysqli_query($this->link , $sql);
 */					
				}//foreach
			}//if
		}else{
			$result = 'Primeiro coloque algum produto no carrinho.';
		}

		return $result;

	}//calculaFreteCEP








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

		$sql = 'SELECT * 
			FROM Carrinho c
			JOIN Produtos p ON p.id = c.idProduto
			WHERE c.idUser = '.$_SESSION['idUser'].';';
		$q = mysqli_query($this->link , $sql);
		$nr = mysqli_num_rows($q);

		if($nr > 0){	

			$volumes = array();

			while($r = mysqli_fetch_assoc($q)){

				array_push($volumes,array(
					'tipo'=> 20,
					'sku'=> $r['idProduto'],
					'descricao'=> $r['titulo'],
					'quantidade'=> intval($r['qtde']),
					'altura'=> floatval($r['altura']),
					'largura'=> floatval($r['largura']),
					'comprimento'=> floatval($r['comprimento']),
					'peso'=> floatval($r['peso']),
					'valor'=> floatval($r['preco'])
				));

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



$freteRapido = new FreteRapido();


$sql = 'UPDATE Compras c
	JOIN Compras_X_Invoices ci ON ci.idCompra = c.id
	SET c.pago = 1 
	WHERE c.pago = 0 AND ci.responseMessage = "CAPTURED" AND ci.responseCode = 0;';
mysqli_query($link , $sql);



$sql = 'SELECT id FROM Compras WHERE entregue = 0 AND pago = 1 AND enviado = 1 AND codigoRastreio IS NOT NULL AND codigoRastreio != "";';
$q = mysqli_query($link , $sql);

while($r = mysqli_fetch_assoc($q)){
	$tracking = $freteRapido->getTracking($r['id']);

	foreach($tracking as $k=>$v){
		$statusFrete = $v['nome'];
	}

	if($statusFrete == 'Entregue'){
		$complementoSql = ', entregue = 1';
	}

	$sql2 = 'UPDATE Compras SET statusEntrega = "'.$statusFrete.'" '.$complementoSql.' WHERE id = '.$r['id'].';';
	mysqli_query($link , $sql2);
}



?>

