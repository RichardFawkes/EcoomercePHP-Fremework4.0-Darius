

<?php
  require_once('inc/def.php');
  include('api/login.php');



  

  $sql= 'SELECT * FROM Categorias WHERE id = "'.$_GET['i'].'"';
  $q = mysqli_query($link,$sql);
  
  $gp = mysqli_fetch_array($q);
  

  
  $idProduto = $r['id'];
  $customHeader = 1;
    require_once('header.php');
    


   

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


</style>




<?php
  require_once('menu.php');

  $sql2 = 'SELECT * FROM Produtos p
  LEFT JOIN PrecosQuantidades pq ON pq.idProduto = p.id
  LEFT JOIN Categorias_X_Produtos cp ON cp.idProduto = p.id
  WHERE cp.idCategoria = '.$_GET['i'].' AND pq.valorUnitario IS NOT NULL ORDER BY pq.valorUnitario ASC LIMIT 1';
  $qp = mysqli_query($link, $sql2);
  
  $rd = mysqli_fetch_assoc($qp);
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
    margin-left: 23px;">
		<?php

				echo '<a href="'.$site.'images/categorias/'.$gp['img'].'"><img src="'.$site.'images/categorias/'.$gp['img'].'" class="img-responsive" alt="img"></a>';
			

		?>
        

	    </div>
        </div>
        <!--/ left column end -->

        <!-- right column -->
        <div class="col-lg-5 col-md-6 col-sm-5 ">
        <div>
            




          
            <div class="details-description " >
                <div class="container descricaogp">
                <h1  style="color: #9a9a9a;
    font-weight: bold;
    margin-top: 13px;
    width: 100%;"> <?php echo $gp['categoria'];?></h1>
                <p ><?php echo '<br>&nbsp;'.$gp['descricao']; ?> 
            
                </p>
               
              <?php  echo'<br>
    <br>
    <div >&nbsp;&nbsp;<label >A partir de</label><br>
    <label style="color: #3da8c1; 
    font-size: 30px;">&nbsp;'.formata_real($rd['valorUnitario']).'
    </label><br><label class="configproduto">*preço para o formato '.$rd['largura_rotulo'].'x'.$rd['altura_rotulo'].' para '.$rd['qtde'].' unidades</label></label><br></div>';
        ?>
           
                </div>
              
            </div>
            <div class="container" style="padding-left: 10px;">
            <a  class=" text-center  btngp btn btn-success col-xs-12 "  style="color:white;background-color: transparente;"href="<?php echo $site.'tamanho-produto?i='.$gp['id'] ?>"><h1>Configurar Produto</h1></a>

            </div>
</div>
	


	 
        <style>


.configproduto{
    color: #9a9a9a;
    font-weight: 100;
}

@media (min-width: 930px)
{
.btngp {

    width: 438px;
    border-radius: 0px 0px 20px 20px;
 
    /* backface-visibility: hidden; */
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
    font-size: 15px;
    
    width: 439px;
    height: 365px;

    /* backface-visibility: hidden; */
}

}


@media (min-width: 930px)
{
.descricaogps {
    background: #60cd72;
    font-size: 15px;
    
    width: 439px;
    border-radius: 0px 0px 20px 20px;
    width: 439px;
    height: 67px;
    

    /* backface-visibility: hidden; */
}

}

</style>

            <div>
                <div style="height: 2px;"class="row ">
                        <div class="filterBox">
                         
                
  
                         
  <br>
 
  
                                      <div class="qtd">
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






                        
                 
                    

<?php /*         <img src="<?php echo $site; ?>images/360-icon.jpg" height="20">           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block ">Add to Wishlist</a></div> */ ?>
                </div>
	</form>


             
            
            <!--/.cart-actions-->


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
<br>
<?php
	require_once('footer.php');
?>



<?php /*

*/ ?>



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
<script src="<?php echo $site; ?>ow/owl.carousel.min.js"></script>
<script src="<?php echo $site; ?>ow/owl.carousel.min.js"></script>

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

