<?php
header("Content-type:application/json");

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


		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}//curl




	public function contrataFrete(){
/*
		$sql = 'SELECT token_oferta , oferta FROM Transportadoras_Cotacoes WHERE id = 1;';
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);


		$tokenOferta = $r['token_oferta'];
		$oferta = $r['oferta'];




		$url = 'https://freterapido.com/api/external/embarcador/v1/quote/ecommerce/'.$tokenOferta.'/offer/'.$oferta.'?token='.$this->token;
*/
		$url = 'https://freterapido.com/api/external/embarcador/v1/quote/ecommerce/9545cd084ce5038b/offer/1127848?token=71f93a24558ffabfed271d9bd2b17343';


                $tipo_pessoa = 2;
                $cnpj_cpf = '69111653000144';
                $inscricao_estadual = '123456';
                $cep = '99585000';

		$json = array(
			'remetente'=>array(
				'cnpj'=> $this->cnpjLDL
			)
			,'destinatario'=>array(
				'tipo_pessoa'=>$tipo_pessoa,
				'cnpj_cpf'=> $cnpj_cpf,
				'inscricao_estadual'=>$inscricao_estadual,
				'endereco'=>array(
					'cep'=>$cep
				)
			)

			,'codigo_plataforma'=> $this->codigo_plataforma
			,'token'=> $this->token
			
		  );

		$json = json_encode($json,true);
		return $json; exit;
/*
		$result = self::curl($url , $json);

		$result = json_decode($result, true);

		return $result;
*/
	}//contrataFrete





	public function calculaFrete(){
//		$tipo_pessoa = 2;
//		$cnpj_cpf = '69111653000144';
//		$inscricao_estadual = '123456';
//		$cep = '99585000';


		$sql = 'SELECT cnpj , inscricao_estadual , cep , tipo_pessoa FROM Users WHERE id = '.$_SESSION['idUser'].';';
		$q = mysqli_query($this->link , $sql) or die(mysqli_errno($this->link));
		$r = mysqli_fetch_assoc($q);
		$cnpj_cpf = $r['cnpj'];
		$inscricao_estadual = $r['inscricao_estadual'];
		$cep = $r['cep'];
		$tipo_pessoa = intval($r['tipo_pessoa']);




		$url = 'https://freterapido.com/api/external/embarcador/v1/quote-simulator';



		$sql = 'SELECT * 
			FROM Carrinho c
			JOIN Produtos p ON p.id = c.idProduto
			WHERE c.idUser = '.$_SESSION['idUser'].';';
		$q = mysqli_query($this->link , $sql);
		$volumes = array();

		while($r = mysqli_fetch_assoc($q)){

			array_push($volumes,array(
				'tipo'=> 20,
				'sku'=> $r['idProduto'],
				'descricao'=> $r['descricao'],
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
				'cnpj_cpf'=> $cnpj_cpf,
				'inscricao_estadual'=>$inscricao_estadual,
				'endereco'=>array(
					'cep'=>$cep
				)
			)
			,'volumes'=>$volumes
			,'codigo_plataforma'=> $this->codigo_plataforma
			,'token'=> $this->token
			
		  );

		$json = json_encode($json,true);
//		return $json; exit;
		$result = self::curl($url , $json);

		$result = json_decode($result, true);

		$sql = 'UPDATE Transportadoras_Cotacoes SET ativo = 0 WHERE idUser = "'.$_SESSION['idUser'].'";';
		mysqli_query($this->link , $sql);


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

			$sql = 'INSERT INTO Transportadoras_Cotacoes (idUser , idTransportadora , token_oferta , oferta , prazo_entrega , validade , custo_frete , preco_frete , servico)
				VALUES ("'.$_SESSION['idUser'].'" , "'.$idTransportadora.'" , "'.$result['token_oferta'].'" , "'.$v['oferta'].'" , "'.$v['prazo_entrega'].'" , "'.$v['validade'].'" , "'.$v['custo_frete'].'" , "'.$v['preco_frete'].'" , "'.$v['servico'].'");';
			mysqli_query($this->link , $sql);
			
		}


//		return $result;

	}//calculaFrete





}//classe






$freteRapido = new FreteRapido();
echo $freteRapido->contrataFrete();exit;

//echo $freteRapido->calculaFrete();exit;
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


?>

