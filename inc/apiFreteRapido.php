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
		return $json;
//		$result = self::curl($url , $json);
//		return json_decode($result, true);

	}//calculaFrete

}//classe






$freteRapido = new FreteRapido();
echo $freteRapido->calculaFrete();
exit;

//var_dump($freteRapido->calculaFrete());
$fretes = $freteRapido->calculaFrete();
echo $fretes['token_oferta'];
echo '<br>';
var_dump($fretes['transportadoras']);

?>
