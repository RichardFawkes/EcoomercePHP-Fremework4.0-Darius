<?php
require_once('inc/def.php');
require_once($siteHD.'header.php');
require_once($siteHD.'menu.php');
//	require_once($siteHD."iugu/pagamento.php");


/*
foreach($_POST as $k=>$v){
echo "<br><br>K: ".$k;
echo "<br>V: ".$v;
}
exit;


*/



$sql ='SELECT * FROM Compras_X_Produtos cp
JOIN Compras c ON c.id = cp.idCompra
JOIN Users u ON c.idUser = u.id
WHERE cp.idCompra = "'.$_GET['id'].'"';

$rd = mysqli_query($link,$sql);
$rows = mysqli_fetch_assoc($rd);


// // Aqui garantimos que o usuário acabou de selecionar uma transportadora. Fazemos isso, pois a validade da cotação expira.
// if (isset($rows['idCotacaoTransportadora']) && !is_null($rows['idCotacaoTransportadora']) && $_SERVER['HTTP_REFERER'] == $site.'checkout2') {
//     $sql = 'UPDATE Transportadoras_Cotacoes SET selecionado = 0 WHERE idUser = "'.$_SESSION['idUser'].'" AND ativo = 1;';
//     mysqli_query($link, $sql);


//     $sql = 'UPDATE Transportadoras_Cotacoes SET selecionado = 1 WHERE idUser = "'.$_SESSION['idUser'].'" AND ativo = 1 AND id = "'.$_POST['idCotacaoTransportadora'].'";';
//     mysqli_query($link, $sql);
// } else {
//     echo '<script type="text/javascript">alert(\'Antes de efetuar o pagamento, por favor selecione uma transportadora.\');</script>';
//     ir($site.'checkout2');
//     exit;
// }








//echo nl2br($sql);
$idCompra = $_GET['id'];  //pega o id da compra

$sqlcupom = 'SELECT * FROM Cupons WHERE cupomName = "'.$_POST['cupom'].'"';
$cp = mysqli_query($link, $sqlcupom);
$as = mysqli_fetch_assoc($cp);
$rd = mysqli_num_rows($cp);

$valor = $as['valor'];



?>





<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>

<script type="text/javascript" src="https://www.lojadalata.com/inc/mascara_cc.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/formatter.js/0.1.5/formatter.min.js"></script>


<style type="text/css">
/* Non Credit Card Form */



/* Credit Card Form */
.usable-creditcard-form, .usable-creditcard-form * {
	font-size: 13px;
}
.usable-creditcard-form {
	position: relative;
	padding: 0px;
	width: 300px;
	margin-left: auto;
	margin-right: auto;
}
.usable-creditcard-form .wrapper {
	border: 1px solid #CCC;
	border-top: 1px solid #AAA;
	border-right: 1px solid #AAA;
	height: 74px;
	width: 300px;
	position: relative;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
.usable-creditcard-form .input-group {
	position: absolute;
	top: 300px;
}
.usable-creditcard-form .input-group.nmb_a {
	position: absolute;
	width: 200px;
	top: 0px;
	left: 0px;
}
.usable-creditcard-form .input-group.nmb_b {
	position: absolute;
	width: 100px;
	top: 0px;
	right: 0px;
}
.usable-creditcard-form .input-group.nmb_b input,
.usable-creditcard-form .input-group.nmb_d input {
	text-align: center;
}
.usable-creditcard-form .input-group.nmb_c {
	position: absolute;
	width: 200px;
	top: 37px;
	left: 0px;
}
.usable-creditcard-form .input-group.nmb_d {
	position: absolute;
	width: 100px;
	top: 37px;
	right: 0px;
}
.usable-creditcard-form input {
	background: none;
	display: block;
	width: 100%;
	padding: 10px;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	margin:0px;
	padding-left: 35px;
	border: none;
}
.usable-creditcard-form .input-group .icon {
	position: absolute;
	width: 22px;
	height: 22px;
	background: #CCC;
	left: 8px;
	top: 7px;
}
.usable-creditcard-form .input-group.nmb_a input {
	border-right: 1px solid #ECECEC;
}
.usable-creditcard-form .input-group.nmb_c input {
	border-top: 1px solid #ECECEC;
	border-right: 1px solid #ECECEC;
}

.usable-creditcard-form input::-webkit-input-placeholder {
	font-size: 12px;
	text-transform: none;
}
.usable-creditcard-form .input-group.nmb_d input {
	border-top: 1px solid #ECECEC;
}


.usable-creditcard-form .input-group.nmb_c input {
	text-transform: uppercase;
}
.usable-creditcard-form .accept {
	color: #999;
	font-size: 11px;
	margin-bottom: 5px;
}
.usable-creditcard-form .footer {
	margin-top: 3px;
	position: relative;
	margin-left: 5px;
	margin-right: 5px;
}
.usable-creditcard-form .footer img {
	padding: 0px;
	margin: 0px;
}
.usable-creditcard-form .iugu-btn {
	position: absolute;
	top: 0px;
	right: 0px;
}

/* Do not forget to store your images in a secure server */
.usable-creditcard-form .input-group .icon.ccic-name {
	background: url("<?php echo $site;?>iugu/img/name.png") no-repeat;
}
.usable-creditcard-form .input-group .icon.ccic-exp {
	background: url("<?php echo $site;?>iugu/img/exp.png") no-repeat;
}
.usable-creditcard-form .input-group .icon.ccic-brand {
	background: url("<?php echo $site;?>iugu/img/brands.png") no-repeat;
}
.usable-creditcard-form .input-group .icon.ccic-cvv { background: url("<?php echo $site;?>iugu/img/cvv.png") no-repeat; }

.usable-creditcard-form .input-group .icon.ccic-cvv,
.usable-creditcard-form .input-group .icon.ccic-brand
{
	-webkit-transition:background-position .2s ease-in;
	-moz-transition:background-position .2s ease-in;
	-o-transition:background-position .2s ease-in;
	transition:background-position .2s ease-in;
}

.amex .usable-creditcard-form .input-group .icon.ccic-cvv {
	background-position: 0px -22px;
}

.amex .usable-creditcard-form .input-group .icon.ccic-brand {
	background-position: 0px -110px;
}

.visa .usable-creditcard-form .input-group .icon.ccic-brand {
	background-position: 0px -22px;
}

.diners .usable-creditcard-form .input-group .icon.ccic-brand {
	background-position: 0px -88px;
}

.mastercard .usable-creditcard-form .input-group .icon.ccic-brand {
	background-position: 0px -66px;
}

/* Non Credit Card Form - Token Area */
.token-area {
	margin-top: 20px;
	margin-bottom: 20px;
	border: 1px dotted #CCC;
	display: block;
	padding: 20px;
	background: #EFEFEF;
}
</style>


<script type="text/javascript">//<![CDATA[
	$(window).load(function(){

		// Alterar
		//Iugu.setAccountID("C205A0DB5CF44980BFA535BDBD890C64");

		// Remover a linha abaixo quando passar pra produção
		Iugu.setTestMode(true);


		jQuery(function($) {
			$('#payment-form').submit(function(evt) {
				var form = $(this);

				/*
				var tokenResponseHandler = function(data) {

				if (data.errors) {
				alert("Ops! Ocorreu um erro ao tentar fazer o pagamento com o cartão: " + JSON.stringify(data.errors));
			} else {
			$("#token").val( data.id );

			form.get(0).submit();
		}
	}
	*/
	form.get(0).submit();

	return false;
});
});
});//]]>

</script>







<div class="container main-container headerOffset">
	<div class="row">
		<div class="breadcrumbDiv col-lg-12">

		</div>
	</div>
	<!--/.row-->

	<div class="row">
		<div class="col-lg-9 col-md-9 col-sm-7">
			<h2 class="section-title-inner"><span><i
				class="glyphicon glyphicon-shopping-cart"></i>Olá, <?php echo $rows['nome']?> escolha forma de pagamento!</span></h2>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
			</div>
		</div>
		<!--/.row-->

		<div class="row">
			<div class="col-lg-9 col-md-12 col-sm-12">
				<div class="row userInfo">
					<div class="col-lg 12">


						<div class="w100 clearfix">
							<ul class=" orderStep orderStepLook3">
			
								<li class="active "><a href="<?php echo $site;?>checkout3"><i class="fa fa-money  "> </i><span>Pagamento</span> </a></li>
							</li>
						</ul>
						<!--/.orderStep end-->
					</div>



					<div class="w100 clearfix">
						<div class="row userInfo">
							<div style="clear: both"></div>
							<div class="onepage-checkout col-lg-12">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="Paymentmethod">
													Pagamento
												</a>
											</h4>
										</div>
										<div id="Paymentmethod" class="_panel-collapse _collapse" role="tabpanel" aria-labelledby="Paymentmethod">
											<div class="panel-body">
												<div class="onepage-payment">
													<div class="creditCardcollapse payment-method">

														<label class="radio-inline" for="creditCard">

															<input type="radio" name="radios" id="creditCard" value=""> Cartão

														</label>
													</div>

													<div style="clear:both;"></div>

													<div id="creditCardCollapse" class="creditCard collapse ">



														<form id="payment-form" action="<?php echo $site;?>pagamentocc" method="POST">
															<div class="usable-creditcard-form">
																<div class="wrapper">
																	<div class="input-group nmb_a">
																		<div class="icon ccic-brand"></div>
																		<input type="text" name="numeroDoCartao" autocomplete="off" class="credit_card_number" data-iugu="number" placeholder="Número do Cartão" value="" type="text">
																	</div>
																	<div class="input-group nmb_b">
																		<div class="icon ccic-cvv"></div>
																		<input type="text" name="cvv" autocomplete="off" class="credit_card_cvv" data-iugu="verification_value" placeholder="CVV" value="" type="text">
																	</div>
																	<div class="input-group nmb_c">
																		<div class="icon ccic-name"></div>
																		<input type="text" name="nome" class="credit_card_name" data-iugu="full_name" placeholder="Titular do Cartão" value="" type="text">
																	</div>
																	<div class="input-group nmb_d">
																		<div class="icon ccic-exp"></div>
																		<input type="text" name="exp" autocomplete="off" class="credit_card_expiration" data-iugu="expiration" placeholder="MM/AA" value="" type="text">
																	</div>
																</div>
																<?php /*
                                                                <div class="pull-center">
                                                                <img style="height: 30px;" class="pull-right" src="images/site/card-payment.jpg" alt="card-payment">
                                                                </div>

                                                                <div class="footer text-center">
                                                                <img src="<?php echo $site;?>iugu/img/cc-icons.png" alt="Visa, Master, Diners. Amex" border="0">
                                                                </div>
                                                                */ ?>
																<!-- Parcelamento -->
																<div class="form-group">
																	<label>Parcelas</label>
																	<?php

                                                                        $sqlValor = 'SELECT SUM(qtde*valor) prod,(SELECT preco_frete FROM Compras c JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes WHERE c.id='.$idCompra.') frete,
																		SUM(qtde*valor) + (SELECT preco_frete FROM Compras c JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes WHERE c.id='.$idCompra.') tot
																		FROM Compras_X_Produtos
																		WHERE idCompra='.$idCompra.'
																		GROUP BY idCompra;';
                                                                        $resValor = mysqli_query($link, $sqlValor);
                                                                        $rowValor = mysqli_fetch_array($resValor);
                                                                        $total_carrinho = $rowValor['tot'];
                                                                        $vl_min_parc = $infos['valor_min']; #mínimo de $10 por parcela
                                                                        $qt_max_parc = $infos['parcelas']; #quantidade máxima de parcelas

                                                                        if ($total_carrinho>$vl_min_parc) {
                                                                            for ($i=1; $i <= $qt_max_parc; $i++) {
                                                                                if (($total_carrinho/$i)>$vl_min_parc) {
                                                                                    $parcelas[] = $i;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $parcelas[] = 1;
                                                                        }

                                                                     ?>
																	<select name="parcelas" class="form-control">
																		<?php
                                                                        foreach ($parcelas as $key => $value) {
                                                                            $parcela = formata_real(($total_carrinho/$value));
                                                                            echo '<option value="'.$value.'">'.$value. " x de R$ ".$parcela."</option>";
                                                                        }
                                                                        ?>
																	</select>
																</div>

																<!-- FIM PARCELAMENTO -->
															</div>

															<input name="token" id="token" value="" readonly="true" size="64" style="text-align:center" type="hidden">
															<input type="hidden" value="<?php echo $idCompra;?>" name="idCompra">

															<div class="form-group row">
																<div class="col-sm-12 text-center">
																	<br>
																	<div style="clear: both"></div>
																	<div class="pull-center"><button class="btn btn-primary btn-lg" type="submit"> Efetuar pagamento &nbsp; <i class="fa fa-arrow-circle-right"></i> </button></div>

																</div>
															</div>
														</form>




													</div>
													<!--creditCard-->


													<div class="card-paynemt-box payment-method">
														<label class="radio-inline" for="CashOnDelivery" data-toggle="collapse" data-target="#CashOnDeliveryCollapse" aria-expanded="false" aria-controls="CashOnDeliveryCollapse">
															<input name="radios" id="CashOnDelivery" value="4" type="radio"> Boleto </label>
															<div class="collapse" id="CashOnDeliveryCollapse">
																<div class="form-group">
																	<label for="CommentsOrder"></label>


																	<form id="payment-form" target="_blank" action="<?php echo $site;?>geraBoleto" method="POST">
																		<input type="hidden" value="<?php echo $idCompra;?>" name="idCompra">
																		<div class="form-group row">
																			<div class="col-sm-12 text-center">
																				<div style="clear: both"></div>
																				<div class="pull-center"><button class="btn btn-primary btn-lg" type="submit"> Confirmar Compra &nbsp; <i class="fa fa-arrow-circle-right"></i> </button></div>

																			</div>
																		</div>
																	</form>


																</div>
															</div>
														</div>
													
														<?php /*
                                                        <div class="form-group clearfix">
                                                        <br>
                                                        <label class="checkbox-inline" for="checkboxes-1">
                                                        <input name="checkboxes" id="checkboxes-1" value="1" type="checkbox">
                                                        Eu lí e concordo com os <a href="terms-conditions.html">Termos & Condições</a>
                                                        </label>

                                                        </div>
                                                        */ ?>
													</div>

												</div>
												<?php /*
                                                <div style="clear: both"></div>
                                                <div class="pull-right"><a href="thanks-for-order.html" class="btn btn-primary btn-lg "> Efetuar pagamento &nbsp; <i class="fa fa-arrow-circle-right"></i> </a></div>
                                                */ ?>
											</div>
										</div>
									</div>
								</div>
								<!--onepage-checkout-->
							</div>
							<!--/row end-->
						</div>
					</div>
				</div>
				<!--/row end-->

			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 rightSidebar">
				
		<?php
        $sqlcupom = 'SELECT * FROM Cupons WHERE cupomName = "'.$_POST['cupom'].'"';
$cp = mysqli_query($link, $sqlcupom);
$as = mysqli_fetch_assoc($cp);
$rd = mysqli_num_rows($cp);

$valor = $as['valor'];

?>

                <div class="w100 cartMiniTable">
                    <table id="cart-summary" class="std table">
                        <tbody>
                        <tr>
                        
                            <td>Total dos produtos</td>
                            <td class="price"><?php echo formata_real($rowValor['prod']); ?></td>
                        </tr>
												<?php if ($_SERVER['REQUEST_URI']!="/checkout3") { ?>
													<tr>
															<td> Desconto</td>
															<td class=" site-color" id="total-price"><?php echo formata_real($total_carrinho  * -$valor); ?></td>
													</tr>
													<tr>
															<td> Total</td>
															<td class=" site-color" id="total-price"><?php echo formata_real($total_carrinho - ($total_carrinho * $valor)); ?></td>
													</tr>
												<?php } else { ?>
                        <tr>
						<tr>
															<td> Desconto</td>
															<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal()  * -$valor); ?></td>
													</tr>
													<tr>
                            <td>Frete</td>
                            <td class="price"><?php echo formata_real($rowValor['preco_frete']); ?></td>
                        </tr>

                        <tr>
                            <td> Total </td>
                            <td class=" site-color" id="total-price"><?php echo formata_real($total_carrinho + $carrinho->getFrete()); ?></td>

                        </tr>
                       

												<?php } ?>

							<?php

                            if ($_POST['cupom'] == '' or $_POST['cupom'] == '1') {?>
          

							<?php } else { ?>
								<form  method="POST"action="carrinho-cupom">
                                <div class="input-append couponForm">
								<label > CUPOM APLICADO <i class="fa fa-tag"></i></label>
								<input class=" btn btn-dark col-lg-8"  id="appendedInputButton" type="text"  value="<?php echo $_POST['cupom']?> "placeholder="<?php echo $_POST['cupom']?>"  name="cupom" style="width:60%;" disabled>
                                    </form>
                                </div>
                            </td>
                        </tr>
							<?php }?>
                                            
                        </tbody>
                        
                        <tbody>
                        
                        </tbody>
                        
                    </table>

                 
                  
                 
                </div>
				<!--  /cartMiniTable-->

			</div>
			<!--/rightSidebar-->

		</div>
		<!--/row-->

		<div style="clear:both"></div>
	</div>
	<!-- /.main-container-->
	<div class="gap"></div>



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


	<?php
    require_once($siteHD.'footer.php');
    ?>

	<!-- Le javascript
	================================================== -->


	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo $site;?>assets/js/jquery/jquery-2.1.3.min.js"></script>


	<script src="<?php echo $site;?>assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- include  parallax plugin -->
	<script type="text/javascript" src="<?php echo $site;?>assets/js/jquery.parallax-1.1.js"></script>

	<!-- optionally include helper plugins -->
	<script type="text/javascript" src="<?php echo $site;?>assets/js/helper-plugins/jquery.mousewheel.min.js"></script>

	<!-- include mCustomScrollbar plugin //Custom Scrollbar  -->

	<script type="text/javascript" src="<?php echo $site;?>assets/js/jquery.mCustomScrollbar.js"></script>

	<!-- include icheck plugin // customized checkboxes and radio buttons   -->
	<script type="text/javascript" src="<?php echo $site;?>assets/plugins/icheck-1.x/icheck.min.js"></script>

	<!-- include grid.js // for equal Div height  -->
	<script src="<?php echo $site;?>assets/plugins/jquery-match-height-master/dist/jquery.matchHeight-min.js"></script>
	<script src="<?php echo $site;?>assets/js/grids.js"></script>

	<!-- include carousel slider plugin  -->
	<script src="<?php echo $site;?>assets/js/owl.carousel.min.js"></script>

	<!-- jQuery select2 // custom select   -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

	<!-- include touchspin.js // touch friendly input spinner component   -->
	<script src="<?php echo $site;?>assets/js/bootstrap.touchspin.js"></script>

	<!-- include custom script for site  -->
	<script src="<?php echo $site;?>assets/js/script.js"></script>


	<script>


	$(document).ready(function () {

		$('input#newAddress').on('ifChanged', function (event) {
			//alert(event.type + ' callback');
			$('#newBillingAddressBox').collapse("show");
			$('#exisitingAddressBox').collapse("hide");

		});

		$('input#exisitingAddress').on('ifChanged', function (event) {
			//alert(event.type + ' callback');
			$('#newBillingAddressBox').collapse("hide");
			$('#exisitingAddressBox').collapse("show");
		});


		$('input#creditCard').on('ifChanged', function (event) {
			//alert(event.type + ' callback');
			$('#creditCardCollapse').collapse("toggle");

		});


		$('input#CashOnDelivery').on('ifChanged', function (event) {
			//alert(event.type + ' callback');
			$('#CashOnDeliveryCollapse').collapse("toggle");

		});


	});


</script>


<script>
if (window.parent && window.parent.parent){
	window.parent.parent.postMessage(["resultsFrame", {
		height: document.body.getBoundingClientRect().height,
		slug: "8kyC8"
	}], "*")
}
</script>




</body>
</html>
