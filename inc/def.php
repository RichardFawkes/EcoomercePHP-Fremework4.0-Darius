<?php
//	phpinfo(); exit;
	ini_set('session.cookie_lifetime', 86400);
	ini_set('session.gc_maxlifetime', 86400);
	ini_set('session.cache_expire', 1440);
	session_set_cookie_params(86400); // Grava o id da sessão por exatas 1hr.
	session_start();





	if(@$_SESSION['idUser'] == '' || @$_SESSION['idUser']==2) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

	} else {
		ini_set('display_errors',0);
	}


  date_default_timezone_set('America/Sao_Paulo');
  // Verifica se o host é compatível.
	switch($_SERVER['HTTP_HOST']) {

		case 'localhost':
			$site = 'http://localhost/LDL/';
			$editor = 'https://15b4c9ce.printnow.com/online-editor?epi=';
			$editorpdf = 'https://15b4c9ce.printnow.com/download.ashx?token=a1b2c3d4&pid=';
			$editorview ='https://15b4c9ce.printnow.com/productthumb.ashx?p=';

			$siteHD = '/Applications/XAMPP/xamppfiles/htdocs/LDL/';
			$link = mysqli_connect('localhost','root','root','LojaDaLataDB');
			$rot =  "http://localhost/LDL/adm/";
			break;

		case 'localhost:8888':
			$site = 'http://localhost:8888/LDL/';
			$siteHD = '/Applications/MAMP/htdocs/LDL/';
			$link = mysqli_connect('localhost','root','root','LojaDaLata');
			break;




		case 'lojadalata.com':
		case 'www.lojadalata.com':

        	        // Força https
	                if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
//                      	$site = 'https://'.$_SERVER['HTTP_HOST'].'/';
                	        $site = 'https://www.lojadalata.com/';

        	        }else{
//	                      header('Location: https://' . $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
				header('Location: https://www.lojadalata.com'.$_SERVER['REQUEST_URI']);
        	                exit;
	                }

//			$site = 'http://'.$_SERVER['HTTP_HOST'].'/Loja/';
			$siteHD = $_SERVER['DOCUMENT_ROOT'].'/';
			$editor = 'http://editor.lojadalata.com/online-editor?epi=';
			$editorlink = 'http://editor.lojadalata.com/';
			$editorpdf = 'http://editor.lojadalata.com/download.ashx?token=a1b2c3d4&pid=';
			$editorview ='http://editor.lojadalata.com/productthumb.ashx?p=';

//			$rot = 'https://'.$_SERVER['HTTP_HOST'].'/'.$dirAdicional.'/adm/';
			$rot =  "https://www.lojadalata.com/adm/";
			$link = mysqli_connect("localhost", "LojaDaLataDBuser", "mpXt29@2", "LojaDaLataDB") or die('SEM CONEXÃO');
			mysqli_set_charset($link, "utf8");
			break;


	}

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



        function formata_real($valor){
                return 'R$'.number_format($valor, 2, ',', '.');
        }



	// Criando usuário caso não esteja logado. Usamos isso para salvar no Carrinho.
	if(!isset($_SESSION['idUser']) || is_null($_SESSION['idUser'])){
		$sql = 'INSERT INTO Users (id) VALUES (NULL);';
		$q = mysqli_query($link , $sql);
		$ultimoId = mysqli_insert_id($link);

		$_SESSION['idUser'] = $ultimoId;
		$_SESSION['tempUser'] = 1;

		unset($ultimoId);
	}




	if(isset($_SESSION['idUser']) || !is_null($_SESSION['idUser'])){
		$sqlTracking = 'INSERT INTO UsersTracking (idUser , url , ip , dataHora) VALUES('.$_SESSION['idUser'].' , "'.$_SERVER['REQUEST_URI'].'" , "'.$_SERVER['REMOTE_ADDR'].'" , NOW());';
		mysqli_query($link , $sqlTracking);
	}







	function libera_acesso($idH1 , $idH2 = '0' , $idH3 = 0 , $idH4 = '0' , $idH5 = '0'){
		global $site;
    // Compara a(s) hierarquia(s) declarada(s).
		if( (!isset($_SESSION['id_hierarquia'])) || (($_SESSION['id_hierarquia'] != $idH1) && ($_SESSION['id_hierarquia'] != $idH2) && ($_SESSION['id_hierarquia'] != $idH3) && ($_SESSION['id_hierarquia'] != $idH4) && ($_SESSION['id_hierarquia'] != $idH5))	 ){
			//session_destroy();
			unset($_SESSION['id_hierarquia']);

			echo '
				<html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<script type="text/javascript" charset="UTF-8">
							alert("Área restrita! Você precisa estar logado para acessar estas informações.");
							window.top.location = "'.$site.'adm/index"
						</script>
					</head>
				</html>
			';
			exit;
		}
	}

	function libera_acessoSite($idH1 , $idH2 = 2 , $idH3 = 0 , $idH4 = '0' , $idH5 = '0'){
		global $site;
    // Compara a(s) hierarquia(s) declarada(s).
		if( (!isset($_SESSION['idHierarquia'])) || (($_SESSION['idHierarquia'] != $idH1) && ($_SESSION['idHierarquia'] != $idH2) && ($_SESSION['idHierarquia'] != $idH3) && ($_SESSION['idHierarquia'] != $idH4) && ($_SESSION['idHierarquia'] != $idH5))	 ){
			//session_destroy();
			unset($_SESSION['idHierarquia']);

			echo '
				<html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<script type="text/javascript" charset="UTF-8">
							alert("Área restrita! Você precisa estar logado para acessar estas informações.");
							window.top.location = "'.$site.'"
						</script>
					</head>
				</html>
			';
			exit;
		}
	}
/*
	function voltar() {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
*/

	function voltar($msg = ''){
		if($msg != '') {
			echo '<script type="text/javascript">alert(\''.$msg.'\');window.location.href = document.referrer;</script>';
		} else {
			echo '<script type="text/javascript">window.location.href = document.referrer;</script>';
		}
		exit;
	}


	function ir($url , $msg='') {
		if($msg != ''){
			echo '<script type="text/javascript">alert(\''.$msg.'\');</script>';
		}
		echo '<script type="text/javascript">window.location.href = "'.$url.'";</script>';
	}


  // Para usar.
  //echo formata_data_extenso('2007-04-17 15:20:35');
  // Data de hoje
  // echo formata_data_extenso(date('Y-m-d H:i:s'));
  function formata_data_extenso($strDate) {
    // Array com os dia da semana em português;
    $arrDaysOfWeek = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
    // Array com os meses do ano em português;
    $arrMonthsOfYear = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
    // Descobre o dia da semana
    $intDayOfWeek = date('w',strtotime($strDate));
    // Descobre o dia do mês
    $intDayOfMonth = date('d',strtotime($strDate));
    // Descobre o mês
    $intMonthOfYear = date('n',strtotime($strDate));
    // Descobre o ano
    $intYear = date('Y',strtotime($strDate));
    // Formato a ser retornado
    return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
  }


	function clean($string) {
    return preg_replace('/[^A-Za-z0-9À-ú\ ]/', '', $string); // Removes special chars.
	}

  //	echo clean('a|"bc!@£de^&$f g');
  //	echo '<br /><br />';
  //	echo clean('VocêçÇã Testando acentuação');


	// Data/Hora Formato BR
	function data_hora_formatoBR($var){
		$var = date('d/m/Y - H:m:s', strtotime($var));
		return $var;
	}


  //$string="olá à mim! ñ";
  function tirarAcentos($string){
  	$string = str_replace(' ' , '_', $string);
  	$string = str_replace('?' , '', $string);
  	$string = str_replace('!' , '', $string);
  	$string = str_replace('@' , '', $string);
  	$string = str_replace('#' , '', $string);
  	$string = str_replace('$' , '', $string);
  	$string = str_replace('%' , '', $string);
  	$string = str_replace('&' , '', $string);
  	$string = str_replace('*' , '', $string);
  	$string = str_replace('.' , '', $string);
  	$string = str_replace(':' , '', $string);

    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
  }

  //echo tirarAcentos($string);





	function aviso($msg){
		echo '<span style="color:red;">'.$msg.'</span>';
	}


  // Função abaixo, monta a tabela automaticamente, conforme o resultado da Query.
  function queryTabela($sql,$classe_tabela = 'table table-striped'){
  	global $link;

  	$q = mysqli_query($link , $sql)  or die(mysqli_error($link));

  	//Obtém o número de campos do resultado
    $num_fields = mysqli_num_fields($q);

    //Montando o cabeçalho da tabela
    $table = '<table class="'.$classe_tabela.'"><tr>';

  	//Pega o nome dos campos
    while ($fieldinfo = mysqli_fetch_field($q)){
      $table .= '<th>'.$fieldinfo->name.'</th>';
    }

    //Montando o corpo da tabela
    $table .= '<tbody>';
    while($r = mysqli_fetch_array($q)){
    	$table .= '<tr>';

    	for($i = 0;$i < $num_fields; $i++){
    		$table .= '<td>'.$r[$i].'</td>';
    	}

      $table .= '</tr>';
    }

    //Finalizando a tabela
    $table .= '</tbody></table>';

    //Imprimindo a tabela
    echo $table;
  }

  // Função para gerar tabela para o excel
	function queryTabela2($sql,$classe_tabela = ''){
		global $link;

		$q = mysqli_query($link , $sql)  or die(mysqli_error($link));

		//Obtém o número de campos do resultado
		$num_fields = mysqli_num_fields($q);

		//Montando o cabeçalho da tabela
		$table = '<table '.$classe_tabela.'" border="1"><tr>';

		//Pega o nome dos campos
		while ($fieldinfo = mysqli_fetch_field($q)){
			$table .= '<th>'.$fieldinfo->name.'</th>';
		}

		//Montando o corpo da tabela
		$table .= '<tbody>';
		while($r = mysqli_fetch_array($q)){
			$table .= '<tr>';

			for($i = 0;$i < $num_fields; $i++){
				$table .= '<td>'.$r[$i].'</td>';
			}

			$table .= '</tr>';
		}

		//Finalizando a tabela
		$table .= '</tbody></table>';

		//Imprimindo a tabela
		echo $table;
	}





	// Limita caracteres
	function limita_caracteres($texto, $limite, $quebra = true){
		$tamanho = strlen($texto);
		if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
			$novo_texto = $texto;
		}else{ // Se o tamanho do texto for maior que o limite
			if($quebra == true){ // Verifica a opção de quebrar o texto
				$novo_texto = trim(substr($texto, 0, $limite))."...";
			}else{ // Se não, corta $texto na última palavra antes do limite
				$ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
				$novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
			}
		}
		return $novo_texto; // Retorna o valor formatado
	}

	//Gerador de slug
	function slugify($text){
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		// trim
		$text = trim($text, '-');
		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);
		// lowercase
		$text = strtolower($text);
		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}






	function postit($mensagem , $assinatura , $cor = 'yellow'){
		global $site;

		echo '<link rel="stylesheet" type="text/css" href="'.$site.'adm/css/postit.css"/>';
		echo '
      <div id="postitContainer" class="quote-container" onclick="document.getElementById(\'postitContainer\').style.display=\'none\'">
				<i class="pin"></i>
				<i class="fecharPostit"></i>
				<blockquote class="note '.$cor.'">
				'.$mensagem.'
				<cite class="author">'.$assinatura.'</cite>
				</blockquote>
			</div>
		';
	}
	// 	postit("teste 1","João");

	// FUNCAO PARA CONVERTER HEX TO RGB | OPT opacidade
	function hex2rgba($color, $opacity = false) {

	  $default = 'rgb(0,0,0)';

	  //Return default if no color provided
	  if(empty($color))
	  return $default;

	  //Sanitize $color if "#" is provided
	  if ($color[0] == '#' ) {
	    $color = substr( $color, 1 );
	  }

	  //Check if color has 6 or 3 characters and get values
	  if (strlen($color) == 6) {
	    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	  } elseif ( strlen( $color ) == 3 ) {
	    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	  } else {
	    return $default;
	  }

	  //Convert hexadec to rgb
	  $rgb =  array_map('hexdec', $hex);

	  //Check if opacity is set(rgba or rgb)
	  if($opacity){
	    if(abs($opacity) > 1)
	    $opacity = 1.0;
	    $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	  } else {
	    $output = 'rgb('.implode(",",$rgb).')';
	  }

	  //Return rgb(a) color string
	  return $output;
	}

	// válida se é mobile
	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}


	// Tira o style
    function clean_style($var){
        $var = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/","",$var);
        $var = trim($var);//limpa espaços vazio
        $var = addslashes($var);//Adiciona barras invertidas a uma string
        $var = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $var);
        return $var;
    }




?>
