<?php
require_once('inc/def.php');

$del = 'UPDATE Users_X_Enderecos SET ativo=0 WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$del);

if($q){
  echo "Sucesso ao apagar.";
}else{
  echo 'Erro ao apagar. Tente Novamente!';
}

?>
