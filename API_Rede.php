<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//ini_set("allow_url_fopen", 1);

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

		$this->version = '3.1.1.15';

		// ID de Loja
		// $this->merchantId = '9543'; // Homologação
		$this->merchantId = '44851'; // Produção

		// Chave
		// $this->merchantKey = 'l7ew3o3wr58egpmljow8omhi'; // Homologação
		$this->merchantKey = 'z6v1hfulxrjt7akdulnwaav1'; // Produção

	}

	protected function curl_xml($url , $xml) {

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //connection timeout in seconds

		$result = curl_exec($ch);

		/*
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
		*/

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







	public function pagarCC($idCompra,$parcelas=1){

		// $url = 'https://testapi.maxipago.net/UniversalAPI/postXML'; // Homologação
		$url = 'https://api.maxipago.net/UniversalAPI/postXML'; // Produção

		//$auth_ou_sale = 'auth';
		$auth_ou_sale = 'sale';

		$chargeTotal = self::getValorCompraComFrete($idCompra);
//		echo $chargeTotal; exit;
//		$chargeTotal = 1649.9;
//		$chargeTotal = 32.7;

		if(isset($parcelas) && !is_null($parcelas) && $parcelas != '' && $parcelas > 1){
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
			$sql = 'SELECT idUser FROM Compras WHERE id = "'.$idCompra.'";';
			$q = mysqli_query($this->link , $sql);
			$r = mysqli_fetch_assoc($q);
			$idUser = $r['idUser'];

			$sql = 'UPDATE Compras SET pago = 1, parcelas='.$parcelas.' WHERE id = "'.$idCompra.'" AND idUser = "'.$idUser.'";';
			mysqli_query($this->link , $sql);

			$sql = 'DELETE FROM Carrinho WHERE idUser = "'.$idUser.'";';
			mysqli_query($this->link , $sql);

		}


		return $result;

	}// pagarCC






	public function geraBoleto($idCompra){

		//$url = 'https://testapi.maxipago.net/UniversalAPI/postXML'; // homologação
		$url = 'https://api.maxipago.net/UniversalAPI/postXML'; // produção

		$chargeTotal = self::getValorCompraComFrete($idCompra);

		$instructions = "Não receber após o vencimento";

		$sql = 'SELECT
				  ue.cpf
				, ue.cnpj
				, ue.tipo_pessoa
				, CONCAT(ue.nome , " " , ue.sobrenome) `name`
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

			JOIN Estados e ON e.id = cid.idEstado
			WHERE com.id = '.$idCompra.';';
//echo $sql; exit;
		$q = mysqli_query($this->link , $sql);
		$r = mysqli_fetch_assoc($q);

		$cpf_cnpj = ($r['tipo_pessoa'] == 'PF' ? $r['cpf'] : $r['cnpj']);

		$xml = '<transaction-request>
			<version>'.$this->version.'</version>
			<verification>
				<merchantId>'.$this->merchantId.'</merchantId>
				<merchantKey>'.$this->merchantKey.'</merchantKey>
			</verification>



			<order>
				<sale>
					<processorID>11</processorID>
					<referenceNum>'.$idCompra.'</referenceNum>
					<ipAddress>'.$_SERVER['REMOTE_ADDR'].'</ipAddress>
					<customerIdExt>'.$cpf_cnpj.'</customerIdExt>
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
//echo $xml; exit;


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




	public function getStatusPagamento($transactionId){

		// Documentação
		// http://developers.maxipago.com/apidocs/maxipago/boleto-bancario/

		//$url = 'https://testapi.maxipago.net/ReportsAPI/servlet/ReportsAPI'; // homologação

		$url = 'https://api.maxipago.net/UniversalAPI/postXML'; // produção


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



		$result = self::curl_xml($url , $xml);

		// Na documentação o parâmetro transactionStatus, está como responseMessage.
		//O cara do suporte não soube informar o motivo... Talvez no servidor de produção essa variável seja outra.
		$statusPgto = $result->result->records->record->transactionStatus;

		return $statusPgto;

	}// getStatusPagamento





	public function getStatusPagamentosBoletos(){

		$sql = 'SELECT ci.id , ci.transactionID , c.id idCompra
			FROM Compras_X_Invoices ci
			JOIN Compras c ON c.id = ci.idCompra
			WHERE ci.boletoUrl IS NOT NULL
			AND ci.dataPgto IS NULL
			AND DATE(ci.dataHora + INTERVAL 3 DAY) >= NOW()
			AND c.pago = 0;';

		$q = mysqli_query($this->link , $sql);

		while($r = mysqli_fetch_assoc($q)){

			$statusPgto = self::getStatusPagamento($r['transactionID']);

			if($statusPgto == 'Viewed'){
				$pago = 0;

			}elseif($statusPgto == 'ISSUED' || $statusPgto == 'Captured'){
				$pago = 1;
				$sql = 'UPDATE Compras_X_Invoices SET dataPgto = NOW() WHERE id = "'.$r['id'].'";';
				mysqli_query($this->link , $sql);
			}else{
				$pago = 2;
			}

			if(isset($statusPgto) && $statusPgto != ''){
				$sql = 'UPDATE Compras SET pago = '.$pago.' WHERE id = '.$r['idCompra'].';';
				mysqli_query($this->link , $sql);
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



// ROTINA pra verificar pagamentos dos Boletos
//$MaxiPago = new MaxiPago();
//$getStatusPagamento = $MaxiPago->getStatusPagamento('5156452'); // boleto
//$getStatusPagamento = $MaxiPago->getStatusPagamento('5060692'); // cartao
//$MaxiPago->getStatusPagamentosBoletos();


?>
