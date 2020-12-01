<?php
require_once('../../inc/def.php');
libera_acesso(1);


  $texto = clean_style(strip_tags($_POST['texto'],"<a></a><b></b><i></i><br><br/><p></p><u></u><img>"));
  // Atualiza
  $sql = 'UPDATE Pages SET titulo="'.$_POST['titulo'].'",texto="'.$texto.'" WHERE id ='.$_POST['id'].';';
  $q = mysqli_query($link,$sql);
  if($q){
    echo '<script type="text/javascript">
    window.top.location = "'.$rot.'pages/editar.php?id='.$_POST['id'].'";
    </script>
    ';
  }else{
    echo '<script type="text/javascript">
    alert("Erro ao gravar no Banco! Tente Novamente."); history.back();
    </script>
    ';
  }



?>
