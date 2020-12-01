

<?php
  require_once('inc/def.php');
  include('api/login.php');
  error_reporting(0);



  $sql = 'SELECT id , titulo , img , img2 , img3 , img4 , SPLIT_STRING(descricao,"<br><br>",1) descricaoFB, descricao , preco , preco_antigo , sku, mostra_3d , mostra_cor_da_tampa,quantidade, estoque
  FROM Produtos WHERE url = "'.$_GET['urlProduto'].'";';
  $q = mysqli_query($link , $sql);
  $r = mysqli_fetch_assoc($q);

  if(is_null($r['preco_antigo'])){
    $precoAntigo = '';
  }else{
    $precoAntigo = '<span class="price-standard">R$'.$r['preco_antigo'].'</span>';
  }

  $idProduto = $r['id'];
  $customHeader = 1;
    require_once('header.php');
    


    $sql4= 'SELECT * From PrecosQuantidades WHERE idProduto='.$r['id'].' 
    ORDER BY valorUnitario ASC  
    ;';

    $res3 = mysqli_query($link, $sql4);


$rv = mysqli_fetch_assoc($res3);

$sql5= 'SELECT * From PrecosQuantidades WHERE idProduto='.$r['id'].' 
ORDER BY valorUnitario DESC  
;';

$res4 = mysqli_query($link, $sql5);

$rvs = mysqli_fetch_assoc($res4);






?>



    <!-- styles needed by smoothproducts.js for product zoom  -->
    <link rel="stylesheet" href="<?php echo $site; ?>assets/plugins/smoothproducts-master/css/smoothproducts.css">
    <link href="<?php echo $site; ?>assets/plugins/rating/bootstrap-rating.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $site;?>3D/uploads/css/jquery.fileupload.css">
    <style>
table {
  border-collapse: collapse;
  width: 50%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #4bb777;
  color: white;
}
 #qtd{
  text-align: left;
  padding: 8px;
}


#qtd {
  background-color: #4bb777;
  color: white;
}


</style>




<?php
  require_once('menu.php');

  $sql = 'SELECT p.id , p.url, p.titulo,p.prazo_producao , p.img , p.img2 , p.rangeqtde, p.max, p.img3 , p.img4 , p.descricao, p.preco , p.preco_antigo , p.sku, p.mostra_3d , p.mostra_cor_da_tampa, p.quantidade, p.estoque,
      (SELECT d.valorUnitario FROM PrecosQuantidades d WHERE d.idProduto = p.id AND qtde >= p.rangeqtde ORDER BY valorUnitario DESC LIMIT 1) valorUnitario
  FROM Produtos p
  WHERE url = "'.$_GET['urlProduto'].'"
  LIMIT 1
  ;';
  $q = mysqli_query($link , $sql);
  $r = mysqli_fetch_assoc($q);

  if(is_null($r['preco_antigo'])){
    $precoAntigo = '';
  }else{
    $precoAntigo = '<span class="price-standard">R$'.$r['preco_antigo'].'</span>';
  }
?>





<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li>Produtos</li>
                <li class="active"><?php echo $r['titulo']; ?></li>
            </ul>
        </div>
    </div>
    <div class="row transitionfx">






        <!-- left column -->
        <div class="col-lg-6 col-md-6 col-sm-6">
            <!-- product Image and Zoom -->
            <div class="main-image sp-wrap col-lg-12">
		<?php

			if(!is_null($r['img'])){
				echo '<a href="'.$site.'images/product/big/'.$r['img'].'"><img src="'.$site.'images/product/big/'.$r['img'].'" class="img-responsive" alt="img"></a>';
			}

			if(!is_null($r['img2'])){
				echo '<a href="'.$site.'images/product/big/'.$r['img2'].'"><img src="'.$site.'images/product/big/'.$r['img2'].'" class="img-responsive" alt="img"></a>';
			}

			if(!is_null($r['img3'])){
				echo '<a href="'.$site.'images/product/big/'.$r['img3'].'"><img src="'.$site.'images/product/big/'.$r['img3'].'" class="img-responsive" alt="img"></a>';
			}

			if(!is_null($r['img4'])){
				echo '<a href="'.$site.'images/product/big/'.$r['img4'].'"><img src="'.$site.'images/product/big/'.$r['img4'].'" class="img-responsive" alt="img"></a>';
			}

		?>
        

	    </div>
        </div>
        <!--/ left column end -->

        <!-- right column -->
        <div class="col-lg-6 col-md-6 col-sm-5">
            <h1> <?php echo $r['titulo']; ?></h1>
		<h3 class="product-code">Código DO produto : <?php echo $r['sku'];?></h3>


<?php
/*
            <h3 class="product-code">Código do produto : <?php echo $r['id']; ?></h3>
            <div class="rating">
                <p><span><i class="fa fa-star"></i></span> <span><i class="fa fa-star"></i></span> <span><i
                        class="fa fa-star"></i></span> <span><i class="fa fa-star"></i></span> <span><i
                        class="fa fa-star-o "></i></span> <span class="ratingInfo"> <span>  </span> <a
                        data-target="#modal-review" data-toggle="modal"> Deixe um comentário</a> </span></p>
            </div>
*/
?>


            <div class="product-price">
            <?php 
            if($r['rangeqtde'] == '' || $r['rangeqtde'] == 0){
            echo '
            <span style="background:transparent;" class="price-sales" >  R$'. $rv['valorUnitario'].'</span>
            ';
            }
            else{

            }
            ?>
            
            </div>
            <div class="details-description">
                <p><?php echo $r['descricao']; ?> </p>
            </div>
            <label>PRAZO DE ENTREGA <?php echo $r['prazo_producao']; ?> dias + Frete</label>

	<form method="post" action="<?php echo $site;?>insere_produto_no_carrinho">

		<?php
			if($r['mostra_cor_da_tampa'] == 1){
		?>


	    <div class=""><span class="selected-color"><strong>COR DA TAMPA</strong></span>
                <ul class="swatches Color">
			<?php
				$sql = 'SELECT * FROM Cores WHERE ativo = 1;';
				$q = mysqli_query($link , $sql) or die(mysqli_error($link));
				$corSelecionada = '';
				while($cor = mysqli_fetch_assoc($q)){
					if($corSelecionada == ''){
						$corSelecionada = $cor['id'];
						$selecionaCor = ' class="selected" ';
					}else{
						$selecionaCor = '';
					}
					echo '<li '.$selecionaCor.'><a style="background-color:#'.$cor['hexadecimal'].'" onclick="document.getElementById(\'idCorSelecionada\').value=\''.$cor['id'].'\' ;"> </a></li>';
				}
			?>
                </ul>
		<input type="hidden" value="<?php echo $corSelecionada;?>" id="idCorSelecionada" name="idCorSelecionada">
            </div>
            <!--/.color-details-->
		<?php } ?>
        <style>
        @media screen and (min-width: 600px) {

.tabelao{




position: absolute;
left: 540px;
width: 16%;

}
        }
	 .linkprintnow {
  background-color: #4bb777;
  color: white;
  padding: 7px 2px;
  text-align: center;
  text-decoration: none;
  display:block;
  font-weight: bold;
}

	
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 30px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
  border-radius: 20px;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
  
}
::-webkit-scrollbar
{
    width: 0px;
}
::-webkit-scrollbar-track-piece
{
    background-color: transparent;
    -webkit-border-radius: 6px;
}







</style>

            <div class="">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <div class="filterBox">
                          <?php
                          if($r['estoque']==1){
                            $max = $r['quantidade'];
                          }else{
                            $max = '10000';
                          }
                          ?>
                         <?php if($r['rangeqtde']=='' || $r['rangeqtde']=='0'){
                           echo' <input type="number"  name="qtde" value="1" min="1" max="'.$max.'" class="form-control"><br>
                          ';
                         }else{

                            $sql2 = 'SELECT p.id , p.url, p.titulo , p.img , p.img2 , p.rangeqtde, p.max, p.img3 , p.img4 , p.descricao, p.preco , p.preco_antigo , p.sku, p.mostra_3d , p.mostra_cor_da_tampa, p.quantidade, p.estoque,
      (SELECT d.valorUnitario FROM PrecosQuantidades d WHERE d.idProduto = p.id AND qtde >= p.rangeqtde ORDER BY valorUnitario DESC LIMIT 1) valorUnitario
  FROM Produtos p
  WHERE url = "'.$_GET['urlProduto'].'"
  LIMIT 1
  ;';
  $q = mysqli_query($link , $sql2);
  $rd = mysqli_fetch_assoc($q);
  $preco = 4.60;
                           echo' 
                           
       
   

    
    
   

  
                           
                           <div style="  width:262px; color: #555;
                           margin-bottom: 0;  font-family: Montserrat, sans-serif; text-align: center;  font-size: 20px; font-weight: bold; border: 2px solid #ccc; background-color:white;">

<br>
                           <input id="range" type="range" name="qtde"  min="'.$r['rangeqtde'].'"  value="1" class="form-control-ranger slider"  step="'.$r['rangeqtde'].'"  max= "'.$r['max'].'"  style="     color: #303030;
                           font-weight: bold;
                           background-color: #green;
                           background-image: none;
                           border: 2px solid #ccc;
                           border-radius: 20px;"> <br>

                           <label style=" color: #555;
                           margin-bottom: 0; font-size:15px;" >Quantidade &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <span id="quantidade">'.$r['rangeqtde'].'</span> <br>
                              </div>

                              <div style="
                              position: absolute;
                              top: auto;
                              height: 35px;
                              color: #555;
                              margin-bottom: 0;  font-family: Montserrat, sans-serif; text-align: center;  font-size: 20px; font-weight: bold; border: 2px solid #ccc; background-color:white;">

                           
                           </div>
                           <div style="
                           position: relative;
    border-width:2px;
    width: 130px;
    height: 50px;
    left:0px;
    float: left;
                           margin-bottom: 0;  font-family: Montserrat, sans-serif; text-align: center;  font-size: 20px; font-weight: bold; border: 2px solid #ccc; background-color:white;">
                          
                           <label style=" color: #555;
                             margin-bottom: 0; font-size:15px;">Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  <span  class="preco" id="preco" >'.$r['rangeqtde'] * $r['valorUnitario'].'</span><br>
                           </div>
                           <div style="
                           position:relative;
    border-width:2px;
    width:132px;
    height: 50px;
    float: left;

                           margin-bottom: 0;  font-family: Montserrat, sans-serif; text-align: center;  font-size: 20px; font-weight: bold; border: 2px solid #ccc; background-color:white;">
                          

                           <label style=" color: #555;
                           margin-bottom: 0; font-size:15px;"> Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <span class="valor_por_unidade" id="valor_por_unidade">'.formata_real($rd['valorUnitario']).'</span> <br>
</div>
 
  <div>

  
  
</div>

  
  ';
  
                         }
?>
  <br>

  <div class="cart-actions">
  
    <button  style="width: 263px;"type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
  <i class="fa fa-th-list"></i> Tabela de Preco</button>
  
  </div>


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="" role="document">
    <div class="tabelao">
       
      <table class="table table-bordered" id="tabela" style="


color: #555;
    margin-bottom: 0;
    text-align: center;
   
    font-weight: bold;
    border: 2px solid #ccc;
    background-color: white;
">
  <thead>
    <tr>

      <th scope="col">QUANTIDADE</th>
      <th scope="col">PREÇO</th>
    </tr>
  </thead>
  <tbody>
 
  
  <?php 
  foreach($res4 as $repete){
  if($repete['qtde'] < 99999){
 echo ' 
 
 <tr>
 <tbody>
 <td class="quantidades" data-quantidade="'.$repete['qtde'] .'" > '.$repete['qtde'] .'</td>
      <td class="precos" data-preco= "'.$repete['valorUnitario'] .'">R$&nbsp;' .$repete['valorUnitario'] .'
      
      </td>
      </tbody>
      </tr>';

  }
}
  ?>    
    
  </div>
    
    </div>
  </div>
</div>
                                      

<div class="qtd">
  <br>
  <br>
                                      <table  style="display:none" class="table table-striped qtd" id="tabela" style="


    color: #555;
    margin-bottom: 0;
    /* font-family: Montserrat, sans-serif; */
    text-align: center;
    position: absolute;
    top: -190px;
    font-size: 11px;
    font-weight: bold;
    border: 2px solid #ccc;
    background-color: white;
">
  <thead>
    <tr>

      <th scope="col">QTD</th>
      <th scope="col">PREÇO</th>
    </tr>
  </thead>
  <tbody>
 
  
  <?php 
  foreach($res3 as $repete){
  if($repete['qtde'] < 99999){
 echo ' 
 
 <tr>
 <tbody>
 <td class="quantidade" data-quantidade="'.$repete['qtde'] .'" > '.$repete['qtde'] .'</td>
      <td class="preco" data-preco= "'.$repete['valorUnitario'] .'">R$&nbsp;' .$repete['valorUnitario'] .'
      
      </td>
      </tbody>
      </tr>';

  }
}
  ?>
  

    

  </tbody>
</table>
  

</div>
                             


                             
                             
                              <?php
                              if($r['estoque']==1){
                                echo "Estoque Disponível: ".$r['quantidade'];
                              }
                               ?>

                               
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- productFilter -->

            <div class="cart-actions" style="border-bottom:none;">
                <div class="addto row">
		    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block" data-target="#modal-3d" data-toggle="modal">Visualizar em 3D</a></div> -->
          <?php if($r['mostra_3d']==1){ ?>
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12"></div>

            <?php $sqluser = 'SELECT COUNT(*)total,nome FROM Users WHERE id='.$_SESSION['idUser'].' AND nome IS NOT NULL';
				$suser = mysqli_query($link,$sqluser);
                $rp = mysqli_fetch_array($suser);
                
                if( $rp['total'] == 1 ){  
                    echo '          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="btn btn-success large linkprintnow"  href='.$editor.''.$r['id'].'&tpsc=1&cru='.$site.'api%2Fcriar-order%3Fepi%3D'.$r['id'].'%26url%3D'.$r['url'].'><i class="fa fa-pencil-square"></i> DESIGN ONLINE</a></div>
                    ';
                }else{
                    echo '          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="btn btn-success large linkprintnow"  href='.$site.'login-editor?id='.$r['id'].'&token='.json_decode($tokeuser).'><i class="fa fa-pencil-square"></i>DESIGN ONLINE</a></div>
                    ';
                   
                }
                    ?>
<div>
    <?php $sqluser = 'SELECT COUNT(*)total,nome FROM Users WHERE id='.$_SESSION['idUser'].' AND nome IS NOT NULL';
				$suser = mysqli_query($link,$sqluser);
                $rp = mysqli_fetch_array($suser);
                
                if( $rp['total'] == 1 ){  
                    // echo '          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block" style="background:#454545; border-radius: 25px;" href='.$editor.''.$r['id'].'&tpsc=1&cru='.$site.'api%2Fcriar-order.php%3Fepi%3D'.$r['id'].'%26url%3D'.$r['url'].'><i class="fa fa-pencil-square"></i> CUSTOMIZAR 3D</a></div>
                    // ';
                }else{
                    // echo '          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block" style="background:#454545; border-radius: 25px;" href='.$site.'login-editor.php?id='.$r['id'].'&token='.json_decode($tokeuser).'><i class="fa fa-pencil-square"></i> CUSTOMIZAR 3D</a></div>
                    // ';
                   
                }
                    ?>
  </div>
        <?php } ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<input type="hidden" name="idProduto" value="<?php echo $idProduto;?>">

<br>
<?php 

$sqlpeg = 'SELECT * FROM Categorias_X_Produtos WHERE idProduto = "'.$idProduto.'"';
$qrs = mysqli_query($link,$sqlpeg);
$ru = mysqli_fetch_assoc($qrs);


$sqlid = 'SELECT * FROM Categorias_X_Produtos WHERE idCategoria = "'.$ru['idCategoria'].'" idProduto = "'.$idProduto.'"';
$qr = mysqli_query($link,$sqlid);
$rowid = mysqli_num_rows($qr);

if($rowid > 0){}else{
?>
<?php ?> 



<?php }?>     



 

                        
                    <button  class="button btn-block btn-cart cart first" title="Add to Cart" type="submit"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho </button>
</div>
</div>
</div>


<?php /*         <img src="<?php echo $site; ?>images/360-icon.jpg" height="20">           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block ">Add to Wishlist</a></div> */ ?>
                </div>
	</form>


                <div style="clear:both"></div>
                <!-- <h3 class="incaps"><i class="fa fa fa-check-circle-o color-in"></i> Pronta entrega</h3> -->

                <h3 style="display:none" class="incaps"><i class="fa fa-minus-circle color-out"></i> sem estoque
                </h3>

                <h3 class="incaps"><i class="glyphicon glyphicon-lock"></i> Compra segura</h3>
                <div style="clear:both"></div><br>
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="product-code">Compartilhar:</h3>
                  </div>
                  <div class="col-md-12">
                  <ul class="social pull-left">
  									<li style="background-color:#1877f2;border-color:#1877f2;"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER['SCRIPT_URI'];?>" target="_blank"> <i class=" fa fa-facebook"> &nbsp; </i> </a></li>
  									<li style="background-color:#1da1f2;border-color:#1da1f2;"><a href="https://twitter.com/share?text=<?php echo $r['titulo'];?>&url=<?php echo $_SERVER['SCRIPT_URI'];?>" target="_blank"> <i class="fa fa-twitter"> &nbsp; </i> </a></li>
                    <li style="background-color:#007bb5;border-color:#007bb5;"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $_SERVER['SCRIPT_URI'];?>&title=<?php echo $r['titulo'];?>" target="_blank"> <i class="fa fa-linkedin"> &nbsp; </i> </a></li>
                    <li style="background-color:#bd081c;border-color:#bd081c;"><a href="https://pinterest.com/pin/create/button/?url=<?php echo $_SERVER['SCRIPT_URI'];?>&media=<?php echo $site.'images/product/big/'.$r['img'];?>&description=<?php echo $r['titulo'];?>" target="_blank"> <i class="fa fa-pinterest"> &nbsp; </i> </a></li>
  							  </ul>
                  </div>
                </div>
            </div>
            <!--/.cart-actions-->
<?php /*
            <div class="clear"></div>

            <div class="product-tab w100 clearfix">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                    <li><a href="#size" data-toggle="tab">Size</a></li>
                    <li><a href="#shipping" data-toggle="tab">Shipping</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="details">Sed ut eros felis. Vestibulum rutrum imperdiet nunc a
                        interdum. In scelerisque libero ut elit porttitor commodo. Suspendisse laoreet magna nec
                        urna
                        fringilla viverra.<br>
                        100% Cotton<br>
                    </div>
                    <div class="tab-pane" id="size"> 16" waist<br>
                        34" inseam<br>
                        10.5" front rise<br>
                        8.5" knee<br>
                        7.5" leg opening<br>
                        <br>
                        Measurements taken from size 30<br>
                        Model wears size 31. Model is 6'2 <br>
                        <br>
                    </div>
                    <div class="tab-pane" id="shipping">
                        <table>
                            <colgroup>
                                <col style="width:33%">
                                <col style="width:33%">
                                <col style="width:33%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <td>Standard</td>
                                <td>1-5 business days</td>
                                <td>$7.95</td>
                            </tr>
                            <tr>
                                <td>Two Day</td>
                                <td>2 business days</td>
                                <td>$15</td>
                            </tr>
                            <tr>
                                <td>Next Day</td>
                                <td>1 business day</td>
                                <td>$30</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">* Free on orders of $50 or more</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.tab content -->

            </div>
            <!--/.product-tab-->

            <div style="clear:both"></div>
*/?>

<?php /*
            <div class="product-share clearfix">
                <p> SHARE </p>

                <div class="socialIcon"><a href="#"> <i class="fa fa-facebook"></i></a> <a href="#"> <i
                        class="fa fa-twitter"></i></a> <a href="#"> <i class="fa fa-google-plus"></i></a> <a
                        href="#">
                    <i class="fa fa-pinterest"></i></a>
		</div>
            </div>
            <!--/.product-share-->
*/ ?>
        </div>
        <!--/ right column end -->

    </div>
    <!--/.row-->


    <div class="row recommended">
        <h1> PRODUTOS RELACIONADOS </h1>

        <div id="SimilarProductSlider">

<?php
$sql1 = 'SELECT idTipos FROM Categorias_X_Produtos WHERE idProduto = '.$idProduto.'  AND idTipos IS NOT NULL';
$gps = mysqli_query($link,$sql1);
$sgs = mysqli_fetch_assoc($gps);



$sql2 = 'SELECT idCategoria FROM Categorias_X_Produtos WHERE idProduto = '.$idProduto.' AND idCategoria IS NOT NULL';
$gp = mysqli_query($link,$sql2);
$sg = mysqli_fetch_assoc($gp);


	$sql = 'SELECT * FROM Categorias_X_Produtos cz 
    JOIN Produtos p ON p.id = cz.idProduto
    WHERE cz.idProduto IN (SELECT cz.idProduto FROM Categorias_X_Produtos cz WHERE cz.idTipos = "'.$sgs['idTipos'].'" AND cz.idProduto IN (SELECT cp.idProduto
    FROM Categorias_X_Produtos cp
    JOIN Produtos p ON p.id = cp.idProduto
    WHERE idCategoria = "'.$sg['idCategoria'].'" GROUP by idProduto)
    )GROUP by idProduto';
	$q = mysqli_query($link , $sql);
	while($r = mysqli_fetch_assoc($q)){
		echo '
            <div class="item">
                <div class="product"><a class="product-image" href="'.$site.'produto/'.$r['url'].'"> <img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img"> </a>
                    <div class="description">
                        <h4><a  href="'.$site.'produto/'.$r['url'].'">'.$r['titulo'].'</a></h4>

                    </div>
                </div>
            </div>
            ';
	}

?>
            <!--/.item-->
        </div>
        <!--/.recommended-->

    </div>
    <div style="clear:both"></div>
</div>
<!-- /main-container -->

<div class="gap"></div>

<?php
	require_once('footer.php');
?>

<!-- Modal 3D start -->
<div class="modal  fade" id="modal-3d" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center">MEUS ARQUIVOS </h3>
            </div>
            <div class="modal-body">

                <h3 class="reviewtitle uppercase">Arquivos:</h3>

                <form>
                    <div class="form-group">
<iframe src="<?php echo $site; ?>3D/uploads/index.php?urlLink=<?php echo $_GET['urlProduto'];?>"></iframe>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Modal 3d -->

<?php /*
<!-- Modal review start -->
<div class="modal  fade" id="modal-review" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center">PRODUCT REVIEW </h3>
            </div>
            <div class="modal-body">

                <h3 class="reviewtitle uppercase">You're reviewing: Lorem ipsum dolor sit amet</h3>

                <form>
                    <div class="form-group">
                        <label>
                            How do you rate this product? </label> <br>

                        <div class="rating-here">
                            <input type="hidden" class="rating-tooltip-manual" data-filled="fa fa-star fa-2x"
                                   data-empty="fa fa-star-o fa-2x" data-fractions="3"/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rtext">Name</label>
                        <input type="text" class="form-control" id="rtext" placeholder="Your name" required>
                    </div>

                    <div class="form-group ">
                        <label>Review</label>
                        <textarea class="form-control" rows="3" placeholder="Your Review" required></textarea>

                    </div>


                    <button type="submit" class="btn btn-success">Submit Review</button>
                </form>


            </div>

        </div>
        <!-- /.modal-content -->

    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.Modal review -->
*/ ?>

<!-- Le javascript
================================================== -->



<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $site; ?>assets/js/jquery/jquery-2.1.3.min.js"></script>


<!-- jquery-migrate only for product details -->
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script src="<?php echo $site; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- include jqueryCycle plugin -->
<script src="<?php echo $site; ?>assets/js/jquery.cycle2.min.js"></script>
<!-- include easing plugin -->
<script src="<?php echo $site; ?>assets/js/jquery.easing.1.3.js"></script>

<!-- include  parallax plugin -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery.parallax-1.1.js"></script>

<!-- optionally include helper plugins -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/helper-plugins/jquery.mousewheel.min.js"></script>

<!-- include mCustomScrollbar plugin //Custom Scrollbar  -->

<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery.mCustomScrollbar.js"></script>

<!-- include icheck plugin // customized checkboxes and radio buttons   -->
<script type="text/javascript" src="<?php echo $site; ?>assets/plugins/icheck-1.x/icheck.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- include grid.js // for equal Div height  -->
<script src="<?php echo $site; ?>assets/plugins/jquery-match-height-master/dist/jquery.matchHeight-min.js"></script>
<script src="<?php echo $site; ?>assets/js/grids.js"></script>

<!-- include carousel slider plugin  -->
<script src="<?php echo $site; ?>assets/js/owl.carousel.min.js"></script>

<!-- include smoothproducts // product zoom plugin  -->
<script type="text/javascript" src="<?php echo $site; ?>assets/plugins/smoothproducts-master/js/smoothproducts.min.js"></script>

<script type="text/javascript">
    /* wait for images to load */
    $(window).load(function () {
        $('.sp-wrap').smoothproducts();
    });
  
</script>



<script>


$(document).ready(function(){

  function formata(v){
   return parseFloat(v).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
}

    var input = $('#range');
    var quantidade = $('#quantidade')
    var preco = $('#preco').text(parseInt($(".preco").text()).toLocaleString('pt-br', {
  style: 'currency',
  currency: 'BRL',
 
}));
    var valor_por_unidade = $('#valor_por_unidade');
    var tabela = $('#tabela tbody')
    
    input.on('input', function(){
      //pega valor atual do range
      var valor_atual = $(this).val()
      quantidade.text(valor_atual)
      var quantidade_da_tabela = 0;
      var preco_da_tabela = 0;
      //faz um for para pegar o valor da tabela
      //pega todas as linhas da tabela
       tabela.find('tr').each(function(){
          var linha_quantidade = $(this).find('.quantidade').data('quantidade')
          var linha_preco = $(this).find('.preco').data('preco') 

          
          
          if(valor_atual <= linha_quantidade){

            quantidade_da_tabela = linha_quantidade
            preco_da_tabela = linha_preco

            return
           }
       })
       preco.text(valor_atual * preco_da_tabela).text(parseInt($(".preco").text()).toLocaleString('pt-br', {
  style: 'currency',
  currency: 'BRL',
 
})); 
       valor_por_unidade.text(preco_da_tabela).text(parseFloat($(".valor_por_unidade").text()).toLocaleString('pt-br', {
  style: 'currency',
  currency: 'BRL',
 
})); 
    })
 

})



</script>



<script>

</script>



<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="<?php echo $site; ?>assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>


<script src="<?php echo $site; ?>assets/plugins/rating/bootstrap-rating.min.js"></script>
<script>
    $(function () {

        $('.rating-tooltip-manual').rating({
            extendSymbol: function () {
                var title;
                $(this).tooltip({
                    container: 'body',
                    placement: 'bottom',
                    trigger: 'manual',
                    title: function () {
                        return title;
                    }
                });
                $(this).on('rating.rateenter', function (e, rate) {
                    title = rate;
                    $(this).tooltip('show');
                })
                    .on('rating.rateleave', function () {
                        $(this).tooltip('hide');
                    });
            }
        });

    });
</script>

<?php
//FUNCAO CADASTRA O CLIENTE NO PRINT NOW
session_start();

$idUser = $_SESSION['idUser'];
 
$sql = 'SELECT nome, email, id FROM Users WHERE id = '.$idUser;

$q = mysqli_query($link , $sql);
$r = mysqli_fetch_array($q);



$nome = $r['nome'];
$email = $r['email'];
$id    =$r['id'];

// echo '<br>'.$nome.'<br>';

// echo '<br>'.$email.'<br>';

// echo '<br>' .$id. '<br>';



$token = '9F3D85FD4F090049BB298E479056BB67';
$key = 'E8024D21A2B9A5785CEFB28AAA538E820EF50DAA2D0A1582AA5CBE545E8A4E64';
$url = 'https://api.printnow.com/api/v1/pipo/user/create';

// $id = $_GET['productid'





//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST
$data = array(
    'username' => $nome,
    'password' => 'lojadalata',
    'email' => $email,
    'first_name' => $nome,
    'last_name' => $id,
    'storefront_id'=> '1'
);
$payload = json_encode($data);
//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic ' . base64_encode( $token . ':' . $key),
    'Content-Type:application/json'));

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$result = curl_exec($ch);
//    echo ($result);
exit;
//close cURL resource
curl_close($ch);

  

?>






</body>
</html>
