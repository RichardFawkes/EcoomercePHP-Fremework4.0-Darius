<?php
require_once('../../inc/def.php');
libera_acesso(1);

$sql = 'SELECT especifico FROM Produtos WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$sql);
$row = mysqli_fetch_array($q);

if($row['especifico']==0){
  $status = 1;
  $json = array(
    'class'=>'btn-warning',
    'icon'=>'fa-file-o'
  );
}else{
  $status = 0;
  $json = array(
    'class'=>'btn-success',
    'icon'=>'fa-file-o'
  );
}

$upd = 'UPDATE Produtos SET especifico ='.$status.' WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$upd);

if($q){
  echo json_encode($json);
}else{
  echo 'Erro ao alterar. Tente Novamente!';
}

?>
