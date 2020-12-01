<?php
//header("Content-type:application/json");

//require_once($siteHD.'inc/def.php');
//require_once('carrinho.php');
//require_once('def.php');
require_once('PHPMailer/PHPMailerAutoload.php');



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
class Conexao2{
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

	$sql3 = 'UPDATE Compras SET statusEntrega = "'.$statusFrete.'" '.$complementoSql.' WHERE id = '.$r['id'].';';
	mysqli_query($link , $sql3);
}



?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//ini_set("allow_url_fopen", 1);

$link = mysqli_connect("localhost", "LojaDaLataDBuser", "mpXt29@2", "LojaDaLataDB") or die('SEM CONEXÃO');
mysqli_set_charset($link, "utf8");

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



class MaxiPago extends Conexao{

	protected $merchantId;
	protected $merchantKey;
	protected $version;
	
	protected $number;
	protected $expMonth;
	protected $expYear;
	protected $cvvNumber;
	
        function __construct(){
		parent::__construct();

		$this->merchantId = '44851';
		$this->merchantKey = 'z6v1hfulxrjt7akdulnwaav1';
	 	$this->version = '3.1.1.15';
 

	}

	protected function curl_xml($url , $xml) { 

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //connection timeout in seconds 

		$result = curl_exec($ch);
		$tentativa = 1;
		$httpcode = 0;
		while((curl_errno($ch) == 28 or $tentativa == 1 or $httpcode != 200) and $tentativa < 50){
			$data = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if($httpcode != 200){
				echo "\n\n\n\nAGUARDANDO 40s ............................ HTTP:".$httpcode."\n\n";
				echo "\n".curl_errno($ch)." --> ".$tentativa . " - ".$url ."\n\n";
				sleep(40);
			}elseif($tentativa > 1){
				echo "\n".curl_errno($ch)." --> ".$tentativa . " - ".$url ."\n\n";
				sleep(3);
			}
			$tentativa++;
		}

		curl_close($ch);

		$xml = simplexml_load_string($result);

		return $xml;

	}//curl_xml







	public function salvaDados($tabela , $result){

		$campos = array();

		foreach($result as $k => $v){
			if(!is_array($v)){
				$campos[$k] = addslashes($v);
			}
		}

		$sqlCampos = '(';
		$sqlValues = ') VALUES (';	
		$contadorCampos = 0;

		foreach($campos as $k2 => $v2){
			$poeVirgula = ($contadorCampos == 0 ? '' : ',');
			$sqlCampos .= $poeVirgula . '`'.$k2.'`';
			$sqlValues .= $poeVirgula . '"'.$v2.'"';
			$contadorCampos++;
		}

		$contadorWhile = 0;
		$sql = "INSERT INTO ".$tabela." ".$sqlCampos.$sqlValues.");";
		$q = mysqli_query($this->link , $sql); 

		while(!$q){
			$contadorWhile++;
			if($contadorWhile == 50){
				echo "\nERRO 50\n";
				exit;
			}
			$e = explode("'", mysqli_error($this->link));
			$nomeDoCampoASerCriado = $e[1];
			
			$sqlAddCampo = 'ALTER TABLE `'.$tabela.'` ADD `'.$nomeDoCampoASerCriado.'` VARCHAR(255) NULL DEFAULT NULL;';
			mysqli_query($this->link , $sqlAddCampo) or die("\n\nERRO: ".mysqli_error($this->link)."\n\n".$sqlAddCampo."\n\n");
			echo "\n\n------> Novo Campo '".$nomeDoCampoASerCriado."' adicionado na tabela ".$tabela."\n\n";
			$q = mysqli_query($this->link , $sql."\n\n");
		}//if

	}//salvaDados/




	public function getValorCompraComFrete($idCompra){
		
		$sql = 'SELECT SUM(valor*qtde) valor FROM Compras_X_Produtos WHERE idCompra = '.$idCompra.';';

		$q = mysqli_query($this->link , $sql);
		$r = mysqli_fetch_assoc($q);
		$valor = $r['valor'];

		$sql = 'SELECT preco_frete FROM Transportadoras_Cotacoes WHERE id = (SELECT idTransportadoras_Cotacoes FROM Compras WHERE id = '.$idCompra.');';
		$q = mysqli_query($this->link , $sql);
		$r = mysqli_fetch_assoc($q);
		$preco_frete = $r['preco_frete'];

		$chargeTotal = number_format(($valor + $preco_frete) , 2 , '.' , '');

		return $chargeTotal;

	}// getValorCompraComFrete




	public function setCreditCard($number , $expMonth , $expYear , $cvvNumber){

		$this->number = $number;
		$this->expMonth = $expMonth;
		$this->expYear = $expYear;
		$this->cvvNumber = $cvvNumber;

	}//setCreditCard







	public function pagarCC($idCompra){
		$url = 'https://secure.maxipago.net/hostpay/HostPay';

		//$auth_ou_sale = 'auth'; 
		$auth_ou_sale = 'sale';
		$parcelas = 0;

		$chargeTotal = self::getValorCompraComFrete($idCompra);
//		echo $chargeTotal; exit;
//		$chargeTotal = 1649.9;
//		$chargeTotal = 32.7;

		if(isset($parcelas) && !is_null($parcelas) && $parcelas != '' && $parcelas > 0){
			$parcelamentoComJuros = 'N';
		//	$parcelamentoComJuros = 'Y';
			$creditInstallment = '<creditInstallment>
							<numberOfInstallments>'.$parcelas.'</numberOfInstallments>
							<chargeInterest>'.$parcelamentoComJuros.'</chargeInterest>
						</creditInstallment>';
		}else{
			$creditInstallment = '';
		}

		$xml = '<transaction-request>
			<version>'.$this->version.'</version>
			<verification>
				<merchantId>'.$this->merchantId.'</merchantId>
				<merchantKey>'.$this->merchantKey.'</merchantKey>
			</verification>
			<order>
				<'.$auth_ou_sale.'>
					<processorID>1</processorID>
					<fraudCheck>N</fraudCheck>
					<referenceNum>'.$idCompra.'</referenceNum>
					<transactionDetail>
						<payType>
							<creditCard>
								<number>'.$this->number.'</number>
								<expMonth>'.$this->expMonth.'</expMonth>
								<expYear>'.$this->expYear.'</expYear>
								<cvvNumber>'.$this->cvvNumber.'</cvvNumber>
							</creditCard>
						</payType>
					</transactionDetail>
					<payment>
						<currencyCode>BRL</currencyCode>
						<chargeTotal>'.$chargeTotal.'</chargeTotal>
						'.$creditInstallment.'
					</payment>
				</'.$auth_ou_sale.'>
			</order>
		</transaction-request>
		';

		/*
		$xml = '<transaction-request> 
				<version>'.$this->version.'</version> 
				<verification>
					<merchantId>'.$this->merchantId.'</merchantId>
					<merchantKey>'.$this->merchantKey.'</merchantKey> 
				</verification>
				<order>
					<'.$auth_ou_sale.'>
						<processorID>1</processorID> 
						<fraudCheck>N</fraudCheck> 
						<referenceNum>'.$idCompra.'</referenceNum> 
						<transactionDetail>
							<payType>
								<creditCard>
									<number>'.$this->number.'</number>
									<expMonth>'.$this->expMonth.'</expMonth>
									<expYear>'.$this->expYear.'</expYear>
									<cvvNumber>'.$this->cvvNumber.'</cvvNumber>
								</creditCard>
							</payType>
						</transactionDetail>
						<payment>
							<currencyCode>BRL</currencyCode>
							<chargeTotal>32.7</chargeTotal>
							'.$creditInstallment.'
						</payment>
					</'.$auth_ou_sale.'>
				</order>
		</transaction-request>';
		*/




//		header('Content-type: text/xml'); echo $xml; exit;
//		echo $xml;
		$result = self::curl_xml($url , $xml);
	/*
		foreach($result as $k=>$v){
			echo '<br><br>'.$k;
			echo '<br>'.$v;
		}
		exit;
	 */
		$result->idCompra = $idCompra;
		$result->dataHora = date("Y-m-d H:i:s");

		self::salvaDados('Compras_X_Invoices' , $result);

		if($result->responseCode == '0' && $result->responseMessage == 'CAPTURED'){
			$sql = 'UPDATE Compras SET pago = 1 WHERE id = "'.$idCompra.'" AND idUser = "'.$_SESSION['idUser'].'";';
			mysqli_query($this->link , $sql);

			$sql = 'DELETE FROM Carrinho WHERE idUser = "'.$_SESSION['idUser'].'";';
			mysqli_query($this->link , $sql);

		}


		return $result;

	}// pagarCC






	public function geraBoleto($idCompra){

		$url = 'https://api.maxipago.net/ReportsAPI/servlet/ReportsAPI';

		$chargeTotal = self::getValorCompraComFrete($idCompra);

		$instructions = "Não receber após o vencimento";

		$sql = 'SELECT 
				  u.nome `name` 
				, CONCAT(ue.logradouro , ", " , ue.numero) `address` 
				, ue.complemento `address2`
				, cid.cidade `city`
				, e.sigla `state`
				, REPLACE(ue.cep , "-" , "") `postalcode`
				, "BR" `country`
				, REPLACE(REPLACE(ue.telefone , "-" , "") , " " , "") `phone`
				, ue.email
				, DATE(NOW() + INTERVAL 3 DAY) `expirationDate`
				, com.idTransportadoras_Cotacoes
			FROM Compras com
			JOIN Users_X_Enderecos ue ON ue.id = com.idUsers_X_Enderecos
			JOIN CidadesIBGE cid ON cid.id = ue.idCidade
			JOIN Users u ON u.id = com.idUser
			JOIN Estados e ON e.id = cid.idEstado
			WHERE com.id = '.$idCompra.';';

		$q = mysqli_query($this->link , $sql);
		$r = mysqli_fetch_assoc($q);


		$xml = '<transaction-request>
			<version>'.$this->version.'</version>
			<verification>
				<merchantId>'.$this->merchantId.'</merchantId>
				<merchantKey>'.$this->merchantKey.'</merchantKey>
			</verification>
			<order>
				<sale>
					<processorID>12</processorID>
					<referenceNum>'.$idCompra.'</referenceNum>
					<ipAddress>'.$_SERVER['REMOTE_ADDR'].'</ipAddress>
					<billing>
						<name>'.$r['name'].'</name>
						<address>'.$r['address'].'</address>
						<address2>'.$r['address2'].'</address2>
						<city>'.$r['city'].'</city>
						<state>'.$r['state'].'</state>
						<postalcode>'.$r['postalcode'].'</postalcode>
						<country>'.$r['country'].'</country>
						<phone>'.$r['phone'].'</phone>
						<email>'.$r['email'].'</email>
					</billing>


					<transactionDetail>
						<payType>
							<boleto>
								<expirationDate>'.$r['expirationDate'].'</expirationDate>
								<number>'.$idCompra.'</number>
								<instructions>'.$instructions.'</instructions>
							</boleto>
						</payType>
					</transactionDetail>
					<payment>
						<currencyCode>BRL</currencyCode>
						<chargeTotal>'.$chargeTotal.'</chargeTotal>
					</payment>
				</sale>
			</order>
		</transaction-request>
		';



		$result = self::curl_xml($url , $xml);
/*	
		foreach($result as $k=>$v){
			echo '<br><br>'.$k;
			echo '<br>'.$v;
		}
 */
		$result->idCompra = $idCompra;
		$result->dataHora = date("Y-m-d H:i:s");
		self::salvaDados('Compras_X_Invoices' , $result);

//		echo $result->responseCode;
//		echo "<br>---<br>";
//		echo $result->responseMessage;

		return $result;

	}// geraBoleto





	public function testaWebhook(){

		$url = 'https://www.lojadalata.com/gatilho';


		$xml = '<request>
			    <transaction-event>
				<transactionStatus>3</transactionStatus>
				<transactionType>CreditCardSale</transactionType>
				<transactionID>501043</transactionID>
				<tid>1006993069000AC96D2A</tid>
				<orderID>7F000101:015DF791E89B:C66D:79BA05A3</orderID>
				<transactionState>CAPTURED</transactionState>
				<transactionDate>08-19-2017 00:56:27</transactionDate>
				<nsu>310802</nsu>
				<merchantId>1501</merchantId>
				<transactionAmount>24.00</transactionAmount>
			    </transaction-event>
			</request>';


		$result = self::curl_xml($url , $xml);
/*	
		foreach($result as $k=>$v){
			echo '<br><br>'.$k;
			echo '<br>'.$v;
		}
 */




//		echo $result->responseCode;
//		echo "<br>---<br>";
//		echo $result->responseMessage;

		return $result;

	}// geraBoleto




	public function getStatusPagamento($transactionId){

		// Documentação
		// http://developers.maxipago.com/apidocs/maxipago/boleto-bancario/

		// Homologação
//		$url = 'https://testapi.maxipago.net/ReportsAPI/servlet/ReportsAPI';

		// Produção
		$url = 'https://api.maxipago.net/ReportsAPI/servlet/ReportsAPI';

		$xml = '<rapi-request>
				<verification>
					<merchantId>'.$this->merchantId.'</merchantId>
					<merchantKey>'.$this->merchantKey.'</merchantKey>
				</verification>
				<command>transactionDetailReport</command>
				<request>
					<filterOptions>
						<transactionId>'.$transactionId.'</transactionId>
					</filterOptions>
				</request>
			</rapi-request>';

		//echo highlight_string($xml); //xml enviado	

		$result = self::curl_xml($url , $xml);
		//print_r($xml); print_r($result); exit;

		echo "<br><br><br><hr><br><br><br><pre><strong>XML Recebido</strong><br><br>"; print_r($result); 
		//exit;

		// Na documentação o parâmetro transactionStatus, está como responseMessage.
		//O cara do suporte não soube informar o motivo... Talvez no servidor de produção essa variável seja outra.
		$statusPgto = $result->result->records->record->transactionStatus;
		//echo $statusPgto;
		return $statusPgto;

	}// getStatusPagamento





	public function getStatusPagamentosBoletos(){
		//http://developers.maxipago.com/apidocs/consultas/consulta-transacao/
		
		
		$sql2 = 'SELECT ci.id, c.pago , ci.transactionID , c.id idCompra 
			FROM Compras_X_Invoices ci
			JOIN Compras c ON c.id = ci.idCompra
			
			WHERE ci.dataPgto IS NULL
			AND DATE(ci.dataHora + INTERVAL 2 DAY) <= NOW()
			AND c.pago = 1
			;';

$qs = mysqli_query($this->link , $sql2);


while($t = mysqli_fetch_assoc($qs)){




	if($t['pago'] == 1){
		
		$sql = 'UPDATE Compras_X_Invoices SET dataPgto = NOW() WHERE id = "'.$t['id'].'";';
		mysqli_query($this->link , $sql);		

		$sql2 = 'UPDATE Compras SET pago = 1 WHERE id = '.$t['idCompra'].';';
		mysqli_query($this->link , $sql2);





				date_default_timezone_set('Etc/UTC');
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
			
				//Tell PHPMailer to use SMTP
				$mail->isSMTP();
			
				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug = 0;
			
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 'html';
			
				//Set the hostname of the mail server
				$mail->Host = 'smtplw.com.br';
				// use
				// $mail->Host = gethostbyname('smtp.gmail.com');
				// if your network does not support SMTP over IPv6
			
				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port = 587;
			
				//Set the encryption system to use - ssl (deprecated) or tls
				$mail->SMTPSecure = 'tls';
			
				//Whether to use SMTP authentication
				$mail->SMTPAuth = true;
			
				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username = "brasilata";
			
				//Password to use for SMTP authentication
				$mail->Password = "zomeSzRz4278";
			
				//Set who the message is to be sent from
				$mail->setFrom('recuperarsenha@lojadalata.com.br', 'Loja da Lata');
			
				//Set an alternative reply-to address
				$mail->addReplyTo('contato@lojadalata.com.br', 'Loja da Lata');
			
				//Set who the message is to be sent to
				$mail->addAddress('contato@lojadalata.com.br', $r['nome']);
			
				//Set the subject line
				$mail->Subject = 'BOLETO APROVADO! ';
			
				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			
				$mail->msgHTML(utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
				  <head>
					<meta name="viewport" content="width=device-width, initial-scale=1.0" />
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>Recuperar Senha - Loja da Lata</title>
			
			
				  </head>
				  <body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#34373b"><style type="text/css">
				body {
				width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #34373b; color: #74787E; -webkit-text-size-adjust: none;
				}
				@media only screen and (max-width: 600px) {
				  .email-body_inner {
					width: 100% !important;
				  }
				  .email-footer {
					width: 100% !important;
				  }
				}
				@media only screen and (max-width: 500px) {
				  .button {
					width: 100% !important;
				  }
				}
				</style>
					<span class="preheader" style="box-sizing: border-box; display: none !important; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; mso-hide: all; opacity: 0; overflow: hidden; visibility: hidden;">BOLETO APROVADO </span>
					<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#34373b">
					  <tr>
						<td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
						  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
							<tr>
							  <td class="email-masthead" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
								<a href="https://example.com" class="email-masthead_name" style="box-sizing: border-box; color: #bbbfc3; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
								  <img src="https://www.lojadalata.com/images/logo.png" title="Loja da lata">
								</a>
							  </td>
							</tr>
			
							<tr>
							  <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #34373b; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
								<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">
			
								  <tr>
									<td class="content-cell" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
									  <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Boleto Nº '.$r['transactionID'].',</h1>
									  <p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Cliente: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">Richard Geraldo</strong></p>
			
			
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Pedido: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">'.$r['idCompra'].'</strong></p>
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Total: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">R$ 249,30</strong></p>
			
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Status: <strong style="box-sizing: border-box;  color:green;font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">APROVADO!</strong></p>
			
			<br>
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">orderID: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">'.$r['orderID'].'</strong></p>
			
			
			
									  <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
										<tr>
										  <td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
			
											<table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
											  <tr>
												<td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
												  <table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
													<tr>
													
													  </td>
													</tr>
												  </table>
												</td>
											  </tr>
											</table>
										  </td>
										</tr>
									  </table>
						 
			
									  <table class="body-sub" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin-top: 25px; padding-top: 25px;">
					   
										  </td>
										</tr>
									  </table>
									</td>
								  </tr>
								</table>
							  </td>
							</tr>
							<tr>
							  <td style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
								<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
								  <tr>
									<td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
									  <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">© '.date('Y').' Loja da Lata. Todos Direitos Reservados.</p>
									  <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">
										Loja da Lata, LDL
										<br />Rua Robert Bosh, 450.
										<br />Barra Funda, São Paulo, SP, 01141-010
									  </p>
									</td>
								  </tr>
								</table>
							  </td>
							</tr>
						  </table>
						</td>
					  </tr>
					</table>
				  </body>
				</html>'));
			
			
			
			
				//send the message, check for errors
				if (!$mail->send()) {
				//    echo "Mailer Error: " . $mail->ErrorInfo;
			
				} else {
			
			
				}
				
			
			
			
			}else{
			  voltar('Email incorreto.');
			}
		}

		
	
		
		
		
		$sql = 'SELECT formata_real(cp.valor * qtde)total, us.nome, ci.id, ci.transactionID, ci.orderID, c.id idCompra 
		FROM Compras_X_Invoices ci
		JOIN Compras c ON c.id = ci.idCompra
		JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
		JOIN Users us ON us.id = c.idUser
		WHERE ci.boletoUrl IS NOT NULL
		AND ci.dataPgto IS NULL
		AND DATE(ci.dataHora + INTERVAL 2 DAY) <= NOW()
		AND ci.dataHora> (NOW()-INTERVAL 7 DAY) 
		AND c.pago = 0;';

		$q = mysqli_query($this->link , $sql);

	//	var_dump($r);
	//		die();

		while($r = mysqli_fetch_assoc($q)){

			

			$statusPgto = self::getStatusPagamento($r['transactionID']);



			//if($statusPgto == 'Approved'){
				// Supondo que o Approved signifique que o boleto foi pago
		
			if($statusPgto == 'Settled'){
				// Supondo que o Settled signifique que o boleto foi pago
				$sql = 'UPDATE Compras_X_Invoices SET dataPgto = NOW() WHERE id = "'.$r['id'].'";';
				mysqli_query($this->link , $sql);		
		
				$sql2 = 'UPDATE Compras SET pago = 1 WHERE id = '.$r['idCompra'].';';
				mysqli_query($this->link , $sql2);


				date_default_timezone_set('Etc/UTC');
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
			
				//Tell PHPMailer to use SMTP
				$mail->isSMTP();
			
				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug = 0;
			
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 'html';
			
				//Set the hostname of the mail server
				$mail->Host = 'smtplw.com.br';
				// use
				// $mail->Host = gethostbyname('smtp.gmail.com');
				// if your network does not support SMTP over IPv6
			
				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port = 587;
			
				//Set the encryption system to use - ssl (deprecated) or tls
				$mail->SMTPSecure = 'tls';
			
				//Whether to use SMTP authentication
				$mail->SMTPAuth = true;
			
				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username = "brasilata";
			
				//Password to use for SMTP authentication
				$mail->Password = "zomeSzRz4278";
			
				//Set who the message is to be sent from
				$mail->setFrom('noreply@lojadalata.com.br', 'Loja da Lata');
			
				//Set an alternative reply-to address
			
				//Set who the message is to be sent to
				$mail->addAddress('contato@lojadalata.com.br', $r['nome']);
			
				//Set the subject line
				$mail->Subject = 'BOLETO APROVADO! ';
			
				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			
				$mail->msgHTML(utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
				  <head>
					<meta name="viewport" content="width=device-width, initial-scale=1.0" />
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>Recuperar Senha - Loja da Lata</title>
			
			
				  </head>
				  <body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#34373b"><style type="text/css">
				body {
				width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #34373b; color: #74787E; -webkit-text-size-adjust: none;
				}
				@media only screen and (max-width: 600px) {
				  .email-body_inner {
					width: 100% !important;
				  }
				  .email-footer {
					width: 100% !important;
				  }
				}
				@media only screen and (max-width: 500px) {
				  .button {
					width: 100% !important;
				  }
				}
				</style>
					<span class="preheader" style="box-sizing: border-box; display: none !important; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; mso-hide: all; opacity: 0; overflow: hidden; visibility: hidden;">.</span>
					<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#34373b">
					  <tr>
						<td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
						  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
							<tr>
							  <td class="email-masthead" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
								<a href="https://example.com" class="email-masthead_name" style="box-sizing: border-box; color: #bbbfc3; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
								  <img src="https://www.lojadalata.com/images/logo.png" title="Loja da lata">
								</a>
							  </td>
							</tr>
			
							<tr>
							  <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #34373b; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
								<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">
			
								  <tr>
									<td class="content-cell" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
									  <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Boleto ID Nº '.$r['transactionID'].',</h1>
									  <p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Cliente: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">'.$r['nome'].'</strong></p>
			
			
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Pedido: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">'.$r['idCompra'].'</strong></p>
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Total: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;"> '.$r['total'].'</strong></p>
			
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Status: <strong style="box-sizing: border-box;  color:green;font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">APROVADO!</strong></p>
			
			<br>
			<p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">orderID: <strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">'.$r['orderID'].'</strong></p>
			
			
			
									  <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
										<tr>
										  <td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
			
											<table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
											  <tr>
												<td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
												  <table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
													<tr>
													
													  </td>
													</tr>
												  </table>
												</td>
											  </tr>
											</table>
										  </td>
										</tr>
									  </table>
						 
			
									  <table class="body-sub" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin-top: 25px; padding-top: 25px;">
					   
										  </td>
										</tr>
									  </table>
									</td>
								  </tr>
								</table>
							  </td>
							</tr>
							<tr>
							  <td style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
								<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
								  <tr>
									<td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
									  <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">© '.date('Y').' Loja da Lata. Todos Direitos Reservados.</p>
									  <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">
										Loja da Lata, LDL
										<br />Rua Robert Bosh, 450.
										<br />Barra Funda, São Paulo, SP, 01141-010
									  </p>
									</td>
								  </tr>
								</table>
							  </td>
							</tr>
						  </table>
						</td>
					  </tr>
					</table>
				  </body>
				</html>'));
			
			
			
			
				//send the message, check for errors
				if(!$mail->Send()) {
					echo "A mensagem não foi enviada.";
					echo "Mensagem de erro: " . $mail->ErrorInfo;
				  } else {
					echo "Mensagem enviada!";
				  }
								  
			
			
			
			}

			

//			echo "<br>".$r['transactionID']."->".$pago;
		}//while

	}// getStatusPagamentosBoletos



} // fecha classe MaxiPago


//$MaxiPago = new MaxiPago();

//$MaxiPago->setCreditCard(4111111111111111 , 12 , 2020 , 999);
//$valor = 20.00;
//$idCompra = 3;
//$MaxiPago->pagarCC($valor , $idCompra);
//$MaxiPago->geraBoleto($valor , $idCompra);


$MaxiPago = new MaxiPago();
//$getStatusPagamento = $MaxiPago->getStatusPagamento('321124847'); 

// $getStatusPagamento = $MaxiPago->getStatusPagamento('348047140'); // boleto
//$getStatusPagamento = $MaxiPago->getStatusPagamento('5060692'); // cartao



$MaxiPago->getStatusPagamentosBoletos();



//$boleto->responseCode 
//$boleto->responseMessage
//$boleto->boletoUrl;
/*
echo "<pre>";
print_r($getStatusPagamento);
echo "</pre><br><br>";
 */
//echo $boleto->responseCode;
//echo "<br><br>".$boleto->responseMessage;


?>
