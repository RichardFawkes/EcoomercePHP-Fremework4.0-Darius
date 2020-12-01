

<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');
	error_reporting(0);
  include('api/login.php');





  $sqlz= 'SELECT * FROM Categorias WHERE id = "'.$_GET['i'].'"';
  $q = mysqli_query($link,$sqlz);
  
  $gp = mysqli_fetch_array($q);
  
  
  $sql= 'SELECT * FROM Categorias_X_Produtos cp
  JOIN Produtos p ON p.id = cp.idProduto
  WHERE idCategoria = "'.$_GET['i'].'"
  GROUP BY largura_rotulo, altura_rotulo';
  $q = mysqli_query($link,$sql);
  
  
  





   

?>



    <!-- styles needed by smoothproducts.js for product zoom  -->
    <link rel="stylesheet" href="<?php echo $site; ?>assets/plugins/smoothproducts-master/css/smoothproducts.css">
    <link href="<?php echo $site; ?>assets/plugins/rating/bootstrap-rating.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $site;?>3D/uploads/css/jquery.fileupload.css">
    <style>
        @media (min-width: 979px){
.filterBox {
    height: 0px;
    display: inline-block;
}
}
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


.description :hover{
    background-color:#4ec67f;

}


</style>




<?php
  require_once('menu.php');


?>




<?php 

$sqlt = 'SELECT  p.titulo,p.url ,cp.idCategoria,p.largura_rotulo,p.altura_rotulo FROM Categorias_X_Produtos cp
JOIN Produtos p ON p.id = cp.idProduto
WHERE idProduto = "'.$_GET['p'].'"
AND cp.idCategoria IS NOT NULL 
';
$qi = mysqli_query($link,$sqlt);

$pd = mysqli_fetch_assoc($qi);


$sql='SELECT * FROM Categorias_X_Produtos cz 
  JOIN Produtos p ON p.id = cz.idProduto
WHERE cz.idProduto IN (SELECT cp.idProduto
FROM Categorias_X_Produtos cp
JOIN Produtos p ON p.id = cp.idProduto
WHERE idCategoria = '.$pd['idCategoria'].'
AND largura_rotulo = '.$pd['largura_rotulo'].' AND altura_rotulo = '.$pd['altura_rotulo'].')
AND cz.idTipos IS NOT NULL
GROUP by idTipos;';
$q = mysqli_query($link,$sql);


$idProduto = $pd['idProduto'];
?>


<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
        <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li>Tipos</li>
                <li class="active"><?php echo $pd['largura_rotulo'].'x'.$pd['altura_rotulo']; ?></li>
            </ul>
        </div>
    </div>
    <div class="row transitionfx ">
	<div class=" col-lg-12 text-center ">
    <h1 class="texto" ><label style="font-weight:100 ;font-size:23px;">ESCOLHA O QUE VOCÊ QUER FAZER</label><h1>

	</div>


</div>


        <!-- left column -->
    
        <!--/ left column end -->

        <!-- right column -->
        <div class="col-lg-9 col-md-12 col-sm-12">
        <div>
            
	





          
            <div class="details-description">

            <?php 
     
     	while($r = mysqli_fetch_array($q)){


            $sqld='SELECT * FROM Tipos_ WHERE id = "'.$r['idTipos'].'"';

            $o= mysqli_query($link,$sqld);

            $n = mysqli_fetch_assoc($o);


            $sqluser = 'SELECT COUNT(*)total,nome FROM Users WHERE id='.$_SESSION['idUser'].' AND nome IS NOT NULL';
            $suser = mysqli_query($link,$sqluser);
            $rp = mysqli_fetch_array($suser);

            

            ?>
            <style>
@media(max-width:400px){
                .images{
                    
                    height: 148px;
                }}
            </style>
            
            
            <div class="itemgrupo col-lg-4 col-md-3 col-sm-4 col-xs-6">
            <div class="product">
                <div class="image">
            <?php

            if($n['id'] == 4){
           echo '
         
    <a href="'.$site.'produto/'.$r['url'].'"><img class="img-fluid" src="'.$site.'images/tipos/'.$n['img'].'"></a>

                        
    </div>
    <div class="description">
    <a href="'.$site.'produto/'.$r['url'].'?g='.$r['idTipos'].'">
    <div class="titulogrupoproduto"style=" border-radius: 0px 0px 20px 20px; font-weight: bold; text-transform: uppercase; line-height: 3;"> '.$n['categoria'].'</div>  
        <a href="'.$site.'produto/'.$r['url'].'?g='.$r['idTipos'].'"> </a>
        '.$tamanhos.'
    </div>
    <div class="price">
        '.$preco_antigo.'</a>
    </div>
</div>';
            }else{

            
echo' 

<a href="'.$site.''.$n['urlLink'].'?i='.$r['idProduto'].'&g='.$r['idTipos'].'"><img src="'.$site.'images/tipos/'.$n['img'].'"></a>
                        
</div>
<a href="'.$site.''.$n['urlLink'].'?i='.$r['idProduto'].'&g='.$r['idTipos'].'">

<div class="description">
<div class="titulogrupoproduto"style="     border-radius: 0px 0px 20px 20px;font-weight: bold; text-transform: uppercase;"> <a style="color:white; line-height: 3;"href="'.$site.''.$n['urlLink'].'?i='.$r['idProduto'].'&g='.$r['idTipos'].'">'.$n['categoria'].'  </a>
    <a href="'.$site.''.$n['urlLink'].'?i='.$r['idProduto'].'&g='.$r['idTipos'].'"> </a>
    '.$tamanhos.'
</div>
<div class="price">
    '.$preco_antigo.'</a>
</div>
</div>';


            }
echo'
                
        
                    <form action="'.$site.'insere_produto_no_carrinho" method="post">
                    <input type="hidden" value="'.$r['id'].'" name="idProduto">
                
                    ';if( $rp['total'] == 1 ){ 
                        echo '<div class="action-control">  </a><br><br>	
                        
';                
                    }
                        else {
                        
                        echo '<div class="action-control"> </a>	


                        ';
                    }
                    echo'
                    </div>
                </form>
                </div>
            </div>';
        }

       ?>
</div>

  
    
 
    
          

</div>
	


	 
        <style>
.btngp:hover {
  background-color: #316d49;
}

.btngp {

	
    background: #319a57;
	color: white;
    border-radius: 0px 0px 20px 20px;
    width: 500px;
    height: 62px;
    /* backface-visibility: hidden; */
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


@media (min-width: 930px)
{
.descricaogp {
    background: #e0e0e0ad;
    font-size:16px;

    height: 250px;
    /* backface-visibility: hidden; */
}

}

</style>

            <div>
                <div style="height: 2px;"class="row ">
                        <div class="filterBox">
                         
                
  
                         
  <br>
 
  
                                      <div>
  <br>
  <br>
                                     


                             


                             
                             
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

    
                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 ">
			<input type="hidden" name="idProduto" value="<?php echo $idProduto;?>">

<br>



 <div class=" col-lg-12 text-center" >
 
 </div>
 

                        
                    </div>
                    

<?php /*         <img src="<?php echo $site; ?>images/360-icon.jpg" height="20">           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block ">Add to Wishlist</a></div> */ ?>
                </div>
	</form>


             
            
               
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


    
        <!--/.recommended-->

    </div>
    <div style="clear:both"></div>
</div>
<!-- /main-container -->

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
