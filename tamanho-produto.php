

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
        @media (min-width:320px and max-width:500px){

    .descript{

        width: 338px
    }
        }
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





</style>




<?php
  require_once('menu.php');


?>





<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li>Produtos</li>
                <li class="active"><?php echo $gp['categoria']; ?></li>
            </ul>
        </div>
    </div>
    <div class="row transitionfx ">






        <!-- left column -->
        <div class="col-lg-6 col-md-6 col-sm-6">
            <!-- product Image and Zoom -->
            <div class="main-image  col-lg-12" style="
    margin-left: 23px;>
		<?php

				echo '<a href="'.$site.'images/categorias/'.$gp['img'].'"><img src="'.$site.'images/categorias/'.$gp['img'].'" class="img-responsive" alt="img"></a>';
			

		?>
        

	    </div>
        </div>
        <!--/ left column end -->

        <!-- right column -->
        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12
              ">
        <div>
            
		





          
            <div class="container col-lg-10">

            <form  style="background: whitesmoke;" method="GET" action="tipo-produto?c="<?php echo $_GET['i']?>" id="tamanhoproduto" name="tamanhoproduto">
            <div style="color:#9a9a9a; background: whitesmoke; font-weight:bold;">

<h1 style=" background: #4ec67f ;color:#ffff"> &nbsp;&nbsp; Escolha o Tamanho</h1>
</div>
            
   <br>
   <div class="container">
    <?php 


    
$sql2 = 'SELECT * FROM Produtos p
LEFT JOIN PrecosQuantidades pq ON pq.idProduto = p.id
LEFT JOIN Categorias_X_Produtos cp ON cp.idProduto = p.id
WHERE cp.idCategoria = '.$_GET['i'].' AND pq.valorUnitario IS NOT NULL ORDER BY pq.valorUnitario ASC LIMIT 1';
$qp = mysqli_query($link, $sql2);

$rd = mysqli_fetch_assoc($qp);
    while($p = mysqli_fetch_array($q)){
        if($p['volume_ml'] == '' ){
        echo '&nbsp;&nbsp;<input class="iradio_square-green iChk iCheck-margin"  id="p" name="p" value="'.$p['idProduto'].'" type="radio"  style=" color:green; font-size:20px;" required>&nbsp;'.$p['largura_rotulo'].'&nbsp;x&nbsp;'.$p['altura_rotulo'].' CM&nbsp;&nbsp; <br>';
        }else{
            echo '&nbsp;&nbsp;<input class="iradio_square-green iChk iCheck-margin"  id="p" name="p" value="'.$p['idProduto'].'" type="radio"  style=" color:green; font-size:20px;" required>&nbsp;'.$p['largura_rotulo'].'&nbsp;x&nbsp;'.$p['altura_rotulo'].' CM&nbsp;|&nbsp; '.$p['volume_ml'].' ml<br>';

        }
    }
    echo'<br>
    <br>
    ';
        ?></form>
         <div class="col-lg-12 text-center" >
 <button type="submit" form="tamanhoproduto"  value="Submit"  class="btn btn-success btngp"><h1>Continuar</h1></button>
 
</div>
</div>
  
    
 
    
          

</div>
	


	 
        <style>
.btngp:hover {
  background-color: #316d49;
}


@media (min-width: 900px){
.btngp {
 
    /* left: 2px; */
    border-radius: 0px 0px 20px 20px;
    width: 433px;
    /* left: 4px; */
    left: -14px;
    position: absolute;
    height: 62px;

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

    
               
			<input type="hidden" name="idProduto" value="<?php echo $idProduto;?>">

<br>




 
 

                        
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


