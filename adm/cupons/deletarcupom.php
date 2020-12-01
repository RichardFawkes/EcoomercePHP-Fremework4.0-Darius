<?php
require_once('../../inc/def.php');
libera_acesso(1);


$del = 'DELETE FROM Cupons WHERE id='.$_POST['id'].';';
$q = mysqli_query($link,$del);

if($q){
  echo '<script type="text/javascript">
  javascript:history.go(-1)
  </script>';
}else{
  echo 'Erro ao apagar. Tente Novamente!';
}

?>
