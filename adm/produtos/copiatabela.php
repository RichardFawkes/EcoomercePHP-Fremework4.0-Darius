<?php

require_once('../../inc/def.php');
  

$idProdutoCopia = $_GET['idprodutocopia'];
$idProduto = $_GET['idproduct'];




$sql3 = 'INSERT INTO PrecosQuantidades
 (idProduto,qtde,valorUnitario)
 SELECT '.$idProduto.',qtde,valorUnitario
FROM PrecosQuantidades 
 WHERE idProduto = '.$idProdutoCopia.'';

mysqli_query($link,$sql3);

?>


<script>

history.back()

</script>