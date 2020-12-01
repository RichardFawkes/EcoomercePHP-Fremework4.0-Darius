
<?php
	require_once('inc/def.php');
	$_SESSION['open_cart'] = 0;
?>

<script>
    $( '#snapwidget-widget' ).attr( 'src', function ( i, val ) { return val; });

</script>
<div class="morePost row featuredPostContainer style2">

	<div class="col-lg-12 text-center">
			<br>
			<div class="texto">
    <h1>CLIENTES<h1>

    </div>
    </div>

<div>
	<!-- SnapWidget -->

<iframe src="https://snapwidget.com/embed/840125" id="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden;  width:2080px; height:160px"></iframe>


  
   
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-3 col-sm-4 col-xs-6">
                    <h3> A Loja da Lata </h3>
                    <ul>
                    <li><a href="<?php echo $site; ?>quem-somos">QUEM SOMOS?</a></li>
                    <br>
                        <li class="supportLi">
                            <p> WhatsApp</p>
											</i>		<?php if(isset($infos['telefone']) && $infos['telefone']!=""){ ?>
                            	
                                                                <h4> </i><a class="inline" href="https://whats.link/lojadalata2"> <strong>  <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                                                (11) 97105-5800 </strong> </a></h4>
														<?php } ?><br>
														<?php if(isset($infos['email']) && $infos['email']!=""){ ?>
                            <h4 > <a class="inline" href="mailto:<?php echo $infos['email']; ?>"> <i class="fa fa-envelope-o"> </i>
                                <?php echo $infos['email']; ?> </a></h4>
                                

                               

														<?php } ?>
                        </li>
                    </ul>
                </div>
                <!-- <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Linhas </h3>
                    <ul>
										<?php
											$sql = 'SELECT * FROM Categorias WHERE idTipo = 2 AND ativo = 1;';
											$q = mysqli_query($link , $sql);
											while($r = mysqli_fetch_assoc($q)){
												echo '<li><a href="'.$site.'Linhas-Proprias/'.$r['urlLink'].'">'.$r['categoria'].'</a></li>';
											}

										?>
                    </ul>
                </div> -->

                <div style="clear:both" class="hide visible-xs"></div>

                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Dúvidas </h3>
                    <ul class="list-unstyled footer-nav">
                        <li><a href="<?php echo $site; ?>faq"> Questões?</a></li>
                        <li><a href="<?php echo $site; ?>troca-devolucao"> Política de devolução</a></li>
                        <li><a href="<?php echo $site; ?>contato"> Fale conosco</a></li>

                        <!-- <li><a href="<?php echo $site; ?>politica-ambiental"> Política ambiental</a></li> -->
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Minha conta </h3>
                    <ul>
											<li><a href="<?php echo $site; ?>minhas-compras"> Minhas Compras </a></li>
                      <li><a href="<?php echo $site; ?>meus-enderecos"> Meus endereços</a></li>
                    </ul>
                </div>

                <div style="clear:both" class="hide visible-xs"></div>

                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3> Fique em contato </h3>
                    <ul>
                        <li>
                            <div class="input-append newsLatterBox text-center">
				<form method="post" action="<?php echo $site;?>assina_newsletter">
	                                <input name="email_newsletter" type="text" class="full text-center" placeholder="Email ">
					<button class="btn  bg-gray" type="submit"> Assinar <i class="fa fa-long-arrow-right"> </i></button>
				</form>
                            </div>
                        </li>
                    </ul>
			<ul class="social pull-right">
				<?php if(isset($infos['facebook']) && $infos['facebook']!=""){ ?>
					<li><a href="<?php echo $infos['facebook']; ?>" target="_blank"> <i class=" fa fa-facebook"> &nbsp; </i> </a></li>
				<?php
				}
				if(isset($infos['instagram']) && $infos['instagram']!=""){ ?>
					<li><a href="<?php echo $infos['instagram']; ?>" target="_blank"> <i class="fa fa-instagram"> &nbsp; </i> </a></li>
				<?php } ?>
<?php /*
				<li><a href="http://twitter.com"> <i class="fa fa-twitter"> &nbsp; </i> </a></li>
				<li><a href="https://plus.google.com"> <i class="fa fa-google-plus"> &nbsp; </i> </a></li>
				<li><a href="http://youtube.com"> <i class="fa fa-pinterest"> &nbsp; </i> </a></li>
				<li><a href="http://youtube.com"> <i class="fa fa-youtube"> &nbsp; </i> </a></li>
*/ ?>
			</ul>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!--/.footer-->

    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> &reg; LOJA DA LATA <?php echo date('Y'); ?> </p>

            <div class="pull-right paymentMethodImg">
            <img height="30" class="pull-right" src="<?php echo $site; ?>images/site/payment/master_card.png" alt="img">
            <img height="30" class="pull-right" src="<?php echo $site; ?>images/site/payment/visa_card.png" alt="img">
            <img height="30" class="pull-right" src="<?php echo $site; ?>images/site/payment/boleto.svg" alt="svg">

            </div>
        </div>
    </div>
    <!--/.footer-bottom-->
</footer>
