<?php
require_once('../../inc/def.php');
libera_acesso(1);

$sql = 'SELECT ativo FROM Carrossel WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$sql);
$row = mysqli_fetch_array($q);

if($row['ativo']==1){
  $status = 0;
  $class = 'btn-warning';
}else{
  $status = 1;
  $class = 'btn-success';
}

$upd = 'UPDATE Carrossel SET ativo='.$status.' WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$upd);

if($q){
  echo $class;
}else{
  echo 'Erro ao alterar. Tente Novamente!';
}

?>
