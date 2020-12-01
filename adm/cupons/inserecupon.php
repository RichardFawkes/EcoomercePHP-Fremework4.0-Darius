<?php
require_once('../../inc/def.php');
libera_acesso(1);





$sql2 = 'INSERT INTO Cupons (cupomName, dataInicio, dataFinal,valor,fretegratis,valorMinimo)
VALUES ("'.$_POST['cupomName'].'","'.$_POST['dataInicio'].'","'.$_POST['dataFinal'].'","'.$_POST['valor'].'","'.$_POST['fretegratis'].'","'.$_POST['valorMinimo'].'");';
$res2 = mysqli_query($link, $sql2);




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
