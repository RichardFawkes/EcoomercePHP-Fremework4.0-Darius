<?php
require_once('../../inc/def.php');
header('Content-Type: application/json');
libera_acesso(1,2,3,4);

if($_POST['rastreio']!=""){
  $enviado=1;
}else{
  $enviado = 0;
}

// $upd = 'UPDATE Compras SET codigoRastreio="'.$_POST['rastreio'].'",enviado='.$enviado.' WHERE id='.$_POST['id'].';';
$upd = 'UPDATE Compras SET codigoRastreio="'.$_POST['rastreio'].'" WHERE id='.$_POST['id'].';';
$q = mysqli_query($link,$upd);

if($q){

  $json = array("msg"=>"Salvo com sucesso","enviado"=>$enviado);
}else{
  $json = array("msg"=>"Erro ao alterar","enviado"=>0);
}


echo json_encode($json);
?>
