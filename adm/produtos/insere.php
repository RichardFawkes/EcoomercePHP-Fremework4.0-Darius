<?php
require_once('../../inc/def.php');
libera_acesso(1);
use Imagecraft\ImageBuilder;

require_once('../../inc/imagecraft/vendor/autoload.php');

function validaTamanho($var)
{
    if ($var==0 || is_null($var) || $var=="0.000" || $var=="") {
        $var = 'NULL';
    } else {
        $var = '"'.$var.'"';
    }
    return $var;
}
$altura = validaTamanho($_POST['altura']);
$largura = validaTamanho($_POST['largura']);
$comprimento = validaTamanho($_POST['comprimento']);
$peso = validaTamanho($_POST['peso']);
$qtdcaixa = validaTamanho($_POST['qtdcaixa']);
$profundidade = validaTamanho($_POST['profundidade']);
$altura_rotulo = validaTamanho($_POST['altura_rotulo']);
$largura_rotulo = validaTamanho($_POST['largura_rotulo']);
$volume_ml = validaTamanho($_POST['volume_ml']);
$rangeqtde = $_POST['rangeqtde'];
$max = $_POST['max'];


if ($_POST['qtde']!="") {
    $qtde = $_POST['qtde'];
} else {
    $qtde = 'NULL';
}
// Remove as virgulas add na mascara
$preco = str_replace(",", "", $_POST['preco']);
if ($_POST['preco_antigo']==0 || is_null($_POST['preco_antigo']) || $_POST['preco_antigo']=="0.00" || $_POST['preco_antigo']=="") {
    $preco_antigo = 'NULL';
} else {
    $preco_antigo = '"'.str_replace(",", "", $_POST['preco_antigo']).'"';
}
$descricao = clean_style(strip_tags($_POST['descricao'], "<a></a><b></b><i></i><br><br/><p></p><u></u>"));
// Insere
$sql = 'INSERT INTO Produtos
(titulo,descricao,preco,preco_antigo,lancamento,altura,largura,comprimento,peso,sku,qtdcaixa,profundidade,prazo_producao,altura_rotulo,largura_rotulo,mostra_3d,estoque,quantidade,rangeqtde,max) VALUES
("'.$_POST['titulo'].'","'.$descricao.'","'.$preco.'",'.$preco_antigo.','.$_POST['lancamento'].','.$altura.','.$largura.','.$comprimento.','.$peso.',"'.$_POST['sku'].'",'.$qtdcaixa.'
  ,'.$profundidade.','.$_POST['dias_producao'].','.$altura_rotulo.','.$largura_rotulo.','.$_POST['mostra_3d'].','.$_POST['estoque'].','.$qtde.','.$rangeqtde.','.$max.');';
$q = mysqli_query($link, $sql);
$id = mysqli_insert_id($link);


//insere precos por quantidade


// Verifica se digitou uma URL se nao digitou ele utiliza o ID do produto
if ($_POST['link']!="" || !is_null($_POST['link'])) {
    $url = slugify($_POST['link']);
    // Verifica se já existe um produto com essa mesma url, se já existir add o id ao final
    $sql = 'SELECT * FROM Produtos WHERE url = "'.$url.'";';
    $q = mysqli_query($link, $sql);
    $exist = mysqli_num_rows($q);
    if ($exist>0) {
        $url = $url."-".$id;
    } else {
        $url = $url;
    }
} else {
    $url = $id;
}

$upd = 'UPDATE Produtos SET url="'.$url.'" WHERE id='.$id;
mysqli_query($link, $upd);


// INSERE AS LINHAS PRÓPRIAS
if (isset($_POST['lp'])) {
    for ($i = 0; $i < count($_POST['lp']); $i++) {
        $ins = 'INSERT INTO Categorias_X_Produtos (idProduto, idCategoria) VALUES ('.$id.','.$_POST['lp'][$i].')';
        mysqli_query($link, $ins);
    }
}

// INSERE AS CATEGORIAS

if (isset($_POST['c'])) {
    for ($i = 0; $i < count($_POST['c']); $i++) {
        $ins = 'INSERT INTO Categorias_X_Produtos (idProduto, idCategoria) VALUES ('.$id.','.$_POST['c'][$i].')';
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
            $options = ['engine' => 'php_gd', 'locale' => 'en', 'jpeg_quality'=>72, 'png_compression'=>72];
            $builder = new ImageBuilder($options);
            $dirBig = $siteHD."images/product/big/";
            $dirTiny = $siteHD."images/product/mini/";

            // Gera o nome "ID DO PRODUTO"+"_"+"CONTADOR DO ARRAY";
            $imgCC = $i+1;
            $newfile = $id."_".$imgCC.".";

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
            } else {
                // echo "NOT WORK";
        // echo $image->getMessage().PHP_EOL;
            }

            // Imagem Pequena
            $imageT = $builder
      ->addBackgroundLayer()
      ->filename($tmpfile)
      ->resize(260, 260, 'shrink')
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
                $upd = 'UPDATE Produtos SET '.$img.'="'.$newfile.$imageT->getExtension().'" WHERE id='.$id.';';
                mysqli_query($link, $upd);
            }
        } // Válida se imagem e extensão válida e não tem erro
    } // Válida se imagem foi enviada
} // FIM FOR

// Imprime a quantidade de imagens geradas
// echo $imgCount;
//
if ($q) {
    echo '<script type="text/javascript">
  window.top.location = "'.$rot.'produtos/index.php";
  </script>
  ';
} else {
    echo '<script type="text/javascript">
  alert("Erro ao gravar no Banco! Tente Novamente."); history.back()";
  </script>
  ';
}
