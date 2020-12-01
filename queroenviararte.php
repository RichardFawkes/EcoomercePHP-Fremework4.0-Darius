<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
    require_once('api/login.php');
    


    $sqlt = 'SELECT  p.url,cp.idTema,cp.idCategoria,p.largura_rotulo,p.altura_rotulo FROM Categorias_X_Produtos cp
    JOIN Produtos p ON p.id = cp.idProduto
    WHERE idProduto = "'.$_GET['i'].'"
    AND cp.idCategoria IS NOT NULL 
    ';
    $qi = mysqli_query($link,$sqlt);
    
    $pd = mysqli_fetch_assoc($qi);

    

    $sql='SELECT * FROM Categorias_X_Produtos cz WHERE cz.idProduto IN (SELECT cz.idProduto FROM Categorias_X_Produtos cz WHERE cz.idProduto IN (SELECT cp.idProduto
FROM Categorias_X_Produtos cp
JOIN Produtos p ON p.id = cp.idProduto
WHERE idCategoria = '.$pd['idCategoria'].'
AND p.largura_rotulo = '.$pd['largura_rotulo'].' AND p.altura_rotulo = '.$pd['altura_rotulo'].' )
AND cz.idTipos = "'.$_GET['g'].'"
)
AND cz.idTema IS NOT NULL

GROUP by idTema

;';
$qp = mysqli_query($link,$sql);
$ri = mysqli_fetch_array($qp);

	?>





<?php

$sqluser = 'SELECT COUNT(*)total,nome FROM Users WHERE id='.$_SESSION['idUser'].' AND nome IS NOT NULL';
$suser = mysqli_query($link, $sqluser);
$rp = mysqli_fetch_array($suser);


$sqlproduto = 'SELECT * FROM Produtos ;';

$sp = mysqli_query($link, $sqlproduto);



	
							
							if($rp['total'] >= 1  )
								
							{ 
							
						
                            header("Location:".$editor."".$ri['idProduto']."&tpsc=1&cru=".$site."api%2Fcriar-order%3Fepi%3D".$ri['idProduto']."%26url%3D".$pd['url']."");

								}else{
										
                                    header("Location:".$site."login-editor?id=".$ri['idProduto']."");


                                }	
                                

					
					
							
		

			


		?>
            </div>
            <!-- /.row -->
<?php /*
            <div class="row">
                <div class="load-more-block text-center"><a class="btn btn-thin" href="#"> <i
                        class="fa fa-plus-sign">+</i> load more products</a></div>
            </div>
*/ ?>
        </div>
        <!--/.container-->
    </div>
    <!--/.featuredPostContainer-->

<?php

	$sql = 'SELECT img FROM Clientes WHERE ativo = 1;';
	$q = mysqli_query($link , $sql);
	$nr = mysqli_num_rows($q);

	if($nr > 0){
		echo '
		    <div class="width100 section-block">
			<h3 class="section-title"><span> CLIENTES</span> <a id="nextBrand" class="link pull-right carousel-nav"> <i
				class="fa fa-angle-right"></i></a> <a id="prevBrand" class="link pull-right carousel-nav"> <i
				class="fa fa-angle-left"></i> </a></h3>

			<div class="row">
			    <div class="col-lg-12">
				<ul class="no-margin brand-carousel owl-carousel owl-theme">
		';

				while($r = mysqli_fetch_assoc($q)){
					echo '<li><a><img src="'.$site.'images/clientes/'.$r['img'].'" alt="img"></a></li>';
				}


		echo '
				</ul>
			    </div>
			</div>
			<!--/.row-->
		    </div>
		    <!--/.section-block-->
		';
	}//if
?>

</div>
<!--main-container-->


<?php /*

<div class="parallax-section parallax-image-2">
    <div class="w100 parallax-section-overley">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="parallax-content clearfix">
                        <h1 class="xlarge"> Personalize suas latas </h1>
                        <h5 class="parallaxSubtitle"> Com imagens e fotos dos grandes estúdios americanos. </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/.parallax-section-->
*/ ?>


<!-- Product Details Modal  -->
<!-- Modal -->
<div class="modal fade" id="productSetailsModalAjax" tabindex="-1" role="dialog"
     aria-labelledby="productSetailsModalAjaxLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- End Modal -->

<?php
	require_once($siteHD.'footer.php');
 ?>

<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery/jquery-1.10.1.min.js"></script>
<script src="<?php echo $site; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $site; ?>assets/js/idangerous.swiper-2.1.min.js"></script>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        pagination: '.box-pagination',
        keyboardControl: true,
        paginationClickable: true,
        slidesPerView: 'auto',
        autoResize: true,
        resizeReInit: true,
    })

    $('.prevControl').on('click', function (e) {
        e.preventDefault()
        mySwiper.swipePrev()
    })
    $('.nextControl').on('click', function (e) {
        e.preventDefault()
        mySwiper.swipeNext()
    })
</script>

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

<!-- jQuery select2 // custom select   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="<?php echo $site; ?>assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for only homepage  -->
<script src="<?php echo $site; ?>assets/js/home.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>
</body>
</html>
