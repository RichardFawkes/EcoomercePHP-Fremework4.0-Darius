<?php
require_once('../../inc/def.php');
libera_acesso(1);
use Imagecraft\ImageBuilder;

require_once('../../inc/imagecraft/vendor/autoload.php');


// Remove as virgulas add na mascara
$preco = str_replace(",", "", $_POST['preco']);
if ($_POST['preco_antigo']==0 || is_null($_POST['preco_antigo']) || $_POST['preco_antigo']=="0.00" || $_POST['preco_antigo']=="") {
    $preco_antigo = 'NULL';
} else {
    $preco_antigo = '"'.str_replace(",", "", $_POST['preco_antigo']).'"';
}


// Verifica se digitou uma URL se nao digitou ele utiliza o ID do produto
if ($_POST['link']!="" || !is_null($_POST['link'])) {
    $url = slugify($_POST['link']);
    // Verifica se já existe um produto com essa mesma url, se já existir add o id ao final
    $sql = 'SELECT * FROM Produtos WHERE url = "'.$url.'" AND id!='.$_POST['id'].';';
    $q = mysqli_query($link, $sql);
    $exist = mysqli_num_rows($q);
    if ($exist>0) {
        $url = $url."-".$_POST['id'];
    } else {
        $url = $url;
    }
} else {
    $url = $id;
}

function validaTamanho($var)
{
    if ($var==0 || is_null($var) || $var=="0.000" || $var=="") {
        $var = 'NULL';
    } else {
        $var = '"'.$var.'"';
    }
    return $var;
}
$altura = validaTamanho($_POST['altura_rotulo']);
$largura = validaTamanho($_POST['largura_rotulo']);


$alturacaixa = validaTamanho($_POST['altura']);
$larguracaixa = validaTamanho($_POST['largura']);

$volume_ml = validaTamanho($_POST['volume_ml']);
$comprimento = validaTamanho($_POST['comprimento']);
$peso = validaTamanho($_POST['peso']);
$qtdcaixa = validaTamanho($_POST['qtdcaixa']);
$profundidade = validaTamanho($_POST['profundidade']);
$descricao = clean_style(strip_tags($_POST['descricao'], "<a></a><b></b><i></i><br><br/><p></p><u></u><img>"));
$descricaou = clean_style(strip_tags($_POST['descricaou'], "<a></a><b></b><i></i><br><br/><p></p><u></u><img>"));


// Atualiza as informações
$sql = 'UPDATE Produtos SET
  titulo="'.$_POST['titulo'].'",
  estoque='.$_POST['estoque'].',
  quantidade='.$_POST['quantidade'].',
  descricao="'.$descricao.'",
  descricaou="'.$descricaou.'",
  preco="'.$preco.'",
  preco_antigo='.$preco_antigo.',
  lancamento='.$_POST['lancamento'].',
  mostra_3d= '.$_POST['mostra_3d'].',
  especifico='.$_POST['especifico'].',
  altura_rotulo='.$altura.',
  largura_rotulo='.$largura.',
  volume_ml='.$volume_ml.',
  prazo_producao='.$_POST['dias_producao'].',
  altura='.$alturacaixa.',
  largura='.$larguracaixa.',
  comprimento='.$comprimento.',
  peso='.$peso.',
  sku="'.$_POST['sku'].'",
  rangeqtde="'.$_POST['rangeqtde'].'",
  max="'.$_POST['max'].'",
  qtdcaixa='.$qtdcaixa.',
  profundidade='.$profundidade.',
  url="'.$url.'"
  WHERE id = '.$_POST['id'].';';
$q = mysqli_query($link, $sql);

// Remove as categorias
$del = 'DELETE FROM Categorias_X_Produtos WHERE idProduto='.$_POST['id'];
mysqli_query($link, $del);

// INSERE OS TEMA DO PRODUTO
if (isset($_POST['lp'])) {
    for ($i = 0; $i < count($_POST['lp']); $i++) {
        $insc = 'INSERT INTO Categorias_X_Produtos (idProduto, idTema) VALUES ('.$_POST['id'].','.$_POST['lp'][$i].')';
        mysqli_query($link, $insc);
    }
}

// INSERE OS TIPO DO PRODUTO
if (isset($_POST['lps'])) {
    for ($i = 0; $i < count($_POST['lps']); $i++) {
        $insc = 'INSERT INTO Categorias_X_Produtos (idProduto, idTipos) VALUES ('.$_POST['id'].','.$_POST['lps'][$i].')';
        mysqli_query($link, $insc);
    }
}

// INSERE AS CATEGORIAS

if (isset($_POST['c'])) {
    for ($i = 0; $i < count($_POST['c']); $i++) {
        $ins = 'INSERT INTO Categorias_X_Produtos (idProduto, idCategoria) VALUES ('.$_POST['id'].','.$_POST['c'][$i].')';
        mysqli_query($link, $ins);
    }
}


// Inicia o contador de imagens
$imgCount= 0;
// percorre pelo array de arquivos
for ($i = 0; $i < count($_FILES['file']); $i++) {
    if (isset($_FILES['file']['size'][$i]) && $_FILES['file']['size'][$i]!=0) {
        // echo $name = $_FILES['file']['name'][$i];
        // echo "<br />";
        // $temp_name = $_FILES['file']['tmp_name'][$i];
        // echo "<br />";

        // Se tiver imagem selecionada e for uma extensão válida
        if (preg_match("/^.*\.(jpg|jpeg|png|gif)$/i", $_FILES['file']['name'][$i]) and $_FILES['file']['error'][$i]==0) {
            $filename = $_FILES['file']['name'][$i];
            $tmpfile = $_FILES['file']['tmp_name'][$i];

            #configurações do plugin do redimensionador de imagens
            $options = ['engine' => 'php_gd', 'locale' => 'en'];
            $builder = new ImageBuilder($options);
            $dirBig = $siteHD."images/product/big/";
            $dirTiny = $siteHD."images/product/mini/";

            // Gera o nome "ID DO PRODUTO"+"_"+"CONTADOR DO ARRAY";
            $imgCC = $i+1;
            $newfile = $_POST['id']."_".$imgCC.".";

            // Pega os tamanhos para reduzir
            $tamanhos = getimagesize($_FILES['file']['tmp_name'][$i]);

            // Redimensiona dependendo do peso do arquivo
            // Imagem Grande
            $imageB = $builder
      ->addBackgroundLayer()
      ->filename($tmpfile)
      ->resize(1000, 1000, 'shrink')
      ->done()
      ->save()
      ;
            // Se a imagem for válida põe no servidor
            if ($imageB->isValid()) {
                file_put_contents($dirBig.$newfile.$imageB->getExtension(), $imageB->getContents());
                $imgCount++;
            // echo "WORK";
            } else {
                // echo "NOT WORK";
        // echo $image->getMessage().PHP_EOL;
            }

            // Imagem Pequena
            $imageT = $builder
      ->addBackgroundLayer()
      ->filename($tmpfile)
      ->resize(375, 375, 'shrink')
      ->done()
      ->save()
      ;
            // Se a imagem for válida põe no servidor
            if ($imageT->isValid()) {
                file_put_contents($dirTiny.$newfile.$imageT->getExtension(), $imageT->getContents());
                // $namefile = $newfile.$image->getExtension();
                $imgCount++;
            // echo "WORK";
            } else {
                // echo "NOT WORK";
        // echo $image->getMessage().PHP_EOL;
            }

            if ($imageB->isValid() && $imageT->isValid()) {
                switch ($imgCC) {
          case 1:
            $img = 'img';
            break;

          default:
            $img = 'img'.$imgCC;
            break;
        }
                $upd = 'UPDATE Produtos SET '.$img.'="'.$newfile.$imageT->getExtension().'" WHERE id='.$_POST['id'].';';
                mysqli_query($link, $upd);
            }
        } // Válida se imagem e extensão válida e não tem erro
    } // Válida se imagem foi enviada
} // FIM FOR

// Imprime a quantidade de imagens geradas
// echo $imgCount;




if ($q) {

    header('Location: https://www.lojadalata.com/adm/produtos/editar.php?id='.$_POST["id"].'');

} else {
    echo '<script type="text/javascript">
  alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
  </script>
  ';
}
