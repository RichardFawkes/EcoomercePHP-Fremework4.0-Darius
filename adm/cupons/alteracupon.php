<?php
require_once('../../inc/def.php');
libera_acesso(1);





$sql2 = 'UPDATE Cupons 
SET cupomName = "'.$_POST['cupomName'].'", dataInicio = "'.$_POST['dataInicio'].'", dataFinal = "'.$_POST['dataFinal'].'", valor ="'.$_POST['valor'].'", fretegratis = "'.$_POST['fretegratis'].'",valorMinimo = "'.$_POST['valorMinimo'].'" WHERE id = '.$_POST['id'].'';
$res2 = mysqli_query($link, $sql2);




if($res2){
  echo '<script type="text/javascript">
  javascript:history.go(-2)
  </script>
  ';
}else{
  echo '<script type="text/javascript">
  alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
  </script>
  ';
}


?>
