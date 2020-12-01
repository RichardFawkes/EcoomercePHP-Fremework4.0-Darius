<?php
require_once('../../inc/def.php');
libera_acesso(1);


$del = 'DELETE FROM Faq WHERE id='.$_GET['id'].';';
$q = mysqli_query($link,$del);

if($q){
  echo "Sucesso ao apagar.";
}else{
  echo 'Erro ao apagar. Tente Novamente!';
}

?>
