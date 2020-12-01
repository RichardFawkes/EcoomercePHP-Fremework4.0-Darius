<?php
require_once('../../inc/def.php');
libera_acesso(1);




  $sql = 'INSERT INTO Produtos
  (titulo,descricao,descricaou,preco,preco_antigo,lancamento,altura,largura,comprimento,peso,sku,qtdcaixa,profundidade,prazo_producao,altura_rotulo,largura_rotulo,mostra_3d,estoque,quantidade,rangeqtde,volume_ml)
  SELECT titulo,descricao,descricaou,preco,preco_antigo,lancamento,altura,largura,comprimento,peso,sku,qtdcaixa,profundidade,prazo_producao,altura_rotulo,largura_rotulo,mostra_3d,estoque,quantidade,rangeqtde,volume_ml
  FROM Produtos WHERE id='.$_GET['id'].'';
$q = mysqli_query($link,$sql);





$sqlpe = 'SELECT id FROM Produtos ORDER by id DESC LIMIT 1';

$qz = mysqli_query($link,$sqlpe);

$r = mysqli_fetch_assoc($qz);


$sql2 = 'INSERT INTO Categorias_X_Produtos
 (idProduto,idCategoria,idTema,idTipos)
 SELECT '.$r['id'].',GROUP_CONCAT(idCategoria) AS idCategory,GROUP_CONCAT(idTema) AS Tema,GROUP_CONCAT(idTipos) AS Tipos
 FROM Categorias_X_Produtos 
 WHERE idProduto ='.$_GET['id'].'';
mysqli_query($link,$sql2);

if($q){
  header('Location: '.$site.'adm/produtos/editar.php?id='.$r['id'].'');

}else{
  echo 'Erro ao Duplicar. Tente Novamente!';
  echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=$site./adm/produtos/index.php#'>";

}

?>
