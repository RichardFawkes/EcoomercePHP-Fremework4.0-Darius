<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);



// foreach($_POST as $k=>$v){
// 	echo $k."<br>";

// }

// exit;



	require_once('inc/def.php');
	$cependereco = preg_replace("/[^0-9]/", "", $_POST['cep']);

	if(isset($_POST['novoEndereco']) && $_POST['novoEndereco'] == 0 ){

		$enderecoSelecionado = $_POST['enderecoSelecionado'];


	}else{
		if(	   @$_POST['idCidade'] == ''
			|| @$_POST['idEstado'] == ''
			|| @$_POST['nome'] == ''
			|| @$_POST['sobrenome'] == ''
			|| @$_POST['telefone'] == ''
			|| @$_POST['cep'] == ''
			|| @$_POST['bairro'] == ''
			|| @$_POST['logradouro'] == ''
			|| @$_POST['numero'] == ''
			|| @$_POST['titulo'] == ''

		){
			ir($site.'checkout1' , 'Por favor preencha os campos para calcular o valor do frete.');
			exit;
		}

		$sql = 'SELECT id FROM CidadesIBGE WHERE cidade = (SELECT cidade FROM CidadesIBGE WHERE id = '.$_POST['idCidade'].') AND idEstado = '.$_POST['idEstado'].';';
		$q = mysqli_query($link , $sql);
		$r = mysqli_fetch_assoc($q);
		$idCidade = $r['id'];

		$cpf = ($_POST['cpf']=="")? 'NULL' : '"'.addslashes($_POST['cpf']).'"';
		$cnpj = ($_POST['cnpj']=="")? 'NULL' : '"'.addslashes($_POST['cnpj']).'"';
		$inscricao_estadual = ($_POST['inscricao_estadual']=="")? 'NULL' : '"'.addslashes($_POST['inscricao_estadual']).'"';
		$empresa = ($_POST['empresa']=="")? 'NULL' : '"'.addslashes($_POST['empresa']).'"';

		$sql = 'INSERT INTO Users_X_Enderecos (
				idUser
				, nome
				, sobrenome
				, email
				, empresa
				, cnpj
				, inscricao_estadual
				, cpf
				, tipo_pessoa
				, telefone
				, informacoes_adicionais
				, idEstado
				, idCidade
				, cep
				, bairro
				, logradouro
				, numero
				, complemento
				, titulo
			) VALUES (
				"'.$_SESSION['idUser'].'"
				, "'.addslashes($_POST['nome']).'"
				, "'.addslashes($_POST['sobrenome']).'"
				, "'.addslashes($_POST['email']).'"
				, '.$empresa.'
				, '.$cnpj.'
				, '.$inscricao_estadual.'
				, '.$cpf.'
				, "'.addslashes($_POST['tipo_pessoa']).'"
				, "'.addslashes($_POST['telefone']).'"
				, "'.addslashes($_POST['informacoes_adicionais']).'"
				, "'.addslashes($_POST['idEstado']).'"
				, "'.$idCidade.'"
				, "'.addslashes($_POST['cep']).'"
				, "'.addslashes($_POST['bairro']).'"
				, "'.addslashes($_POST['logradouro']).'"
				, "'.addslashes($_POST['numero']).'"
				, "'.addslashes($_POST['complemento']).'"
				, "'.addslashes($_POST['titulo']).'"
			);';
	//echo nl2br($sql);
		$q = mysqli_query($link , $sql);// or die(mysqli_error($link));
		$enderecoSelecionado = mysqli_insert_id($link);

	}//else

	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');
	include($siteHD.'inc/api_frete_rapido.php');








?>
<style>
.span01{
	color:green;
}

</style>

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
                            <li><a href="<?php echo $site;?>checkout1"> <i class="fa fa-map-marker"></i> <span> Endereço</span></a></li>
                            <li class="active"><a href="<?php echo $site;?>checkout2"><i class="fa fa-truck "> </i><span>Frete</span> </a></li>
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



				<form method="post" action="<?php echo $site;?>checkout3">

					<input type="hidden" name="enderecoSelecionado" value="<?php echo $enderecoSelecionado; ?>" >
<?php if(isset($_POST['cupom'])){ ?>
					<input type="hidden" name="cupom" value="<?php echo $_POST['cupom'] ?>" >
<?php } ?>
					


                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="Deliverymethod">
                                                    Frete
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="Deliverymethod" class="" role="tabpanel" aria-labelledby="Deliverymethod">
                                            <div class="panel-body">
                                                <div class="w100 row">
                                                    <div class="form-group col-lg-12 col-sm-12 col-md-12 col-xs-12">

                                                        <table style="width:100%" class="table-bordered table tablelook2">
                                                            <tbody>
                                                            <tr>
                                                                <td style="font-weight:bold;"> Transportadora</td>
                                                                <td style="font-weight:bold;"> Prazo</td>
                                                                <td style="font-weight:bold;" >Valor</td>
                                                            </tr>
<?php
	$freteRapido = new FreteRapido();

	
	$fretes = $freteRapido->calculaFrete($enderecoSelecionado);








	
	$brass = $freteRapido->calculaFreteCEP2($cependereco);
	//echo $fretes['token_oferta'];
/*
	foreach($fretes['transportadoras'] as $k=>$v){
		echo '<tr>
			<td><label class="radio">
				<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
				<i class="fa fa-truck fa-2x"></i> '.$v['nome'].'</label>
			</td>
			<td>'.$v['prazo_entrega'].' dias</td>
			<td>R$'.$v['preco_frete'].'</td>
		</tr>';
	}
*/



	//////////////////////////////////////////////
	if(isset($_POST['cupom'])){
	$sqlcupom = 'SELECT * FROM Cupons WHERE cupomName = "'.$_POST['cupom'].'"';
	
	$cp = mysqli_query($link,$sqlcupom);
	$as = mysqli_fetch_assoc($cp);
	$rd = mysqli_num_rows($cp);
	$graca = 0.00;
	if($as['fretegratis'] == 1){

		while($r = mysqli_fetch_assoc($q)){
	
	
			if(!isset($transpSel)){
				$transpSel = 'checked';
			}else{
				$transpSel = '';
			}
	
			echo '<tr>
				<td><label class="radio">
					<input type="radio" name="idCotacaoTransportadora" id="optionsRadios1" value="10101"  >
					<i class="fa fa-truck fa-2x"></i> '.$r['transportadora'].'</label>
				</td>
				<td>até '.$r['prazo_entrega'].' dias úteis</td>
				<td>'.formata_real($graca).'</td>
			</tr>';
		
		}
	 }
else{

	while($r = mysqli_fetch_assoc($q)){


		if(!isset($transpSel)){
			$transpSel = 'checked';
		}else{
			$transpSel = '';
		}
		$graca = 0.00;
		echo '<tr>
		<td><label class="radio">
		<input  type="radio" name="idCotacaoTransportadora" id="optionsRadios1" value="'.$r['id'].'"  >
		<i class="fa fa-truck fa-2x"></i> BRASPRESS</label>
	</td>
	<td>até '.$brass->$obj->prazo.' dias úteis</td>
	<td>'.formata_real($brass->totalFrete).'</td>
</tr>';
	
	}
}
}else{
	
	$sqln = 'SELECT * FROM `Transportadoras_Cotacoes` WHERE idUser = '.$_SESSION['idUser'].' ORDER BY id DESC LIMIT 1 ';
	$qf = mysqli_query($link,$sqln);

	$f = mysqli_fetch_assoc($qf);
		$graca = 0.00;
		echo '<tr>
			<td><label class="radio">
				<input  type="radio" name="idCotacaoTransportadora" id="optionsRadios1" value="'.$f['id'].'"  >
				<i class="fa fa-truck fa-2x"></i> BRASPRESS</label>
			</td>
			<td>até '.$f['prazo_entrega'].' dias úteis</td>
			<td>'.formata_real($f['preco_frete']).'</td>
		</tr>';
	
	

}
if(!isset($transpSel)){
	$transpSel = 'checked';
}else{
	$transpSel = '';
}
//RETIRAR NA BRASILATA 
	// echo '<tr>
	// 	<td><label class="radio">
	// 		<input type="radio" name="idCotacaoTransportadora" id="optionsRadios1" value="2000" '.$transpSel.' >
	// 		<i class="fa fa-building fa-2x"></i> RETIRAR NA LOJA</label><span class="span01">
	// 		Rua Robert Bosch, 450 - Parque Industrial Tomas Edson - São Paulo - SP</span>
	// 	</td>
	// 	<td>5 dias úteis</td>
	// 	<td>'.formata_real($graca).'<br>GRATIS</td>

	// </tr>';

 
 




?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>


                                            </div>
<div style="clear: both"></div>
<div class="pull-right"><button type="submit" class="btn btn-primary btn-lg "> Prosseguir &nbsp; <i class="fa fa-arrow-circle-right"></i> </button></div>







                                        </div>
                                    </div>
				</form>


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
		$sqlcupom = 'SELECT * FROM Cupons WHERE cupomName = "'.$_POST['cupom'].'"';
        $cp = mysqli_query($link,$sqlcupom);
        $as = mysqli_fetch_assoc($cp); 
        $rd = mysqli_num_rows($cp);

$valor = $as['valor'];
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
															<?php 									if(isset($_POST['cupom'])){?>

															<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal()  * -$valor ); ?></td>
															<?php }else{	?>
																<td class=" site-color" id="total-price"><?php echo formata_real(0.00); ?></td>
																<?php }	?>


															</tr>
													<tr>
															<td> Total</td>
															<?php 									if(isset($_POST['cupom'])){
?>
															<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal() - ($carrinho->getSubTotal() * $valor)); ?></td>
															<?php }else{	?>
																<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal());?></td>
															<?php }	?>


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
                       

												<?php } ?>

							<?php 
									if(isset($_POST['cupom'])){

								$sqlc  = 'SELECT * FROM Compras WHERE idUser = "'.$_SESSION['idUser'].'" AND idCupom = "'.$_POST['cupom'].'";';
								 
								$cp = mysqli_query($link,$sqlc);
								$as = mysqli_fetch_assoc($cp);
								$rds = mysqli_num_rows($cp);
							
							if($_POST['cupom'] == '' OR $_POST['cupom'] == '1'){?>
          

							<?php }elseif( $rds <= 0 AND  $_POST['cupom'] != '1'){ ?>
								<form  method="POST"action="carrinho-cupom">
                                <div class="input-append couponForm">
								<label > CUPOM APLICADO <i class="fa fa-tag"></i></label>
								<input class=" btn btn-dark col-lg-8"  id="appendedInputButton" type="text"  value="<?php echo $_POST['cupom']?> "placeholder="<?php echo $_POST['cupom']?>"  name="cupom" style="width:60%;" disabled>
                                    </form>
                                </div>
                            </td>
                        </tr>
							<?php }?>
							
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

</body>
</html>
