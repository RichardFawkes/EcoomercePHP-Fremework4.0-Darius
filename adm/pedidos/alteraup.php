<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");

$sql = 'UPDATE Compras 
SET pago = 1 WHERE id='.$_GET['id'].';';

$row = mysqli_query($link,$sql);




voltar();

?>