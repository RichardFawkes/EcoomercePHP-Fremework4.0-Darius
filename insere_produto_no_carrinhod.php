<?php
	require_once('inc/def.php');
	require_once($siteHD.'inc/carrinho.php');

	$qtde = (!isset($_POST['qtde']) ? 1 : $_POST['qtde']);
	if(isset($_POST['qtde']) && is_numeric($_POST['qtde'])){
		$qtde =  $_POST['qtde'];
	}else{
		$qtde = 1;
	}

	$idCorSelecionada = (!isset($_POST['idCorSelecionada']) ? 1 : $_POST['idCorSelecionada']);
	if(isset($_POST['idCorSelecionada']) && is_numeric($_POST['idCorSelecionada'])){
		$idCorSelecionada =  $_POST['idCorSelecionada'];
	}else{
		$idCorSelecionada = 1;
	}




	$carrinho = new Carrinho;
	$carrinho->insereProduto($_POST['idProduto'] , $qtde , $idCorSelecionada);
	$_SESSION['open_cart'] = 1;
	voltar();
?>
