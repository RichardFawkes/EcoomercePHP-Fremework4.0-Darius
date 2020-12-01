<?php
require_once('../../inc/def.php');
libera_acesso(1);

$sql = 'SELECT ativo FROM Users WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$sql);
$row = mysqli_fetch_array($q);

if($row['ativo']==1){
  $status = 0;
  $json = array(
    'class'=>'btn-warning',
    'icon'=>'fa-thumbs-o-down'
  );
}else{
  $status = 1;
  $json = array(
    'class'=>'btn-success',
    'icon'=>'fa-thumbs-o-up'
  );
}

$upd = 'UPDATE Users SET ativo='.$status.' WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$upd);

if($q){
  echo json_encode($json);
}else{
  echo 'Erro ao alterar. Tente Novamente!';
}

?>
