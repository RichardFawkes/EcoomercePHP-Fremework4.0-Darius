<?php
require_once('../../inc/def.php');
libera_acesso(1);
use Imagecraft\ImageBuilder;
require_once('../../inc/imagecraft/vendor/autoload.php');

// Válida se a url tem http/https
if($_POST['link']!="" && !is_null($_POST['link'])){
  if(preg_match("#^https?://.+#", $_POST['link'])){
    $url = $_POST['link'];
  }else {
    $url = "https://".$_POST['link'];
  }
}else{
  $url = "";
}

// Se tiver imagem selecionada e for uma extensão válida
if(preg_match("/^.*\.(jpg|jpeg|png|gif)$/i", $_FILES['file']['name']) AND $_FILES['file']['error']==0 ) {
  $filename = $_FILES['file']['name'];
  $tmpfile = $_FILES['file']['tmp_name'];

  #configurações do plugin do redimensionador de imagens
  $options = ['engine' => 'php_gd', 'locale' => 'en'];
  $builder = new ImageBuilder($options);
  $dir = $siteHD."images/clientes/";

  // Faz a contagem dos arquivos para gerar o nome
  $listadir = scandir($dir);
  $newfile = (count($listadir) - 1).".";

  // Pega os tamanhos para reduzir
  $tamanhos = getimagesize($_FILES['file']['tmp_name']);

  // Redimensiona dependendo do peso do arquivo
  // if($_FILES['file']['size']<=(200*1024)){
  //   $image = $builder
  //   ->addBackgroundLayer()
  //   ->filename($tmpfile)
  //   ->resize($tamanhos[0], $tamanhos[1], 'shrink')
  //   ->done()
  //   ->save()
  //   ;
  // }elseif($_FILES['file']['size']>(200*1024) && $_FILES['file']['size']<=(1500*1024)){
  //   $largura = $tamanhos[0]/2;
  //   $altura = $tamanhos[1]/2;
  //   $image = $builder
  //   ->addBackgroundLayer()
  //   ->filename($tmpfile)
  //   ->resize($largura, $altura, 'shrink')
  //   ->done()
  //   ->save()
  //   ;
  // }else{
  //   $largura = $tamanhos[0]/3;
  //   $altura = $tamanhos[1]/3;
  //   $image = $builder
  //   ->addBackgroundLayer()
  //   ->filename($tmpfile)
  //   ->resize($largura, $altura, 'shrink')
  //   ->done()
  //   ->save()
  //   ;
  // }
  $image = $builder
  ->addBackgroundLayer()
  ->filename($tmpfile)
  ->resize($tamanhos[0], $tamanhos[1], 'shrink')
  ->done()
  ->save()
  ;

  // Se a imagem for válida põe no servidor
  if ($image->isValid()) {
    file_put_contents($dir.$newfile.$image->getExtension(), $image->getContents());
    $namefile = $newfile.$image->getExtension();
    // echo "WORK";

    // Atualiza
    $sql = 'UPDATE Clientes SET titulo="'.$_POST['titulo'].'", img="'.$namefile.'", urlLink="'.$url.'" WHERE id ='.$_POST['id'].';';
    $q = mysqli_query($link,$sql);

    if($q){
      echo '<script type="text/javascript">
      window.top.location = "'.$rot.'clientes/index.php";
      </script>
      ';
    }else{
      echo '<script type="text/javascript">
      alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
      </script>
      ';
    }
  } else {
    // echo "NOT WORK";
    // echo $image->getMessage().PHP_EOL;
  }
}else{
  // Atualiza
  $sql = 'UPDATE Clientes SET titulo="'.$_POST['titulo'].'", urlLink="'.$url.'" WHERE id ='.$_POST['id'].';';
  $q = mysqli_query($link,$sql);
  if($q){
    echo '<script type="text/javascript">
    window.top.location = "'.$rot.'clientes/index.php";
    </script>
    ';
  }else{
    echo '<script type="text/javascript">
    alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
    </script>
    ';
  }

}


?>
