<?php
require_once('../../inc/def.php');
libera_acesso(1);



  $descricao = clean_style(strip_tags($_POST['resposta'],"<a></a><b></b><i></i><br><br/><p></p><u></u><img>"));
  // Insere
  $sql = 'INSERT INTO Faq (pergunta, resposta, dataHora) VALUES("'.$_POST['pergunta'].'", "'.$descricao.'", NOW());';
  $q = mysqli_query($link,$sql);

  if($q){
    echo '<script type="text/javascript">
    window.top.location = "'.$rot.'faq/index.php";
    </script>
    ';
  }else{
    echo '<script type="text/javascript">
    alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
    </script>
    ';
  }




?>
