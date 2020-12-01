<?php
require_once('../../inc/def.php');
libera_acesso(1);
use Imagecraft\ImageBuilder;
require_once('../../inc/imagecraft/vendor/autoload.php');



//insere precos por quantidade
// $id = mysqli_insert_id($link);
$sql2 = 'INSERT INTO PrecosQuantidades (idProduto, qtde, valorUnitario)
VALUES ('.$_POST['idproduct'].','.$_POST['qtdep'].','.$_POST['valorUnitario'].');';
$res2 = mysqli_query($link, $sql2);


// $sql3 = 'UPDATE PrecosQuantidades SET
// qtde="'.$_POST['qtde'].'",

// valorUnitario="'.$_POST['valorUnitario'].'",

// WHERE id = '.$_POST['idProduct'].';';


if($res2){
  echo '<script type="text/javascript">
  javascript:history.go(-1)
  </script>
  ';
}else{
  echo '<script type="text/javascript">
  alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
  </script>
  ';
}


?>
