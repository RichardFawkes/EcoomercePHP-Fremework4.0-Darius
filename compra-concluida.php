<?php
	require_once('inc/def.php');
	require_once('header.php');
	require_once('menu.php');
?>


<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
	    <li><a href="<?php echo $site; ?>">Home</a></li>
                <li class="active"> Compra finalizada </li>
            </ul>
        </div>
    </div>
    <!--/.row-->


    <div class="row">
        <div class="col-lg-12 ">
            <div class="row userInfo">

                <div class="thanxContent text-center">

                    <h1> Sua compra foi efetuada com sucesso!</h1>
		    						<h4>
											Número do Pedido: <?php echo $_POST['idCompra'];?><br>
											Você pode acompanhar as entregas das suas compras, através do menu <strong><a href="<?php echo $site; ?>minhas-compras">MINHAS COMPRAS</a></strong>.
										</h4>

                </div>

                <div class="col-lg-7 col-center">
                    <h4></h4>

                    <div class="cartContent table-responsive  w100">
                        <table style="width:100%" class="cartTable cartTableBorder">
                            <tbody>

                            <tr class="CartProduct  cartTableHeader">
                                <td colspan="2"> Itens Comprados</td>


                                <td style="width:15%"></td>
                            </tr>


				<?php
					$sql = 'SELECT cp.idProduto , p.titulo , p.img , cp.qtde , cor.cor
						FROM Compras_X_Produtos cp
						JOIN Produtos p ON p.id = cp.idProduto
						JOIN Cores cor ON cor.id = cp.idCorTampa
						WHERE idCompra = '.$_POST['idCompra'].';';
					$q = mysqli_query($link , $sql);
					while($r = mysqli_fetch_assoc($q)){

						$plural = $r['qtde'] > 1 ? 's' : '';



						echo '
						    <tr class="CartProduct">
							<td class="CartProductThumb">
							    <div><a href="'.$site.'produto/'.$r['idProduto'].'"><img alt="img" src="'.$site.'images/product/mini/'.$r['img'].'"></a>							    </div>
							</td>
							<td>
							    <div class="CartDescription">
								<h4><a href="'.$site.'produto/'.$r['idProduto'].'">'.$r['titulo'].'</a></h4>
								<span class="size">Cor da tampa: '.$r['cor'].'</span>
							    </div>
							</td>
							<td class="price">'.$r['qtde'].' unidade'.$plural.' </td>
						    </tr>

						';
					}
				?>


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--/row end-->

        </div>

        <!--/rightSidebar-->

    </div>
    <!--/row-->

    <div style="clear:both"></div>
</div>
<!-- /.main-container -->

<div class="gap"></div>
<?php
	require_once('footer.php');
?>

<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $site; ?>assets/js/jquery/jquery-2.1.3.min.js"></script>
<script src="<?php echo $site; ?>assets/bootstrap/js/bootstrap.min.js"></script>
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

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>
</body>
</html>
