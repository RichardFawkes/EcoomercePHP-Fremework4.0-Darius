<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');

?>

<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li>Produtos</li>
                <?php
                if(isset($_GET['q']) && $_GET['q']!=""){
                  $sql = 'SELECT p.id , p.titulo , p.img , p.descricao , p.preco , p.preco_antigo , p.url , p.lancamento
                  FROM Produtos p
                  JOIN Categorias_X_Produtos cxp ON cxp.idProduto = p.id
                  JOIN Categorias c ON c.id = cxp.idCategoria
                  WHERE p.ativo = 1
                  AND p.titulo LIKE "%'.$_GET['q'].'%"
                  OR p.descricao LIKE "%'.$_GET['q'].'%"
                  OR p.url LIKE "%'.$_GET['q'].'%"
                  OR p.sku LIKE "%'.$_GET['q'].'%"
                  OR c.categoria LIKE "%'.$_GET['q'].'%"
                  OR c.descricao LIKE "%'.$_GET['q'].'%";';
      			      $q = mysqli_query($link , $sql);
                  $cont = mysqli_num_rows($q);
                  echo '<li class="active">BUSCA - '.$_GET['q'].' (Quantidade de Produtos: '.$cont.')</li>';
                }else{
                  $sql = 'SELECT id , titulo , img , descricao , preco , preco_antigo , url , lancamento
                  FROM Produtos
                  WHERE ativo = 1 ';
      			      $q = mysqli_query($link , $sql);
                  $cont = mysqli_num_rows($q);
                  // echo '<li class="active"></li>';
                }

                ?>

            </ul>
        </div>
    </div>
    <div class="row transitionfx">

    <!-- Main component call to action -->

        <div class="container">
            <div class="row xsResponse">

		<?php

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
if($r['img'] != ''){

				echo '
				<div class="itemgrupo col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="product">
						<div class="image">
							<div class="quickview">
							</div>

							<a href="'.$site.'produto/'.$r['url'].'"><img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img" class="img-responsive"></a>

							<div class="promotion">
								'.$lancamento.'
								'.$promocao.'
							</div>
						</div>
						<div class="description">
							<h4><a href="'.$site.'produto/'.$r['url'].'">'.$r['titulo'].'</a></h4>
						</div>
						<div class="price">
						</a>
						</div>
						<div class="action-control"></div>

					</div>
				</div>';
			}
		}
		?>
            </div>

        </div>
        <!--/.container-->
    </div>
    <!--/.featuredPostContainer-->

<?php

	$sql = 'SELECT img , urlLink , titulo FROM Clientes WHERE ativo = 1;';
	$q = mysqli_query($link , $sql);
	$nr = mysqli_num_rows($q);

	if($nr > 0){
		echo'<br>';
				while($r = mysqli_fetch_assoc($q)){
					if(!is_null($r['urlLink']) || $r['urlLink']!=""){
						$linkURL = ' href="'.$r['urlLink'].'"';
					}else{
						$linkURL = '';
					}
					if(!is_null($r['titulo']) || $r['titulo']!=""){
						$cliente = $r['titulo'];
					}
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
