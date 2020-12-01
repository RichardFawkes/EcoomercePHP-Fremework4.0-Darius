<?php
require_once('../../inc/def.php');
libera_acesso(1);

switch ($_GET['img']) {
  case 1:
    $img = 'img';
    break;

  default:
    $img = 'img'.$_GET['img'];
    break;
}

$del = 'UPDATE Produtos SET '.$img.'=NULL  WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$del);

if($q){
  $json = array("info"=>"Sucesso ao apagar.");
}else{
  $json = array("info"=>"Erro ao apagar. Tente Novamente!");
}
echo json_encode($json);

?>
