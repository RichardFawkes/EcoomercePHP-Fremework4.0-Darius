<?php
/*********************************************
* Change this line to set the upload folder *
*********************************************/
// $imageFolder = "http://".$_SERVER['HTTP_HOST']."/UPLOAD/";
// $listadir = NULL;
reset ($_FILES);
$temp = current($_FILES);
require_once('../../inc/def.php');


if (is_uploaded_file($temp['tmp_name'])){
	// Sanitize input
	if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		header("HTTP/1.0 501 Invalid file name.");
		return;
	}

	// Verify extension
	if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
		header("HTTP/1.0 502 Invalid extension.");
		return;
	}

	// Accept upload if there was no origin, or if it is an accepted origin
	// Monta o nome do arquivo.
	$dir = "../../images/faq/";
	$dir2 = $site."images/faq/";
	$listadir = scandir($dir);
	$cont = count($listadir) - 1;
	$fileExt  = strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
	// nome contador
	$newfile = $cont;
	require_once('../../inc/cria_miniatura.php');
	// Grava o arquivo com o novo nome e da o resize.
	resize(425, $dir.$newfile, $temp['tmp_name']);


	// Respond to the successful upload with JSON.
	// Use a location key to specify the path to the saved image resource.
	echo json_encode(array('location' => $dir2.$newfile.".".$fileExt));

} else {
	// Notify editor that the upload failed
	header("HTTP/1.0 503 Server Error");
}

?>
