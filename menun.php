<?php
	require_once('inc/def.php');

	require_once($siteHD.'inc/carrinho2.php');

	$carrinho = new Carrinhos;
?>

    <!-- Just for debugging purposes. -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- include pace script for automatic web page progress bar  -->

    <script async>
        paceOptions = {
            elements: true
        };
    </script>
    <script src="<?php echo $site; ?>assets/js/pace.min.js"></script>


</head>


<style>
@media (max-width: 767px) /* @grid-float-breakpoint -1 */
{
    .navbar-fixed-top
    {
    position: relative;
    top: auto;
    }
}
</style>

<body>




<!-- Modal Login start -->
<div class="modal signUpContent fade" id="ModalLogin" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center"> Entrar na LDL </h3>
            </div>
            <div class="modal-body">
		<form method="post" action="<?php echo $site; ?>verifica_login">
			<div class="form-group login-username">
			    <div>
				<input name="email" id="login-user" class="form-control input" size="20" placeholder="Entre com seu email" type="text">
			    </div>
			</div>
			<div class="form-group login-password">
			    <div>
				<input name="senha" id="login-password" class="form-control input" size="20" placeholder="Senha" type="password">
			    </div>
			</div>
			<!-- <div class="form-group">
			    <div>
				<div class="checkbox login-remember">
				    <label>
					<input name="rememberme" value="forever" checked="checked" type="checkbox"> Lembrar de mim </label>
				</div>
			    </div>
			</div> -->
			<div>
			    <div>
				<input name="submit" class="btn  btn-block btn-lg btn-primary" value="ENTRAR" type="submit">
			    </div>
			</div>
		</form>
                <!--userForm-->

            </div>
            <div class="modal-footer">
                <p class="text-center"> Primeira vez aqui? <a data-toggle="modal" data-dismiss="modal" href="#ModalSignup"> CADASTRE-SE. </a> <br>
                    <a data-toggle="modal" data-dismiss="modal" href="#ModalEsqueci"> Esqueci minha senha </a></p>
            </div>
        </div>
        <!-- /.modal-content -->

    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.Modal Login -->
<!-- Esqueci a Senha -->
<div class="modal signUpContent fade" id="ModalEsqueci" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center"> Esqueci minha senha </h3>
            </div>
            <div class="modal-body">
		<form method="post" action="<?php echo $site; ?>recupera_senha">
			<div class="form-group login-username">
			    <div>
				<input name="email" id="login-user" class="form-control input" size="20" placeholder="Entre com seu email" type="text">
			    </div>
			</div>
			<!-- <div class="form-group">
			    <div>
				<div class="checkbox login-remember">
				    <label>
					<input name="rememberme" value="forever" checked="checked" type="checkbox"> Lembrar de mim </label>
				</div>
			    </div>
			</div> -->
			<div>
			    <div>
				<input name="submit" class="btn  btn-block btn-lg btn-primary" value="ENTRAR" type="submit">
			    </div>
			</div>
		</form>
                <!--userForm-->

            </div>
            <div class="modal-footer">
                <p class="text-center"> Primeira vez aqui? <a data-toggle="modal" data-dismiss="modal" href="#ModalSignup"> CADASTRE-SE. </a> <br>
								Já tem cadastro? <a data-toggle="modal" data-dismiss="modal" href="#ModalLogin"> Entrar </a></p>
            </div>
        </div>
        <!-- /.modal-content -->

    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.Modal Login -->


<!-- Modal Signup start -->
<div class="modal signUpContent fade" id="ModalSignup" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center"> CADASTRE-SE </h3>
            </div>
            <div class="modal-body">
                <!-- <div class="control-group"><a class="fb_button btn  btn-block btn-lg " href="#"> ENTRAR COM FACEBOOK </a></div>
                <h5 style="padding:10px 0 10px 0;" class="text-center"> OU </h5> -->

						<form method="post" action="<?php echo $site; ?>insere_user">
							<div class="form-group reg-username">
							    <div>
								<input name="nome" class="form-control input" size="20" placeholder="Nome" type="text">
							    </div>
							</div>
							<div class="form-group reg-email">
							    <div>
								<input name="email" class="form-control input" size="20" placeholder="Email" type="text">
							    </div>
							</div>
							<div class="form-group reg-password">
							    <div>
								<input name="senha" class="form-control input" size="20" placeholder="Senha" type="password">
							    </div>
							</div>
							<!-- <div class="form-group">
							    <div>
								<div class="checkbox login-remember">
								    <label>
									<input name="lembrar" id="rememberme" value="forever" checked="checked" type="checkbox">
									Lembrar de mim </label>
								</div>
							    </div>
							</div> -->
							<div>
							    <div>
								<input name="submit" class="btn  btn-block btn-lg btn-primary" value="CADASTRAR" type="submit">
							    </div>
							</div>
						</form>
                <!--userForm-->

            </div>
            <div class="modal-footer">
                <p class="text-center"> Já tem cadastro? <a data-toggle="modal" data-dismiss="modal" href="#ModalLogin">
                    Entrar </a></p>
            </div>
        </div>
        <!-- /.modal-content -->

    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.ModalSignup End -->

<!-- Fixed navbar start -->
<div class="navbar navbar-tshop navbar-fixed-top megamenu" role="navigation">
    <div class="navbar-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <div class="pull-left ">
                        <ul class="userMenu ">
													<?php if(isset($infos['telefone']) && $infos['telefone']!=""){ ?>
                            <li class="phone-number"><a href="callto:+55<?php echo $infos['telefone'];?>"> <span> <i
                                    class="glyphicon glyphicon-phone-alt "></i></span> <span class="hidden-xs" style="margin-left:5px"> <?php echo $infos['telefone'];?> </span>
                            </a></li>
													<?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 no-margin no-padding">
                    <div class="pull-right">
                        <ul class="userMenu">

<?php
	if(!isset($_SESSION['tempUser'])){
		echo ' 	<li class="hidden-xs"><a> '.$_SESSION['nome'].' </a></li>
			<li><a href="'.$site.'minhas-compras"> <span class="hidden-xs">Minhas Compras </span>
			<i class="glyphicon glyphicon-user hide visible-xs "></i> </a></li>
			<li><a href="'.$site.'meus-enderecos"> <span class="hidden-xs">Meus Endereços </span>
			<i class="glyphicon glyphicon-pushpin hide visible-xs "></i> </a></li>

			<li><a href="'.$site.'sair"> <span class="hidden-xs"> Sair </span>
			<i class="glyphicon glyphicon-log-out hide visible-xs "></i> </a></li>';

	}else{
		echo '<li><a href="#" data-toggle="modal" data-target="#ModalLogin"> <span class="hidden-xs">Entrar</span>
          <i class="glyphicon glyphicon-log-in hide visible-xs "></i> </a></li>
          <li class="hidden-xs"><a href="#" data-toggle="modal" data-target="#ModalSignup"> <span class="hidden-xs">Cadastre-se</span>
					<i class="glyphicon glyphicon-log-in hide visible-xs "></i> </a></li>';
	}

 ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.navbar-top-->

    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span
                    class="sr-only"> Toggle navigation </span> <span class="icon-bar"> </span> <span
                    class="icon-bar"> </span> <span class="icon-bar"> </span></button>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"><i
                    class="fa fa-shopping-cart colorWhite"> </i> <span
                    class="cartRespons colorWhite"> Carrinho (<?php echo formata_real($carrinho->getSubTotal()); ?>) </span></button>
            <a class="navbar-brand " href="<?php echo $site; ?>"> <img src="<?php echo $site; ?>images/logo.png" alt="TSHOP"> </a>

            <!-- this part for mobile -->
            <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
                <div class="input-group">
                    <button class="btn btn-nobg getFullSearch" type="button"><i class="fa fa-search"> </i></button>
                </div>
                <!-- /input-group -->

            </div>
        </div>

        <!-- this part is duplicate from cartMenu  keep it for mobile -->
        <div class="navbar-cart  collapse">
            <div class="cartMenu <?php if($_SESSION['open_cart']==1){ echo 'open'; }?>  col-lg-4 col-xs-12 col-md-4 ">
                <div class="w100 miniCartTable scroll-pane">
                    <table>
                        <tbody>

				<?php
				foreach($carrinho->getProdutos() as $k=>$v){
					echo '
					<tr class="miniCartProduct">
						<td style="width:20%" class="miniCartProductThumb">
							<div><a href="'.$site.'produto/'.$v['url'].'"> <img src="'.$site.'images/product/mini/'.$v['img'].'" alt="img"> </a></div>
						</td>
						<td style="width:40%">
							<div class="miniCartDescription">
								<h4><a href="'.$site.'produto/'.$v['url'].'"> '.$v['titulo'].' </a></h4>
								<span class="size">'.$v['cor'].' <br> '.$v['descricao'].' </span>

								<div class="price"><span> '.formata_real($v['preco']*$v['qtde']).' </span></div>
							</div>
						</td>
						<td style="width:10%" class="miniCartQuantity"><a> X '.$v['qtde'].' </a></td>
						<td style="width:15%" class="miniCartSubtotal"><span> '.formata_real($v['preco']).' </span></td>
						<td style="width:5%" class="delete"><a href="'.$site.'remove_produto_do_carrinho?idCarrinho='.$v['idCarrinho'].'"> <i class="glyphicon glyphicon-trash"></i> </a></td>
					</tr>';
				}
				?>
                        </tbody>
                    </table>
                </div>
                <!--/.miniCartTable-->

                <div class="miniCartFooter  miniCartFooterInMobile text-right">
                    <h3 class="text-right subtotal"> Subtotal: <?php echo formata_real($carrinho->getSubTotal()); ?> </h3>
		    <a class="btn btn-sm btn-primary" href="<?php echo $site; ?>carrinhobcc"> FINALIZAR </a>
		</div>
                <!--/.miniCartFooter-->

            </div>
            <!--/.cartMenu-->
        </div>
        <!--/.navbar-cart-->

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <?php
								// <li class="dropdown megamenu-fullwidth"><a data-toggle="dropdown" class="dropdown-toggle" href="#"> Linhas <b class="caret"> </b> </a>
								?>

<?php /*
                    <ul class="dropdown-menu">
                        <li class="megamenu-content ">
                            <ul class="col-lg-3  col-sm-3 col-md-3 unstyled noMarginLeft newCollectionUl">
                                <li class="no-border">
                                    <p class="promo-1"><strong> NEW COLLECTION </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>category.html"> ALL NEW PRODUCTS </a></li>
                                <li><a href="<?php echo $site; ?>category.html"> NEW TOPS </a></li>
                                <li><a href="<?php echo $site; ?>category.html"> NEW SHOES </a></li>
                                <li><a href="<?php echo $site; ?>category.html"> NEW TSHIRT </a></li>
                                <li><a href="<?php echo $site; ?>category.html"> NEW TSHOP </a></li>
                            </ul>
                            <ul class="col-lg-3  col-sm-3 col-md-3  col-xs-4">
                                <li><a class="newProductMenuBlock" href="<?php echo $site; ?>product-details.html"> <img
                                        class="img-responsive" src="<?php echo $site; ?>images/site/promo1.jpg" alt="product"> <span
                                        class="ProductMenuCaption"> <i class="fa fa-caret-right"> </i> JEANS </span>
                                </a></li>
                            </ul>
                            <ul class="col-lg-3  col-sm-3 col-md-3 col-xs-4">
                                <li><a class="newProductMenuBlock" href="<?php echo $site; ?>product-details.html"> <img
                                        class="img-responsive" src="<?php echo $site; ?>images/site/promo2.jpg" alt="product"> <span
                                        class="ProductMenuCaption"> <i
                                        class="fa fa-caret-right"> </i> PARTY DRESS </span> </a></li>
                            </ul>
                            <ul class="col-lg-3  col-sm-3 col-md-3 col-xs-4">
                                <li><a class="newProductMenuBlock" href="<?php echo $site; ?>product-details.html"> <img
                                        class="img-responsive" src="<?php echo $site; ?>images/site/promo3.jpg" alt="product"> <span
                                        class="ProductMenuCaption"> <i class="fa fa-caret-right"> </i> SHOES </span>
                                </a></li>
                            </ul>
                        </li>
                    </ul>
*/ ?>
                </li>

                <!-- change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width -->
                <!-- <li class="dropdown megamenu-80width "><a data-toggle="dropdown" class="dropdown-toggle" href="#"> PRONTA-ENTREGA</a> -->
<?php /*
                    <ul class="dropdown-menu">
                        <li class="megamenu-content">

                            <!-- megamenu-content -->

                            <ul class="col-lg-2  col-sm-2 col-md-2  unstyled noMarginLeft">
                                <li>
                                    <p><strong> Women Collection </strong></p>
                                </li>
                                <li><a href="#"> Kameez </a></li>
                                <li><a href="#"> Tops </a></li>
                                <li><a href="#"> Shoes </a></li>
                                <li><a href="#"> T shirt </a></li>
                                <li><a href="#"> TSHOP </a></li>
                                <li><a href="#"> Party Dress </a></li>
                                <li><a href="#"> Women Fragrances </a></li>
                            </ul>
                            <ul class="col-lg-2  col-sm-2 col-md-2  unstyled">
                                <li>
                                    <p><strong> Men Collection </strong></p>
                                </li>
                                <li><a href="#"> Panjabi </a></li>
                                <li><a href="#"> Male Fragrances </a></li>
                                <li><a href="#"> Scarf </a></li>
                                <li><a href="#"> Sandal </a></li>
                                <li><a href="#"> Underwear </a></li>
                                <li><a href="#"> Winter Collection </a></li>
                                <li><a href="#"> Men Accessories </a></li>
                            </ul>
                            <ul class="col-lg-2  col-sm-2 col-md-2  unstyled">
                                <li>
                                    <p><strong> Top Brands </strong></p>
                                </li>
                                <li><a href="#"> Diesel </a></li>
                                <li><a href="#"> Farah </a></li>
                                <li><a href="#"> G-Star RAW </a></li>
                                <li><a href="#"> Lyle & Scott </a></li>
                                <li><a href="#"> Pretty Green </a></li>
                                <li><a href="#"> TSHOP </a></li>
                                <li><a href="#"> TANJIM </a></li>
                            </ul>
                            <ul class="col-lg-3  col-sm-3 col-md-3 col-xs-6">
                                <li class="no-margin productPopItem "><a href="<?php echo $site; ?>product-details.html"> <img
                                        class="img-responsive" src="<?php echo $site; ?>images/site/g4.jpg" alt="img"> </a> <a
                                        class="text-center productInfo alpha90" href="<?php echo $site; ?>product-details.html"> Eodem modo
                                    typi <br>
                                    <span> $60 </span> </a></li>
                            </ul>
                            <ul class="col-lg-3  col-sm-3 col-md-3 col-xs-6">
                                <li class="no-margin productPopItem relative"><a href="<?php echo $site; ?>product-details.html"> <img
                                        class="img-responsive" src="<?php echo $site; ?>images/site/g5.jpg" alt="img"> </a> <a
                                        class="text-center productInfo alpha90" href="<?php echo $site; ?>product-details.html"> Eodem modo
                                    typi <br>
                                    <span> $60 </span> </a></li>
                            </ul>
                        </li>
                    </ul>
*/ ?>
                </li>

<?php /*
<li class="dropdown megamenu-fullwidth"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
		CRIE SUA LATA <b class="caret"> </b> </a>
                    <ul class="dropdown-menu">
                        <li class="megamenu-content ProductDetailsList">

                            <!-- remove .ProductDetailsList class from megamenu-content || this class for demo uses only -->

                            <!-- megamenu-content -->

                            <!-- remove .ProductDetailsList class from megamenu-content || this class for demo uses only -->

                            <!-- megamenu-content -->

                            <h3 class="promo-1 no-margin hidden-xs">60 + HTML PAGES || AVAILABLE ONLY AT WRAP
                                BOOTSTRAP </h3>

                            <h3 class="promo-1sub hidden-xs"> Complete Parallax E-Commerce Boostrap Template, Responsive
                                on any Device, 10+ color Theme + Parallax Effect </h3>

                            <ul class="col-lg-2  col-sm-2 col-md-2 unstyled">
                                <li class="no-border">
                                    <p><strong> Home Pages </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>index.html"> Home Version 1 </a></li>
                                <li><a href="<?php echo $site; ?>index2.html"> Home Version 2 </a></li>
                                <li><a href="<?php echo $site; ?>index3.html"> Home Version 3 (BOXES) </a></li>
                                <li><a href="<?php echo $site; ?>index4.html"> Home Version 4 (LOOK 2)</a></li>
                                <li><a href="<?php echo $site; ?>index5.html"> Home Version 5 (LOOK 3)</a></li>
                                <li><a href="<?php echo $site; ?>index6.html"> Home Version 6 (STORY)</a></li>
                                <li><a href="<?php echo $site; ?>index-v-7.html"> Home Version 7 (Flat) <span class="label label-success">new</span></a>
                                </li>
                                <li><a href="<?php echo $site; ?>index-header2.html"> Header Version 2 </a></li>
                                <li><a href="<?php echo $site; ?>index-header3.html"> Header Version 3 </a></li>

                                <li><a href="<?php echo $site; ?>index-logged-in.html">Topbar Logged In user menu <span
                                        class="label label-success">new</span></a></li>
                                <li><a href="<?php echo $site; ?>sidebar-shopping-cart.html">Sidebar Shopping cart <span
                                        class="label label-success">new</span></a></li>
                            </ul>

                            <ul class="col-lg-2  col-sm-2 col-md-2 unstyled">
                                <li class="no-border">
                                    <p><strong> Featured Pages </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>category.html"> Category </a></li>
                                <li><a href="<?php echo $site; ?>category2.html"> Category Style 2 [Parallax] </a></li>
                                <li><a href="<?php echo $site; ?>sub-category.html"> Sub Category </a></li>
                                <li><a href="<?php echo $site; ?>category-list.html"> Category List View </a></li>
                                <li><a href="<?php echo $site; ?>category-product-hover.html"> Category [Product Hover] </a></li>
                                <li><a href="<?php echo $site; ?>category-product-slide.html"> Category [Product Slide] </a></li>

                                <li><a href="<?php echo $site; ?>cart.html"> Cart </a></li>
                                <li><a href="about-us-3.html"> About Us V3 <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>about-us-2.html"> About Us V2 </a></li>
                                <li><a href="<?php echo $site; ?>about-us.html"> About Us V1 </a></li>

                                <li><a href="<?php echo $site; ?>contact-us.html"> Contact us </a></li>
                                <li><a href="<?php echo $site; ?>contact-us-2.html"> Contact us 2 (No Fixed Map) </a></li>
                                <li><a href="<?php echo $site; ?>terms-conditions.html"> Terms &amp; Conditions </a></li>

                            </ul>

                            <ul class="col-lg-3  col-sm-3 col-md-3 unstyled ">
                                <li class="no-border">
                                    <p><strong> Product Details </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>product-details.html"> Product Details v1 </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style2.html"> Product Details v 2 </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style3.html"> Product Details v 3 (Custom Thumbnail
                                    Position)</a></li>
                                <li><a href="<?php echo $site; ?>product-details-style4.html"> Product Details v 4 (with litebox)</a></li>


                                <li><a href="<?php echo $site; ?>product-details-style5.html"> Product Details v 5 (Flat) <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-1.html"> Product Details v 5.1 <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-2.html"> Product Details v 5.2 <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-3.html"> Product Details v 5.3 <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-3-fadein.html"> Product Details v 5.3.1
                                    <small>(fadein)</small>
                                    <span
                                            class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-4.html"> Product Details v 5.4 <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-4.1-popup-video.html"> Product Details v 5.4.1
                                    <small>(popup video)</small>
                                    <span
                                            class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>product-details-style5-4.1-with-zoom.html"> Product Details v 5.4.1
                                    <small>(zoom + litebox)</small>
                                    <span
                                            class="label label-success">NEW</span></a></li>

                            </ul>
                            <ul class="col-lg-2  col-sm-2 col-md-2 unstyled">
                                <li class="no-border">
                                    <p><strong> Checkout </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>checkout-0.html"> Checkout Before </a></li>
                                <li><a href="<?php echo $site; ?>checkout-1.html"> checkout step 1 </a></li>
                                <li><a href="<?php echo $site; ?>checkout-2.html"> checkout step 2 </a></li>
                                <li><a href="<?php echo $site; ?>checkout-3.html"> checkout step 3 </a></li>
                                <li><a href="<?php echo $site; ?>checkout-4.html"> checkout step 4 </a></li>
                                <li><a href="<?php echo $site; ?>checkout-5.html"> checkout step 5 </a></li>
                                <li><a href="<?php echo $site; ?>one-page-checkout.html"> One page checkout <span
                                        class="label label-success">NEW</span> </a></li>
                                <li><a href="<?php echo $site; ?>thanks-for-order.html"> Thanks for order</a></li>
                            </ul>
                            <ul class="col-lg-1  col-sm-1 col-md-1 no-padding unstyled">
                                <li class="no-border">
                                    <p><strong> User Account </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>account-1.html"> Account Login </a></li>
                                <li><a href="<?php echo $site; ?>account.html"> My Account </a></li>
                                <li><a href="<?php echo $site; ?>my-address.html"> My Address </a></li>
                                <li><a href="<?php echo $site; ?>user-information.html"> User information </a></li>
                                <li><a href="<?php echo $site; ?>wishlist.html"> Wish List </a></li>
                                <li><a href="<?php echo $site; ?>order-list.html"> Order list </a></li>
                                <li><a href="<?php echo $site; ?>order-status.html"> Order Status </a></li>
                                <li><a href="<?php echo $site; ?>forgot-password.html"> Forgot Password </a></li>
                                <li><a href="<?php echo $site; ?>invoice-A4.html">invoice A4.html <span
                                        class="label label-success">new</span> </a></li>
                            </ul>
                            <ul class="col-lg-2  col-sm-2 col-md-2 unstyled">
                                <li class="no-border">
                                    <p><strong> &nbsp; </strong></p>
                                </li>
                                <li><a href="<?php echo $site; ?>blog.html"> Blog </a></li>
                                <li><a href="<?php echo $site; ?>blog-details.html"> Blog Details </a></li>
                                <li><a href="<?php echo $site; ?>single-product-modal.html"> Single Product Details Modal</a></li>
                                <li><a href="<?php echo $site; ?>single-subscribe-modal.html"> Single Subscribe Modal</a></li>
                                <li><a href="<?php echo $site; ?>index-store-switcher-modal.html"> store switcher modal</a></li>
                                <li><a href="<?php echo $site; ?>error-page.html"> Error Page </a></li>
                                <li><a href="<?php echo $site; ?>blank-page.html"> Blank Page </a></li>
                                <li><a href="<?php echo $site; ?>form.html"> Basic Form Element </a></li>
                            </ul>

                        </li>
                    </ul>
										                </li>
*/ ?>


<?php /*                <li><a href="all-page-link.html" target="_blank"> All Page Link </a></li> */ ?>
								<?php
								$sql = 'SELECT * FROM Categorias WHERE ativo = 1 AND idTipo = 1;';
								$q = mysqli_query($link , $sql);
								$nr = mysqli_num_rows($q);

								if($nr > 0){
									while($r = mysqli_fetch_assoc($q)){
										echo '<li><a href="'.$site.'Categoria/'.$r['urlLink'].'">'.$r['categoria'].'</a></li>';
									}
								}
								?>

            </ul>


            <!--- this part will be hidden for mobile version -->
            <div class="nav navbar-nav navbar-right hidden-xs">
                <div class="dropdown  cartMenu <?php if($_SESSION['open_cart']==1){ echo 'open'; }?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                        class="fa fa-shopping-cart"> </i> <span class="cartRespons"> Carrinho (<?php echo formata_real($carrinho->getSubTotal()); ?>) </span> <b
                        class="caret"> </b> </a>

                    <div class="dropdown-menu col-lg-4 col-xs-12 col-md-4 ">
                        <div class="w100 miniCartTable scroll-pane">
                            <table>
                                <tbody>

				<?php
         

                
             
                    
                    foreach($carrinho->getProdutos() as $k=>$v){
						echo '
						<tr class="miniCartProduct">
                            <td style="width:20%" class="miniCartProductThumb">
                            '; if($v['idProjeto']== ''){
                                echo'
                               
                            <div><a href="'.$site.'produto/'.$v['url'].'"> <img src="'.$site.'images/product/mini/'.$v['img'].'" alt="img">';
                            }else{ echo ' 
                            <div><a href="'.$site.'produto/'.$v['url'].'"> <img src="'.$editorlink.'productthumb.ashx?p='.$v['idProjeto'].'" alt="img">';
                        }
						echo'	</a></div>
						    </td>
						    <td style="width:40%">
							<div class="miniCartDescription">
							    <h4><a href="'.$site.'produto/'.$v['url'].'"> '.$v['titulo'].' </a></h4>

							    <div class="price"><span> '.formata_real($v['preco']*$v['qtde']).' </span></div>
							</div>
						    </td>
						    <td style="width:10%" class="miniCartQuantity"><a> X '.$v['qtde'].' </a></td>
						    <td style="width:15%" class="miniCartSubtotal"><span> '.formata_real($v['preco']).' </span></td>
						    <td style="width:5%" class="delete"><a href="'.$site.'remove_produto_do_carrinho?idCarrinho='.$v['idCarrinho'].'"> <i class="glyphicon glyphicon-trash"></i> </a></td>
                        </tr>';
                    
                }
             
              
                
            
				?>
                                </tbody>
                            </table>
                        </div>
                        <!--/.miniCartTable-->

                        <div class="miniCartFooter text-right">
                            <h3 class="text-right subtotal"> Subtotal: <?php echo formata_real($carrinho->getSubTotal()); ?> </h3>
<?php /*                           <a class="btn btn-sm btn-danger" href="<?php echo $site; ?>carrinho"> <i class="fa fa-shopping-cart"> </i> VER CARRINHO </a> */ ?>
				<a class="btn btn-sm btn-primary" href="<?php echo $site; ?>carrinhobcc"> FINALIZAR </a></div>
                        <!--/.miniCartFooter-->

                    </div>
                    <!--/.dropdown-menu-->
                </div>
                <!--/.cartMenu-->

                <div class="search-box">
                    <div class="input-group">
                        <button class="btn btn-nobg getFullSearch" type="button" ><i class="fa fa-search"> </i></button>
                    </div>
                    <!-- /input-group -->

                </div>
                <!--/.search-box -->
            </div>
            <!--/.navbar-nav hidden-xs-->
        </div>
        <!--/.nav-collapse -->

    </div>
    <!--/.container -->

    <div class="search-full text-right"><a class="pull-right search-close"> <i class=" fa fa-times-circle"> </i> </a>

        <div class="searchInputBox pull-right">
					<form action="<?php echo $site;?>produtos" method="get">
            <input type="search" data-searchurl="search?=" name="q" placeholder="Digite sua busca" class="search-input">
            <button class="btn-nobg search-btn" type="submit"><i class="fa fa-search"> </i></button>
					</form>
        </div>
    </div>
    <!--/.search-full-->

</div>
<!-- /.Fixed navbar  -->
