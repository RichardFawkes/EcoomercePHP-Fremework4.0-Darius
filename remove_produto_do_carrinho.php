<?php
	require_once('inc/def.php');
	require_once($siteHD.'inc/carrinho.php');

	$carrinho = new Carrinho;
	$carrinho->removeProduto($_GET['idCarrinho']);
	
	voltar();
?>

