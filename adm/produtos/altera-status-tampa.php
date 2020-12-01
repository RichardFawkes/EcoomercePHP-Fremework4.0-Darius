<?php
require_once('../../inc/def.php');
libera_acesso(1);

$sql = 'SELECT mostra_cor_da_tampa FROM Produtos WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$sql);
$row = mysqli_fetch_array($q);

if($row['mostra_cor_da_tampa']==1){
  $status = 0;
  $json = array(
    'class'=>'btn-warning',
    'icon'=>'fa-circle-o'
  );
}else{
  $status = 1;
  $json = array(
    'class'=>'btn-success',
    'icon'=>'fa-circle'
  );
}

$upd = 'UPDATE Produtos SET mostra_cor_da_tampa ='.$status.' WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$upd);

if($q){
  echo json_encode($json);
}else{
  echo 'Erro ao alterar. Tente Novamente!';
}

?>
