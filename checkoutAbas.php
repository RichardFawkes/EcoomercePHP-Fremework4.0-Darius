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
                <li><a href="<?php echo $site; ?>carrinho">Carrinho</a></li>
                <li class="active"> Checkout</li>
            </ul>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i
                    class="glyphicon glyphicon-shopping-cart"></i> CHECKOUT</span></h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
            <h4 class="caps"><a href="<?php echo $site; ?>carrinho"><i class="fa fa-chevron-left"></i> Voltar para o carrinho </a></h4>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-12">


                    <div class="w100 clearfix">
                        <ul class="orderStep orderStepLook2">
                            <li class="active"><a href="checkout-endereco"> <i class="fa fa-map-marker"></i> <span> Endereço</span></a></li>
                            <li><a href="checkout-frete"><i class="fa fa-truck "> </i><span>Frete</span> </a></li>
                            <li><a href="checkout-pagamento"><i class="fa fa-money  "> </i><span>Pagamento</span> </a></li>
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
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#BillingInformation" aria-expanded="true" aria-controls="BillingInformation">
                                                    Endereço de entrega
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="BillingInformation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="BillingInformation">
                                            <div class="panel-body">
                                                <form class="form-inline" action="page" method="post">
                                                    <label class="radio inline">
                                                        <input id="exisitingAddress" type="radio" value="option1" name="add"> Usar endereço cadastrado
                                                    </label>&nbsp;&nbsp;
                                                    <label class="radio inline">
                                                        <input id="newAddress" type="radio" value="option2" name="add">
                                                        Quero usar um novo endereço
                                                    </label>
                                                </form>
                                                <hr>
                                                <div style="clear: both"></div>
                                                <div id="exisitingAddressBox" class="collapse in">
                                                    <div class="form-group uppercase"><strong>Selecione seu endereço</strong></div>
                                                    <form>
                                                        <div class="form-group required maxwidth300">
                                                            <label for="InputCountry">Select Address <sup>*</sup>
                                                            </label>
                                                            <select class="form-control" required aria-required="true" id="SelectAddress" name="SelectAddress">
                                                                <option value="">Address 1</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="newBillingAddressBox" class="collapse">
                                                    <div class="form-group uppercase"><strong>Novo endereço</strong></div>
                                                    <form>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group required">
                                                                <label for="InputName">Nome <sup>*</sup> </label>
                                                                <input required type="text" class="form-control" id="InputName" placeholder="Nome">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputLastName">Sobrenome <sup>*</sup>
                                                                </label>
                                                                <input required type="text" class="form-control" id="InputLastName" placeholder="Sobrenome">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputEmail">Email </label>
                                                                <input type="text" class="form-control" id="InputEmail" placeholder="Email">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputCompany">Empresa </label>
                                                                <input type="text" class="form-control" id="InputCompany" placeholder="Empresa">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputAddress">Logradouro <sup>*</sup> </label>
                                                                <input required type="text" class="form-control" id="InputAddress" placeholder="Logradouro">
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="InputCity">Número <sup>*</sup> </label>
                                                                <input required type="text" class="form-control" id="InputCity" placeholder="Número">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputAddress2">Complemento </label>
                                                                <input type="text" class="form-control" id="InputAddress2" placeholder="Complemento">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputState">Estado <sup>*</sup> </label>

                                                                <select class="form-control" required aria-required="true" id="InputState" name="InputState">
                                                                    <option value="">Selecione</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group required">
                                                                <label for="InputZip">CEP <sup>*</sup>
                                                                </label>
                                                                <input required type="text" class="form-control" id="InputZip" placeholder="CEP">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputCountry">Cidade <sup>*</sup> </label>
                                                                <select class="form-control" required aria-required="true" id="InputCountry" name="InputCountry">
                                                                    <option value="">Selecione</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputAdditionalInformation">Informações adicionais </label>
                                                                <textarea rows="3" cols="26" name="InputAdditionalInformation" class="form-control" id="InputAdditionalInformation"></textarea>
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputMobile">Telefone <sup>*</sup></label>
                                                                <input required type="tel" name="InputMobile" class="form-control" id="InputMobile">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="addressAlias">Por favor coloque um título para este endereço. <sup>*</sup></label>
                                                                <input required type="text" name="addressAlias" class="form-control" id="addressAlias" placeholder="Título deste endereço">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#Deliverymethod" aria-expanded="false" aria-controls="Deliverymethod">
                                                    Frete
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="Deliverymethod" class="panel-collapse collapse" role="tabpanel"
                                             aria-labelledby="Deliverymethod">
                                            <div class="panel-body">
                                                <div class="w100 row">
                                                    <div class="form-group col-lg-12 col-sm-12 col-md-12 -col-xs-12">
                                                        <table style="width:100%" class="table-bordered table tablelook2">
                                                            <tbody>
                                                            <tr>
                                                                <td> Transportadora</td>
                                                                <td>Prazo</td>
                                                                <td>Valor</td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="radio">
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                                                    <i class="fa  fa-plane fa-2x"></i> </label></td>
                                                                <td>2 dias</td>
                                                                <td>R$51,25</td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="radio">
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                                                    <i class="fa fa-truck fa-2x"></i> </label></td>
                                                                <td>5 dias</td>
                                                                <td>R$75,42</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#Paymentmethod" aria-expanded="false" aria-controls="Paymentmethod">
                                                    Pagamento
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="Paymentmethod" class="panel-collapse collapse" role="tabpanel" aria-labelledby="Paymentmethod">
                                            <div class="panel-body">
                                                <div class="onepage-payment">
                                                    <div class="creditCardcollapse payment-method">
                                                        <label class="radio-inline" for="creditCard">
                                                            <input type="radio" name="radios" id="creditCard" value="">
                                                            <img style="height: 30px;" class="pull-right" src="images/site/card-payment.jpg" alt="card-payment">
                                                        </label>
                                                    </div>
                                                    <div style="clear:both;"></div>

                                                    <div id="creditCardCollapse" class="creditCard collapse ">

                                                        <div>

                                                            <label for="saveInfoid">&nbsp;Cartão</label>
                                                        </div>
                                                    </div>
                                                    <!--creditCard-->


                                                    <div class="card-paynemt-box payment-method">
                                                        <label class="radio-inline" for="CashOnDelivery" data-toggle="collapse" data-target="#CashOnDeliveryCollapse" aria-expanded="false" aria-controls="CashOnDeliveryCollapse">
                                                            <input name="radios" id="CashOnDelivery" value="4" type="radio"> Boleto </label>
                                                        <div class="collapse" id="CashOnDeliveryCollapse">
                                                            <div class="form-group">
                                                                <label for="CommentsOrder">Visualizar boleto</label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group clearfix">
                                                        <br>
                                                        <label class="checkbox-inline" for="checkboxes-1">
                                                            <input name="checkboxes" id="checkboxes-1" value="1" type="checkbox">
                                                            Eu lí e concordo com os <a href="terms-conditions.html">Termos & Condições</a>
                                                        </label>
                                                    </div>
                                                    <div class="pull-left"><a href="thanks-for-order.html" class="btn btn-primary btn-lg ">
                                                        Efetuar pagamento &nbsp; <i class="fa fa-arrow-circle-right"></i> </a></div>
                                                </div>
                                            </div>
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
		<div class="w100 cartMiniTable">
		    <table id="cart-summary" class="std table">
			<tbody>
			<tr>
			    <td>Total dos produtos</td>
			    <td class="price">R$<?php echo $carrinho->getSubTotal(); ?></td>
			</tr>
			<tr style="">
			    <td>Frete</td>
			    <td class="price"><span class="success">Grátis!</span></td>
			</tr>
			<tr class="cart-total-price ">
			    <td>Desconto</td>
			    <td class="price">R$216.51</td>
			</tr>
			<tr>
			    <td> Total</td>
			    <td class=" site-color" id="total-price">R$<?php echo $carrinho->getSubTotal(); ?></td>
			</tr>
<?php /*
			<tr>
			    <td colspan="2">
				<div class="input-append couponForm">
				    <input class="col-lg-8" id="appendedInputButton" type="text" placeholder="Cupom" style="width:60%;">
				    <button class="col-lg-4 btn btn-success" type="button" style="width:38%; padding:8px 8px;">Validar</button>
				</div>
			    </td>
			</tr>
*/ ?>
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

</body>
</html>
