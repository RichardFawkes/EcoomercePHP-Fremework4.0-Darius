<?php
	require_once('inc/def.php');  

	
if(isset($_SESSION['tempUser'])){
	ir($site.'login?cupom='.$_POST["cupom"]."");
	
	
	exit;
}

	$sql = 'SELECT c.id
		FROM Carrinho c
		JOIN Produtos p ON p.id = c.idProduto
		WHERE c.idUser = '.$_SESSION['idUser'].';';
	$q = mysqli_query($link , $sql);
	$nr = mysqli_num_rows($q);

	if($nr == 0){
		ir($site , 'Seu carrinho está vazio. Por favor coloque algum produto no carrinho, antes de continuar.');
		exit;
	}

	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');

$sql = 'SELECT id , titulo, logradouro
FROM Users_X_Enderecos
WHERE idUser = "'.$_SESSION['idUser'].'"
AND ativo=1;';
$q = mysqli_query($link , $sql);
$qtdeEnderecos = mysqli_num_rows($q);


?>

<script type="text/javascript">

	function foco(obj){
		document.getElementById(obj).focus();
	}

	function destaca(obj){
		obj.className = "destaque";
	}

	function retira_destaque(obj){
		obj.className = "";
	}


	function valida_cpf(){
		cpf = document.getElementById('cpf').value;
		if (cpf.length != 14){
			document.getElementById('cpf').className = "destaque";
			document.getElementById('cpf').focus();
			alert('CPF inválido. Por favor verifique se digitou corretamente.');
		}
	}


	function submit_form(){
		distribuidor = document.getElementById('distribuidor').value;
		if (cpf.length != 14){
			document.getElementById('cpf').className = "destaque"; 
			alert('CPF inválido. Por favor verifique se digitou corretamente.');
			document.getElementById('cpf').focus();
			return false;
		}  
	}


</script>



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
                            <li class="active"><a href="<?php echo $site;?>checkout1"> <i class="fa fa-map-marker"></i> <span> Endereço</span></a></li>
                            <li><a><i class="fa fa-truck "> </i><span>Frete</span> </a></li>
                            <li><a><i class="fa fa-money  "> </i><span>Pagamento</span> </a></li>
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
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="BillingInformation">
                                                    Endereço de entrega
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="BillingInformation" role="tabpanel" aria-labelledby="BillingInformation">
                                            <div class="panel-body">
                                                <form method="POST" action="checkout2" id="form_novo_endereco">
																									<?php if($qtdeEnderecos > 0){ ?>
<?php 					

$sql  = 'SELECT * FROM Compras WHERE idUser = "'.$_SESSION['idUser'].'" AND idCupom = "'.$_POST['cupom'].'";';
$sqlq = mysqli_query($link,$sql);
$rowu = mysqli_num_rows($sqlq);

$sqlcupom = 'SELECT * FROM Cupons WHERE cupomName = "'.$_POST['cupom'].'"';
$cp = mysqli_query($link,$sqlcupom);
$asd = mysqli_fetch_assoc($cp);
$rd = mysqli_num_rows($cp);

if($rowu <= 0 AND date('yy-m-d') >= $asd['dataInicio'] AND date('yy-m-d') <= $asd['dataFinal'])  
{?>
	<input type="hidden" name="cupom" value="<?php echo $_POST['cupom']?>">
 <?php                                           
}
?>
																									
										   <div class="form-inline">

                                                    <label class="radio inline">
                                                        <input id="newAddress" type="radio" value="1" name="novoEndereco" checked="checked"> Usar um novo endereço
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label class="radio inline">
                                                        <input id="exisitingAddress" type="radio" value="0" name="novoEndereco"> Usar endereço cadastrado
                                                    </label>

                                                </div>
                                                <hr>
                                                <div style="clear: both"></div>

                                                <div id="exisitingAddressBox" class="collapse">
                                                        <div class="form-group required maxwidth300">
                                                            <label for="InputCountry">Selecione seu endereço <sup>*</sup></label>
                                                            <select class="form-control" required aria-required="true" id="SelectAddress" name="enderecoSelecionado">
																								<?php
																									while($r = mysqli_fetch_assoc($q)){
																										echo '<option value="'.$r['id'].'">'.$r['titulo'].' ('.$r['logradouro'].')</option>';
																									}
																								?>
                                                            </select>
                                                        </div>
                                                </div>
																							<?php } ?>

                                                <div id="newBillingAddressBox" class="collapse in">
                                                    <div class="form-group uppercase"><strong>Novo endereço</strong></div>

                                                        <div class="col-xs-12 col-sm-6">

                                                            <div class="form-group required">
                                                                <label for="InputName">Nome <sup>*</sup> </label>
                                                                <input type="text" class="form-control" placeholder="Nome" name="nome">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputLastName">Sobrenome <sup>*</sup> </label>
                                                                <input type="text" class="form-control" placeholder="Sobrenome" name="sobrenome">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputEmail">Email </label>
                                                                <input type="text" class="form-control" name="email" placeholder="Email">
                                                            </div>
																														<div class="form-inline">
																															<label>Tipo Pessoa </label>
																																<label class="radio inline">
																																		<input id="tipo_pessoaPF" class="tipo_pessoa" type="radio" value="PF" name="tipo_pessoa" checked="checked"> Física
																																</label>&nbsp;&nbsp;&nbsp;&nbsp;

																																<label class="radio inline">
																																		<input id="tipo_pessoaPJ" class="tipo_pessoa" type="radio" value="PJ" name="tipo_pessoa"> Jurídica
																																</label>

																														</div>
																														<div class="form-group required PF">
																																<label for="InputMobile">CPF <sup>*</sup></label>
																																<input type="text" name="cpf" class="form-control cpf" placeholder="CPF" >
																														</div>
                                                            <div class="form-group hide PJ">
                                                                <label for="InputCompany">Empresa </label>
                                                                <input type="text" class="form-control" name="empresa" placeholder="Empresa">
                                                            </div>
                                                            <div class="form-group required hide PJ">
                                                                <label for="InputMobile">CNPJ <sup>*</sup></label>
                                                                <input type="text" name="cnpj" class="form-control cnpj" placeholder="CNPJ" >
                                                            </div>
                                                            <div class="form-group required hide PJ">
                                                                <label for="InputMobile">Inscricao estadual <sup>*</sup></label>
                                                                <input type="text" name="inscricao_estadual" class="form-control" placeholder="Inscrição Estadual">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputMobile">Telefone <sup>*</sup></label>
                                                                <input type="tel" name="telefone" class="form-control tel" placeholder="Telefone">
                                                            </div>



                                                            <div class="form-group">
                                                                <label for="InputAdditionalInformation">Informações adicionais </label>
                                                                <textarea rows="3" cols="26" name="informacoes_adicionais" class="form-control" ></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
																													<div class="form-group required">
																																<label for="InputZip">CEP <sup>*</sup> </label>
																																<input type="text" class="form-control cep" name="cep" placeholder="CEP" value="<?php if(isset($_SESSION['endereco']['cep'])){ echo $_SESSION['endereco']['cep']; }else{ }?>">
																														</div>
                                                            <div class="form-group required">
                                                                <label for="InputState">Estado <sup>*</sup> </label>
                                                                <input class="form-control estado" disabled placeholder="DIGITE UM CEP" value="<?php if(isset($_SESSION['endereco']['estado'])){ echo $_SESSION['endereco']['estado']; }else{ }?>">
        																												<input type="hidden" class="form-control idEstado" name="idEstado" value="<?php if(isset($_SESSION['endereco']['idEstado'])){ echo $_SESSION['endereco']['idEstado']; }else{ }?>">
                                                            </div>
                                                             <div class="form-group required">
                                                                <label for="InputCountry">Cidade <sup>*</sup> </label>
                                                                <input class="form-control cidade" disabled placeholder="DIGITE UM CEP" value="<?php if(isset($_SESSION['endereco']['cidade'])){ echo $_SESSION['endereco']['cidade']; }else{ }?>">
																																<input type="hidden" class="form-control idCidade" name="idCidade" value="<?php if(isset($_SESSION['endereco']['idCidade'])){ echo $_SESSION['endereco']['idCidade']; }else{ }?>">
                                                            </div>

                                                           <div class="form-group required">
                                                                <label for="InputZip">Bairro <sup>*</sup> </label>
                                                                <input type="text" class="form-control bairro" name="bairro" placeholder="Bairro" value="<?php if(isset($_SESSION['endereco']['bairro'])){ echo $_SESSION['endereco']['bairro']; }else{ }?>" >
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="InputAddress">Logradouro <sup>*</sup> </label>
                                                                <input type="text" class="form-control logradouro" name="logradouro" placeholder="Logradouro" value="<?php if(isset($_SESSION['endereco']['logradouro'])){ echo $_SESSION['endereco']['logradouro']; }else{ }?>">
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="InputCity">Número <sup>*</sup> </label>
                                                                <input type="text" class="form-control numero" name="numero" placeholder="Número">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputAddress2">Complemento </label>
                                                                <input type="text" class="form-control" name="complemento" placeholder="Complemento">
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="addressAlias">Por favor coloque um título para este endereço. <sup>*</sup></label>
                                                                <input type="text" name="titulo" class="form-control" placeholder="Título deste endereço">
                                                            </div>
                                                        </div>

                                                </div>


                                            </div>
<div style="clear: both"></div>
<div class="pull-right"><button type="submit" class="btn btn-primary btn-lg "> Prosseguir &nbsp; <i class="fa fa-arrow-circle-right"></i> </button></div>
                                        </form>

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
		
						if(isset($_POST['cupom'])){

$sqlc  = 'SELECT * FROM Compras WHERE idUser = "'.$_SESSION['idUser'].'" AND idCupom = "'.$_POST['cupom'].'";';
$cps = mysqli_query($link,$sqlc);
$as = mysqli_fetch_assoc($cps);
$rds = mysqli_num_rows($cps);
if($rds <= 0  ){
		
		$sqlcupom = 'SELECT * FROM Cupons WHERE cupomName = "'.$_POST['cupom'].'"';
$cp = mysqli_query($link,$sqlcupom);
$asd = mysqli_fetch_assoc($cp);
$rd = mysqli_num_rows($cp);


if($carrinho->getSubTotal() >= $asd['valorMinimo'] AND date('yy-m-d') >= $asd['dataInicio'] AND date('yy-m-d') <= $asd['dataFinal']){
$valor = $asd['valor'];
}
}
						}
?>

                <div class="w100 cartMiniTable">
                    <table id="cart-summary" class="std table">
                        <tbody>
                        <tr>
                        
                            <td>Total dos produtos</td>
                            <td class="price"><?php echo formata_real($carrinho->getSubTotal()); ?></td>
                        </tr>
												<?php if($_SERVER['REQUEST_URI']!="/checkout3"){ ?>
													<tr>
															<td> Desconto</td>
															<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal()  * -$valor ); ?></td>
													</tr>
													<tr>
															<td> Total</td>
															<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal() - ($carrinho->getSubTotal() * $valor)); ?></td>
													</tr>
												<?php }else{ ?>
                        <tr>
                            <td>Frete</td>
                            <td class="price"><?php echo formata_real($carrinho->getFrete()); ?></td>
                        </tr>

                        <tr>
                            <td> Total </td>
                            <td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal() + $carrinho->getFrete()); ?></td>

                        </tr>
                       

												<?php } 
												$sqlc  = 'SELECT * FROM Compras WHERE idUser = "'.$_SESSION['idUser'].'" AND idCupom = "'.$_POST['cupom'].'";';
												$cp = mysqli_query($link,$sqlc);
												$as = mysqli_fetch_assoc($cp);
												$rd = mysqli_num_rows($cp);
												?>
												

                        <tr>
                            <td colspan="2">
							<?php 
											if(isset($_POST['cupom'])){

					if($_POST['cupom'] == ''){?>
          

						<?php }elseif($rd <= 0 AND $carrinho->getSubTotal() >= $asd['valorMinimo'] AND date('yy-m-d') >= $asd['dataInicio'] AND date('yy-m-d') <= $asd['dataFinal']){ ?>
							<form  method="POST"action="carrinho-cupom">
							<div class="input-append couponForm">
							<label > CUPOM APLICADO <i class="fa fa-tag"></i></label>
							<input class=" btn btn-dark col-lg-8"  id="appendedInputButton" type="text"  value="<?php echo $_POST['cupom']?> "placeholder="<?php echo $_POST['cupom']?>"  name="cupom" style="width:60%;" disabled>
								</form>
							</div>
						</td>
					</tr>
					
						<?php } }?>
						<tr>
                            <td colspan="2">
                            <form method="POST" action="checkout1">
                                <div class="input-append couponForm">
                              
 
                                    <input class="col-lg-8" id="cupom" type="text" oninput="handleInput(event)" placeholder="Cupom"  name="cupom"style="width:60%;">
                                   
                                    <button class="col-lg-4 btn btn-success" type="submit" style="width:38%; padding:8px 8px;">Aplicar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
						
						<?php 
				if(isset($_POST['cupom'])){
					if($carrinho->getSubTotal() < $asd['valorMinimo'] ){
						echo '<div class="alert alert-danger" role="alert">
						O Total minimo para usar esse cupom é '.formata_real($asd['valorMinimo']).'
					  
						</div>
					  ';
					
					}

					if($_POST['cupom'] != $asd['cupomName'] OR date('yy-m-d') < $asd['dataInicio'] OR date('yy-m-d') > $asd['dataFinal']){

						echo '<div class="alert alert-danger" role="alert">
						O Cupom e Invalido 
					  </div>';
					
					 } 
					 
if($rd > 0){?>



<div class="alert alert-danger">
<strong>Ops!</strong> Voce ja usou esse cupom em outra compra!.
</div>




<?php }}?>
                                            
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

<!-- Mask -->
<script src="<?php echo $site;?>assets/plugins/jquery-mask2/jquery.mask.min.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site;?>assets/js/script.js"></script>



<script>


    $(document).ready(function () {

	$('#form_novo_endereco').on('submit', function(e){

		if(	($('#newAddress').attr('checked') == 'checked') && ($('#tipo_pessoaPF').attr('checked') == 'checked')	){



			var Soma;
			var Resto;
			var strCPF = $('.cpf').val();
			var novoEndereco = $('.novoEndereco').val();

			strCPF = strCPF.replace("-",""); 
			strCPF = strCPF.replace(".","");
			strCPF = strCPF.replace(".","");

			Soma = 0;
			if (strCPF == "00000000000"){
				$(".cpf").focus();
				alert('CPF inválido');
//				alert('CPF inválido1 - '+strCPF); 
				return false;
			}

			for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
			Resto = (Soma * 10) % 11;

			if ((Resto == 10) || (Resto == 11)){
				Resto = 0;
			}

			if (Resto != parseInt(strCPF.substring(9, 10)) ){
				$(".cpf").focus();
				alert('CPF inválido');
//				alert('CPF inválido2 - '+strCPF);
				return false;
			}

			Soma = 0;
			for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
			Resto = (Soma * 10) % 11;

			if ((Resto == 10) || (Resto == 11)){
				Resto = 0;
			}

			if (Resto != parseInt(strCPF.substring(10, 11) ) ) {
				$(".cpf").focus();
				alert('CPF inválido');
//				alert('CPF inválido3 - '+strCPF);
				return false;
			}


//			alert('CPF OK!');

			return true;
		}//if


		if(	($('#newAddress').attr('checked') == 'checked') && ($('#tipo_pessoaPJ').attr('checked') == 'checked')	){

			var cnpj = $('.cnpj').val();
			cnpj = cnpj.replace(/[^\d]+/g,'');

			if(cnpj == ''){
				$(".cnpj").focus();
				alert('CNPJ inválido');
				return false;
			}

			if (cnpj.length != 14){
				$(".cnpj").focus();
				alert('CNPJ inválido');
				return false;
			}

			// Elimina CNPJs invalidos conhecidos
			if (cnpj == "00000000000000" || cnpj == "11111111111111" || cnpj == "22222222222222" || cnpj == "33333333333333" || cnpj == "44444444444444" || cnpj == "55555555555555" || cnpj == "66666666666666" || cnpj == "77777777777777" || cnpj == "88888888888888" || cnpj == "99999999999999"){
				$(".cnpj").focus();
				alert('CNPJ inválido');
				return false;
			}

			// Valida DVs
			tamanho = cnpj.length - 2
			numeros = cnpj.substring(0,tamanho);
			digitos = cnpj.substring(tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--) {
				soma += numeros.charAt(tamanho - i) * pos--;
	
				if (pos < 2){
					pos = 9;
				}
			}

			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

			if (resultado != digitos.charAt(0)){
				$(".cnpj").focus();
				alert('CNPJ inválido');
				return false;
			}

			tamanho = tamanho + 1;
			numeros = cnpj.substring(0,tamanho);
			soma = 0;
			pos = tamanho - 7;
			
			for (i = tamanho; i >= 1; i--) {
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2){
					pos = 9;
				}
			}

			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			
			if (resultado != digitos.charAt(1)){
				$(".cnpj").focus();
				alert('CNPJ inválido');
				return false;
			}
			return true;
		}//if
	});





			// MASK
			$('.cpf').mask('000.000.000-00', {reverse: true});
			$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
			$('.cep').mask('00000-000', {reverse: true});
			var SPMaskBehavior = function (val) {
		    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		  },
		  spOptions = {
		    onKeyPress: function(val, e, field, options) {
		        field.mask(SPMaskBehavior.apply({}, arguments), options);
		      }
		  };
		  $('.tel').mask(SPMaskBehavior, spOptions);

			// TOGGLES
      $('input#newAddress').on('ifChanged', function (event) {
          //alert(event.type + ' callback');
          $('#newBillingAddressBox').collapse("show");
          $('#exisitingAddressBox').collapse("hide");


$('#newAddress').attr('checked', 'checked');
$('#exisitingAddress').attr('checked', false);

      });

      $('input#exisitingAddress').on('ifChanged', function (event) {
          //alert(event.type + ' callback');
          $('#newBillingAddressBox').collapse("hide");
	  $('#exisitingAddressBox').collapse("show");


$('#exisitingAddress').attr('checked', 'checked');
$('#newAddress').attr('checked', false);
      });


      $('input#creditCard').on('ifChanged', function (event) {
          //alert(event.type + ' callback');
          $('#creditCardCollapse').collapse("toggle");

      });


      $('input#CashOnDelivery').on('ifChanged', function (event) {
          //alert(event.type + ' callback');
          $('#CashOnDeliveryCollapse').collapse("toggle");

      });

			$('.tipo_pessoa').on('ifChanged', function (event) {
					if ($("input[name='tipo_pessoa']:checked").val() == 'PF') {
              // console.log("PF");
							$(".PF").fadeIn('slow').removeClass("hide");
							$(".PJ").fadeOut('slow').addClass("hide");


							$('#tipo_pessoaPF').attr('checked', 'checked');
							$('#tipo_pessoaPJ').attr('checked', false);

					}

          if ($("input[name='tipo_pessoa']:checked").val() == 'PJ') {
              // console.log("PJ");
							$(".PJ").fadeIn('slow').removeClass("hide");
							$(".PF").fadeOut('slow').addClass("hide");

							$('#tipo_pessoaPF').attr('checked', false);
							$('#tipo_pessoaPJ').attr('checked', 'checked');


          }

      });
			// CEP/ ADDRESS
			$(".cep").keyup(function(){
				var cep = $(this).val();

				if ($(this).val() != "" && $(this).val().length==9) {
					//Nova variável "cep" somente com dígitos.
					cep = cep.replace('-','');

					//Expressão regular para validar o CEP.
					var validacep = /^[0-9]{8}$/;

					if(validacep.test(cep)) {
						//Preenche os campos com "..." enquanto consulta webservice.
		 				$(".logradouro").val("...");
		 				$(".bairro").val("...");
		 				$(".cidade").val("...");
		 				$(".estado").val("...");
		 				// $(".ibge").val("...");

						//Consulta o webservice viacep.com.br/
	  				$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
				  	if (!("erro" in dados)) {

							//Atualiza os campos com os valores da consulta.
							$(".logradouro").val(dados.logradouro);
							$(".bairro").val(dados.bairro);
			 				$(".cidade").val(dados.localidade);

							$.ajax({
					        type: "GET",
					        url: "ajax_getEnderecoF.php",
					        timeout: 3000,
					        contentType: "application/json; charset=utf-8",
					        cache: false,
									data: {id:dados.ibge},
					        error: function() {
					          alert("Cidade não encontrada.");
					        },
					        success: function(retorno) {
										$(".idCidade").val(retorno.idCidade);
										$(".estado").val(retorno.estado);
										$(".idEstado").val(retorno.idEstado);
					        }
					    });

							$(".numero").focus();

						}else{
								//CEP pesquisado não foi encontrado.
								alert("CEP não encontrado.");
						}
	  				});
					}else{
	  				//cep é inválido.
	  				alert("Formato de CEP inválido. - "+cep+ " - ");
		  		} // finaliza valida
				}
			}); // final



    });


</script>

</body>
</html>
