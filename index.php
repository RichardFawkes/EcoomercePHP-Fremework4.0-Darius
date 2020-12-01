<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');
	error_reporting(0);

?>

<?php // <div class="container main-container headerOffset globalPaddingBottom"> ?>
<div>
    <!-- Main component call to action -->
	

    <div class="row">
        <div class=" image-show-case-wrapper center-block relative col-lg-12">
            <div id="imageShowCase" class="owl-carousel owl-theme">

         

<?php

	$sql = 'SELECT img , urlLink , mode FROM Carrossel WHERE ativo = 1;';
	$q = mysqli_query($link , $sql);
	$cont=0;
	while($r = mysqli_fetch_assoc($q)){

		echo '<div class="product-slide">';
		$lazy = ($cont!=0)? ' lozad' : '';
		if(is_null($r['urlLink'])){
			echo '<img class="img-responsive '.$lazy.'" src="'.$site.'images/carrossel/'.$r['img'].'" alt="img">';
		}else{
			echo '<a href="'.$r['urlLink'].'" target="'.$r['mode'].'"><img class="img-responsive '.$lazy.'" src="'.$site.'images/carrossel/'.$r['img'].'" alt="img"></a>';
		}
		echo '</div>';
	}//while
?>

            </div>
            <!--/#imageShowCase -->

            <div style="clear:both;"></div>
            <a id="ps-next" class="ps-nav"> <img src="<?php echo $site;?>images/site/arrow-right.png" alt="N E X T"> </a> <a id="ps-prev"
                                                                                                          class="ps-nav">
            <img src="<?php echo $site;?>images/site/arrow-left.png" alt="P R E V"></a></div>
        <!--/.image-show-case-wrapper -->
    </div>
    <div style="clear:both"></div>


</div>
<!-- /main container -->



<div class="container main-container">

    <!-- Main component call to action -->
	<?php // <div class="morePost row featuredPostContainer style2 globalPaddingTop "> ?>
    <div class="morePost row featuredPostContainer style2">
	<div class="col-lg-12 text-center">
			<br>
			<div class="texto">
    <h1>DESTAQUES<h1>

	</div>
        </div>
        </div>
        <div class="container">
            <div class="row xsResponse">

		<?php
			$sql = '   SELECT  p.id , p.categoria , p.img , SPLIT_STRING(descricao,"<br><br>",1) descricao ,  p.urlLink url  FROM Categorias p WHERE ativo = 1 ORDER BY p.id DESC , id DESC LIMIT 8;';
			$q = mysqli_query($link , $sql);

		
			while($r = mysqli_fetch_assoc($q)){
				if(!is_null($r['']) && $r[''] > 0){
					$preco_antigo = '<span class="old-price">R$'.$r['preco_antigo'].'</span>';
					$promocao = '<span class="discount">Promoção</span>';
				}else{
					
					$promocao = '';
				}

				if($r['lancamento'] == 1){
					$lancamento = '<span  style="background-color: #3f000b;"class="new-product"> Lançamento</span>';
				}else{
					$lancamento = '';
				}

				if(isset($r['tamanho'])){
					$tamanhos = '<span class="size">XL / XXL / S </span>';
				}else{
					$tamanhos = '';
				}
				$sqluser = 'SELECT COUNT(*)total,nome FROM Users WHERE id='.$_SESSION['idUser'].' AND nome IS NOT NULL';
				$suser = mysqli_query($link,$sqluser);
				$rp = mysqli_fetch_array($suser);

				$sql2 = 'SELECT * FROM Produtos p
				LEFT JOIN PrecosQuantidades pq ON pq.idProduto = p.id
				LEFT JOIN Categorias_X_Produtos cp ON cp.idProduto = p.id
				WHERE cp.idCategoria = '.$r['id'].' AND pq.valorUnitario IS NOT NULL ORDER BY pq.valorUnitario ASC LIMIT 1';
				$qp = mysqli_query($link, $sql2);

				$rd = mysqli_fetch_assoc($qp);


				
		
				echo '
				<div class="itemgrupo col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="product">
						<div class="image">
							<div  class="quickview">
								<a href="'.$site.'configurar-produto?i='.$r['id'].'">  </a>
							</div>
							<a href="'.$site.'configurar-produto?i='.$r['id'].'"><img src="'.$site.'images/categorias/'.$r['img'].'" alt="img" class="img-responsive lozad"></a>

							<div class="promotion">
								'.$lancamento.'
								'.$promocao.'
							</div>
						</div>
						
						<div class="description">
					
						<div style=" background:transparente; font-weight: bold; "><a href="'.$site.'configurar-produto?i='.$r['id'].'"> <p  class="titulogrupoproduto" 
							 style="background:transparente;"> '.$r['categoria'].' <br> a partir de '.formata_real($rd['valorUnitario']).'</p></a></div>
							
						
						<div class="price">
							'.$preco_antigo.'</a>
						</div>
						</div> 

					
			
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
</div>






<?php
	$sql = 'SELECT * FROM Categorias WHERE ativo = 1 AND idTipo = 2;';
	$q = mysqli_query($link , $sql);
	$nr = mysqli_num_rows($q);

	if($nr > 0){
		echo '	<div class="w100 sectionCategory">
					<div class="container">
				<div class="sectionCategoryIntro text-center">
						<h1>Linhas Próprias</h1>

						<p>Nossos produtos de pronta-entrega estão disponíveis o ano inteiro
							 e podem ser personalizados com mensagens e imagens de sua preferência.</p>
				</div>
				<div class="row subCategoryList clearfix">
		';

		while($r = mysqli_fetch_assoc($q)){
			echo '
				<div class="col-md-2 col-sm-3 col-xs-4  col-xs-mini-6  text-center ">
			<div class="thumbnail"><a class="subCategoryThumb" href="'.$site.'Linhas-Proprias/'.$r['urlLink'].'"><img
				src="'.$site.'images/product/linhas_proprias/'.$r['img'].'" class="img-rounded lozad" alt="img"> </a> <a
				class="subCategoryTitle" href="'.$site.'Linhas-Proprias/'.$r['urlLink'].'"><span> '.nl2br($r['categoria']).' &nbsp;</span></a></div>
				</div>
		';
		}//while

		echo '		</div>
				<!--/.row-->
					</div>
					<!--/.container-->
			</div>
			<!--/.sectionCategory-->
		';
	}//if
?>


    <div style="clear:both"></div>
    <div class="row">
	<div class="col-lg-12">&nbsp;</div>
    </div>

<div class="container">

</div>
<!--main-container-->

<?php
	require_once($siteHD.'footer.php');
 ?>


<?php  ?>


<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery/jquery-1.10.1.min.js"></script>
<script src="<?php echo $site; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
const el = document.querySelector('img');
const observer = lozad(el);
observer.observe();
</script>
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
<!-- <script src="<?php echo $site; ?>assets/js/jquery.cycle2.js"></script> -->

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



<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="<?php echo $site; ?>assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for only homepage  -->
<script src="<?php echo $site; ?>assets/js/home.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>
</body>
</html>
