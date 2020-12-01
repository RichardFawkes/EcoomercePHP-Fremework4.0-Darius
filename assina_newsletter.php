<?php

	require_once('inc/def.php');

	if(isset($_SESSION['idUser'])){
		$idUser = $_SESSION['idUser'];
	}else{
		$idUser = 'NULL';
	}
	

	$sql = 'INSERT INTO Newsletter (idUser , email , ip , dataHora) VALUES ( '.$idUser.' , "'.$_POST['email_newsletter'].'" , "'.$_SERVER['REMOTE_ADDR'].'" , NOW());';

	mysqli_query($link , $sql) or die(mysqli_error($link));

	voltar('Assinatura feita com sucesso!');
?>

