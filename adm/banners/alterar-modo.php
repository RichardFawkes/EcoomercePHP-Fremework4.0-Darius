<?php
require_once('../../inc/def.php');
libera_acesso(1);


$upd = 'UPDATE Carrossel SET mode="'.$_GET['mode'].'" WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$upd);

if($q){
  echo "Alterado.";
}else{
  echo 'Erro ao alterar. Tente Novamente!';
}

?>
