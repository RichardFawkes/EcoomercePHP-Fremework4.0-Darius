<?php
	require_once('inc/def.php');

	foreach($_POST as $k=>$v){

		$idCarrinho = str_replace('quanitySniper','',$k);
/*
		echo "<br><br>K: ".$k;
		echo "<br>V: ".$v;
		echo "<br>idCarrinho: ".$idCarrinho;
*/
		if(is_numeric($v) && is_numeric($idCarrinho)){
			$sql = 'UPDATE Carrinho SET qtde = "'.$v.'" WHERE id = "'.$idCarrinho.'" AND idUser = "'.$_SESSION['idUser'].'";';
//			echo '<br>'.$sql.'<br>';
			mysqli_query($link , $sql);
		}
	}

	voltar();
?>

