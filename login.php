<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');
	require_once('api/login.php');

?>

<?php // <div class="container main-container headerOffset globalPaddingBottom"> ?>
<div class="container headerOffset globalPaddingBottom">
    <!-- Main component call to action -->

    <div class="row">
        <div class=" image-show-case-wrapper center-block relative col-lg-12">
            <div id="imageShowCase" class="owl-carousel owl-theme">

                <?php /*
                <div class="product-slide">
		    <div class="box-content-overly box-content-overly-white">
                        <div class="box-text-table">
                            <div class="box-text-cell ">
                                <div class="box-text-cell-inner ">
                                    <h1>On sale</h1>
                                    <a class="btn btn-stroke-light"> SHOP NOW</a>
				</div>
                            </div>
                        </div>
                    </div>

                    <a href="#"><img class="img-responsive" src="<?php echo $site;?>images/slider/single-img/1.jpg" alt="img"></a>
		</div>
                <!-- /.product-slide  -->
		*/ ?>


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
<?php
/*


    <div class="row">
        <div class="col-lg-12">
            <hr class="hr3">
        </div>
    </div>


		<div class="container main-container">

		    <!-- Main component call to action -->
				<!-- DESTAQUES -->
		    <div class="morePost row featuredPostContainer style2 ">
		        <!-- <div class="col-lg-12">
		            <h3 class="boxes-title-1"><span>DESTAQUES</span></h3>
		        </div> -->
		        <div class="container">
		            <div class="row xsResponse">

				<?php
					// OS MAIS VENDIDOS
					$sql = 'SELECT p.id , p.titulo , p.img , p.descricao , p.preco , p.preco_antigo , p.url , p.lancamento, SUM(cxp.qtde) tot
					FROM Produtos p
					LEFT JOIN Compras_X_Produtos cxp ON cxp.idProduto = p.id
					WHERE p.ativo = 1
					GROUP BY p.id
					ORDER BY tot DESC
					LIMIT 4;';
					$q = mysqli_query($link , $sql);
					while($r = mysqli_fetch_assoc($q)){
						if(!is_null($r['preco_antigo']) && $r['preco_antigo'] > 0){
							$preco_antigo = '<span class="old-price">R$'.$r['preco_antigo'].'</span>';
							$promocao = '<span class="discount">Promoção</span>';
						}else{
							$preco_antigo = '';
							$promocao = '';
						}

						if($r['lancamento'] == 1){
							$lancamento = '<span class="new-product"> Lançamento</span>';
						}else{
							$lancamento = '';
						}

						if(isset($r['tamanho'])){
							$tamanhos = '<span class="size">XL / XXL / S </span>';
						}else{
							$tamanhos = '';
						}


						echo '
						<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
							<div class="product">
								<div class="image">
									<div class="quickview">
										<a class="btn btn-xs btn-quickview" href="'.$site.'produto/'.$r['url'].'" > Visualizar </a>
									</div>

									<a href="'.$site.'produto/'.$r['url'].'"><img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img" class="img-responsive"></a>

									<div class="promotion">
										'.$lancamento.'
										'.$promocao.'
									</div>
								</div>
								<div class="description">
									<h4><a href="'.$site.'produto/'.$r['url'].'">'.$r['titulo'].'</a></h4>
									<a href="'.$site.'produto/'.$r['url'].'"><p>'.nl2br($r['descricao']).'</p></a>
									'.$tamanhos.'
								</div>
								<div class="price">
									<a href="'.$site.'produto/'.$r['url'].'"><span>'.formata_real($r['preco']).'</span>
									'.$preco_antigo.'</a>
								</div>
								<div class="action-control"></div>

							</div>
						</div>';
					}


				?>
		            </div>
		            <!-- /.row -->

		        </div>
		        <!--/.container-->
		    </div>
				<!-- /DESTAQUES -->
		    <!--/.featuredPostContainer-->
		</div>
*/ ?>






<?php
	// CATEGORIAS
	// $sql = 'SELECT * FROM Categorias WHERE ativo = 1 AND idTipo = 1;';
	// $q = mysqli_query($link , $sql);
	// $nr = mysqli_num_rows($q);
	//
	// if($nr > 0){
	// 	echo '
  //   <div class="row featuredPostContainer ">
  //       <div class="featuredImageLook3">';
	//
	// 	while($r = mysqli_fetch_assoc($q)){
	// 		echo '
	// 		    <div class="col-md-4 col-sm-6 col-xs-6 col-xs-min-12">
	// 			<div class="inner">
	// 			    <div class="box-content-overly box-content-overly-white">
	// 				<div class="box-text-table">
	// 				    <div class="box-text-cell ">
	// 					<div class="box-text-cell-inner dark">
	// 					    <h1 class="uppercase">'.$r['categoria'].'</h1>
	// 					    <p>'.$r['descricao'].'</p>
	// 					    <hr class="submini">
	// 					    <a class="btn btn-inverse"  href="'.$site.'Categoria/'.$r['urlLink'].'"> COMPRAR</a></div>
	// 				    </div>
	// 				</div>
	// 			    </div>
	// 			    <!--/.box-content-overly -->
	// 			    <div class="img-title"> '.$r['categoria'].'</div>
	// 			    <a class="img-block" href="'.$site.'Categoria/'.$r['urlLink'].'"> <img class="img-responsive" src="'.$site.'images/categorias/'.$r['img'].'" alt="img"></a>
	// 			</div>
	// 		    </div>
	// 		';
	// 	}//while
	// 	echo '
  //       </div>
  //       <!--/.featuredImageLook3-->
  //   </div>
  //   <!--/.featuredPostContainer-->
	// ';
	// }//if
?>
</div>
<!-- /main container -->



<div class="container main-container">

    <!-- Main component call to action -->
	<?php // <div class="morePost row featuredPostContainer style2 globalPaddingTop "> ?>
    <div class="morePost row featuredPostContainer style2">
        <div class="col-lg-12">
            <h3 class="boxes-title-1"><span>PRODUTOS</span></h3>
        </div>
        <div class="container">
            <div class="row xsResponse">

		<?php
			$sql = 'SELECT id , titulo , img , SPLIT_STRING(descricao,"<br><br>",1) descricao , preco , preco_antigo , url , lancamento FROM Produtos WHERE ativo = 1 ORDER BY lancamento DESC , id DESC LIMIT 8;';
			$q = mysqli_query($link , $sql);
			while($r = mysqli_fetch_assoc($q)){
				if(!is_null($r['preco_antigo']) && $r['preco_antigo'] > 0){
					$preco_antigo = '<span class="old-price">R$'.$r['preco_antigo'].'</span>';
					$promocao = '<span class="discount">Promoção</span>';
				}else{
					$preco_antigo = '';
					$promocao = '';
				}

				if($r['lancamento'] == 1){
					$lancamento = '<span class="new-product"> Lançamento</span>';
				}else{
					$lancamento = '';
				}

				if(isset($r['tamanho'])){
					$tamanhos = '<span class="size">XL / XXL / S </span>';
				}else{
					$tamanhos = '';
				}


				echo '
				<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
					<div class="product">
						<div class="image">
							<div class="quickview">
								<a class="btn btn-xs btn-quickview" href="'.$site.'produto/'.$r['url'].'" > Visualizar </a>
							</div>

							<a href="'.$site.'produto/'.$r['url'].'"><img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img" class="img-responsive lozad"></a>

							<div class="promotion">
								'.$lancamento.'
								'.$promocao.'
							</div>
						</div>
						<div class="description">
							<h4><a href="'.$site.'produto/'.$r['url'].'">'.$r['titulo'].'</a></h4>
							<a href="'.$site.'produto/'.$r['url'].'"><p>'.limita_caracteres(nl2br(strip_tags($r['descricao'])),100).'</p></a>
							'.$tamanhos.'
						</div>
						<div class="price">
							<a href="'.$site.'produto/'.$r['url'].'"><span>'.formata_real($r['preco']).'</span>
							'.$preco_antigo.'</a>
						</div>
						<div class="action-control"></div>

					</div>
				</div>';
			}

			/*
			echo '
			<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				<div class="product">
					<div class="image">
						<div class="quickview">
							<a class="btn btn-xs btn-quickview" href="'.$site.'produto/'.$r['url'].'" > Visualizar </a>
						</div>

						<a href="'.$site.'produto/'.$r['url'].'"><img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img" class="img-responsive"></a>

						<div class="promotion">
							'.$lancamento.'
							'.$promocao.'
						</div>
					</div>
					<div class="description">
						<h4><a href="'.$site.'produto/'.$r['url'].'">'.$r['titulo'].'</a></h4>
						<p>'.nl2br($r['descricao']).'</p>
						'.$tamanhos.'
					</div>
					<div class="price">
						<span>'.formata_real($r['preco']).'</span>
						'.$preco_antigo.'
					</div>
					<form action="'.$site.'insere_produto_no_carrinho" method="post">
						<input type="hidden" value="'.$r['id'].'" name="idProduto">

						<div class="action-control"><button type="submit" class="btn btn-primary"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Adicionar ao carrinho </span> </button></div>
					</form>
				</div>
			</div>';
			}
			*/

/*
				echo '
				<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
					<div class="product">
						<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist" data-placement="left">
							<i class="glyphicon glyphicon-heart"></i>
						</a>

						<div class="image">
							<div class="quickview">
								<a data-toggle="modal" class="btn btn-xs btn-quickview" href="ajax/product.html" data-target="#productSetailsModalAjax"> Visualizar </a>
							</div>

							<a href="'.$site.'produto/'.$r['url'].'"><img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img" class="img-responsive"></a>

							<div class="promotion">
								'.$lancamento.'
								'.$promocao.'
							</div>
						</div>
						<div class="description">
							<h4><a href="product-details.html">'.$r['titulo'].'</a></h4>
							<p>'.nl2br($r['descricao']).'</p>
							'.$tamanhos.'
						</div>
						<div class="price">
							<span>R$'.$r['preco'].'</span>
							'.$preco_antigo.'
						</div>
						<div class="action-control"><a class="btn btn-primary" href="'.$site.'insere_produto_no_carrinho.php?idProduto='.$r['id'].'"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Adicionar ao carrinho </span> </a></div>
					</div>
				</div>';

*/




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
<?php

	$sql = 'SELECT img , urlLink , titulo FROM Clientes WHERE ativo = 1;';
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
					if(!is_null($r['urlLink']) || $r['urlLink']!=""){
						$linkURL = ' href="'.$r['urlLink'].'"';
					}else{
						$linkURL = '';
					}
					if(!is_null($r['titulo']) || $r['titulo']!=""){
						$cliente = $r['titulo'];
					}else{
						$cliente = "Cliente";
					}
					echo '<li><a '.$linkURL.'><img src="'.$site.'images/clientes/'.$r['img'].'" alt="'.$cliente.'" class="lozad"></a></li>';
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
<div class="modal fade" id="productSetailsModalAjax"  role="dialog"
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







//não existe
?>


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

<!-- jQuery select2 // custom select   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="<?php echo $site; ?>assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for only homepage  -->


<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>


<?php

//EXIBI O MODAL CASO NAO TIVER LOGADO 

$sql = 'SELECT nome From `Users_X_Enderecos` WHERE idUser = '.$_SESSION["idUser"].';';
$p = mysqli_query($link , $sql);
$row2 = mysqli_num_rows($p);


$sql = 'SELECT url FROM Produtos WHERE id = "'.$_GET['id'].'"';
$rv = mysqli_query($link,$sql);
$d = mysqli_fetch_assoc($rv);

$url = 'api/criar-order.php?epi='.$_GET['id'].'&url='.$d['url'].'';

if ($row2 <= 0){
	echo "
	<script>
	$('.close').click(function(event){
		$('#ModalLogin').fadeOut();
		event.preventDefault();
	 });
	$(document).ready(function() {
		var ls = localStorage.getItem('modal');
		   $('#ModalLogin').modal('show');
		
	 });
	</script>";
	

}
//existe
else{
	
	echo '<script>
	window.location.href = "'.$site.'carrinho?cupom='.$_GET['cupom'].'";
	</script>';
	
}




?>
</body>
</html>
