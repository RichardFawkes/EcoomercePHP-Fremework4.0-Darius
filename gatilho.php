<?php
	
	//https://dev.iugu.com/docs/referencias-gatilhos

	require_once('inc/def.php');





/*
	if($_POST['event'] == 'invoice.status_changed' && $_POST['data']['status'] == 'paid') {
	
		$sql = 'UPDATE Compras_X_Invoices SET pago = "1" WHERE invoiceIUGU = "'.$_POST['data']['id'].'";';
		mysqli_query($link , $sql);



                $sql = 'UPDATE Compras SET pago = "1" WHERE id = (SELECT idCompra FROM Compras_X_Invoices WHERE invoiceIUGU = "'.$_POST['data']['id'].'");';
		mysqli_query($link , $sql);


	        



		// Verifica se utilizaram cupom nesta compra
		$sql = 'SELECT idCupom FROM Compras WHERE id = (SELECT idCompra FROM Compras_X_Invoices WHERE invoiceIUGU = "'.$_POST['data']['id'].'");';
		$q = mysqli_query($link , $sql);
		$r = mysqli_fetch_assoc($q);


		// Se usaram cupom, marca que foi usado
		if(!is_null($r['idCupom'])){
			$sqlCupom = 'UPDATE Cupons SET dataUtilizacao = NOW() WHERE id = '.$r['idCupom'];
        		mysqli_query($link , $sqlCupom);
		}
	}
 */
?>
