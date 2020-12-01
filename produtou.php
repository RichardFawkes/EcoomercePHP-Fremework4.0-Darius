

<?php
  require_once('inc/def.php');
  include('api/login.php');
  error_reporting(0);


  $idarte = $_GET['id'];
  


  $sql = 'SELECT id , titulo , img , img2 , img3 , img4 , SPLIT_STRING(descricaou,"<br><br>",1) descricaouFB, descricaou , preco , preco_antigo , sku, mostra_3d , mostra_cor_da_tampa,quantidade, estoque
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
    ORDER BY qtde ASC
    ;';

    $res3 = mysqli_query($link, $sql4);





?>




    <!-- styles needed by smoothproducts.js for product zoom  -->
    <link rel="shortcut icon" href="<?php echo $site; ?>assets/ico/favicon.png">

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
  background-color: #4ec67f;
  color: white;
}

.strongcor{
    color : green;
}

.termos{
    color : green;
}

@media(min-width:940px){
  .tabelapreco{
    overflow: auto;
    position: absolute;
    font-size: -1px;
    /* line-height: 27px; */
    width: 150px;
    top: -339px;
    left:739px;
  }
}




</style>




<?php


   
	require_once('menu.php');
    $sql = 'SELECT p.id , p.url, p.titulo , p.img , p.img2 , p.rangeqtde, p.max, p.img3 , p.img4 , p.descricao ,d.valorUnitario,d.qtde, p.preco , p.preco_antigo , p.sku, p.mostra_3d , p.mostra_cor_da_tampa, p.quantidade, p.estoque,
  (SELECT d.valorUnitario FROM PrecosQuantidades d WHERE d.idProduto = p.id AND qtde >= p.rangeqtde ORDER BY valorUnitario DESC LIMIT 1) valorUnitarios
  FROM Produtos p
  JOIN PrecosQuantidades d ON d.idProduto = p.id 

  WHERE url = "'.$_GET['urlProduto'].'"
  ORDER BY d.qtde ASC
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
         
        </div>
    </div>
    <div class="row transitionfx">
    
	



        <!-- left column -->
        <div class="col-lg-4 col-md-6 col-sm-6">
      
        <label class="strongcor" >SEU PROJETO:</label>
     
        
            <!-- product Image and Zoom -->
            <div class="container col-lg-12">
           
		<?php
        

		
                echo '
                
                <img src="'.$editorlink.'productthumb.ashx?p='.$_GET['id'].'&amp;w=500&amp;h=200"
   class="img-thumbnail" alt="img">';
			

			
		?>

        <?php
        require_once('menu.php');

   $sql = 'INSERT INTO ProjetosEditor (idUser, urlprojeto, nome)
   VALUES('.$_SESSION['idUser'].','.$_GET['id'].', '.$_SESSION['nome'].')';

mysqli_query($link , $sql);
    


?>

        
        

	    </div>
        </div>
        <!--/ left column end -->

        <!-- right column -->
        <div class="col-lg-6 col-md-6 col-sm-5">
            <h1 > <?php echo $r['titulo']; ?></h1>
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
            <div class="product-price"><span class="price-sales"> R$<?php echo $r['valorUnitario']; ?></span> <?php $precoAntigo; ?>
            </div>
            <div class="details-description">
                <p><?php echo $r['descricaou']; ?> </p>
            </div>
           

	<form onsubmit="return checkForm(this);"  method="post" action="<?php echo $site;?>insere_produto_no_carrinho3?id=<?php echo $_GET['id'];?>">
    <div class="details-description">
           
           <p class ="termos">    <p>
    <meta charset="utf-8">
</p>
<div style='box-sizing: border-box; font-family: "Segoe UI", system-ui, "Apple Color Emoji", "Segoe UI Emoji", sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; color:green'><input type="checkbox" id="scales" name="terms"
       required="checked"> Eu revisei esse documento e assumo total responsabilidade pelo conte&uacute;do e pelo layout, conforme exibido aqui.<br><br>Entendo que minha cor ser&aacute; impressa digitalmente e que pode haver varia&ccedil;&atilde;o de tonalidade nas cores que apresentadas em tela.<br><br> A Loja da Lata se reserva ao direito de n&atilde;o produzir latas com imagens ofensivas, que representem qualquer forma de preconceito ou que violem direitos autorais e ou de imagem. Nesses casos o valor do pedido &eacute; restitu&iacute;do integralmente para o cliente.</div></p>

        <style>
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 20px;
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

</style>
<div class="">
<label for="">Quantidade</label>
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
                           margin-bottom: 0; font-size:15px;"> Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <span class="valor_por_unidade" id="valor_por_unidade">' .formata_real($rd['valorUnitario']).'</span> <br>
</div>
 
  <div>

  
  
</div>

  
  ';
  
                         }
?>
  <br>
  
  
                                      <div class="container tabelapreco" style=" ">
                                      <table class="table table-striped">
  
  
                                      <table class="table table-striped" id="tabela" style="

color: #555;
margin-bottom: 0;  font-family: Montserrat, sans-serif; text-align: center;  font-size: 13px; font-weight: bold; border: 2px solid #ccc; background-color:white;">
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
</div>                       

<?php
			if($r['mostra_cor_da_tampa'] == 1){
		?>

	    <div ><span class="selected-color "><strong>COR DA TAMPA</strong></span>
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
          <!-- <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block" style='background:blue'href="<?php echo $site;?>3D/<?php echo $_GET['urlProduto'];?>">Visualizar em 3D</a></div>
          
          <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block" title="Add to Cart" onclick="form.submit();" style='background:green' href='<?php echo $editor;?><?php echo $r['id'];?>&tpsc=1&token=<?php echo $tokeuser;?>&cru=https://localhost/LDL/api/criar-order.php?ide=<?php echo $r['id'];?>'>CUSTOMIZAR 3D</a></div>
   -->
        <?php } ?>
        
                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12" >
			<input type="hidden" name="idProduto" value="<?php echo $idProduto;?>">
          
<br>
<br>
                        <button class="button btn-block btn-cart cart first" title="Add to Cart" type="submit">Adicionar ao carrinho </button>
                        
                    </div>
                    

<?php /*         <img src="<?php echo $site; ?>images/360-icon.jpg" height="20">           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block ">Add to Wishlist</a></div> */ ?>
                </div>
	</form>


                <div style="clear:both"></div>

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




<script>

  function checkForm(form)
  {
    ...
    if(!form.terms.checked) {
      alert("Please indicate that you accept the Terms and Conditions");
      form.terms.focus();
      return false;
    }
    return true;
  }

</script>

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

<!-- include grid.js // for equal Div height  -->
<script src="<?php echo $site; ?>assets/plugins/jquery-match-height-master/dist/jquery.matchHeight-min.js"></script>
<script src="<?php echo $site; ?>assets/js/grids.js"></script>

<!-- include carousel slider plugin  -->
<script src="<?php echo $site; ?>assets/js/owl.carousel.min.js"></script>

<!-- include smoothproducts // product zoom plugin  -->
<script type="text/javascript" src="<?php echo $site; ?>assets/plugins/smoothproducts-master/js/smoothproducts.min.js"></script>


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

          
          
          if(valor_atual >= linha_quantidade){
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
<!-- jQuery select2 // custom select   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

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












</body>
</html>
