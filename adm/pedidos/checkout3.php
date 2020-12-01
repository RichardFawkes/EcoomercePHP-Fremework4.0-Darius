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

// Aqui garantimos que o usuário acabou de selecionar uma transportadora. Fazemos isso, pois a validade da cotação expira.
if(	isset($_POST['idCotacaoTransportadora']) && !is_null($_POST['idCotacaoTransportadora']) && $_SERVER['HTTP_REFERER'] == $site.'checkout2'){
	$sql = 'UPDATE Transportadoras_Cotacoes SET selecionado = 0 WHERE idUser = "'.$_SESSION['idUser'].'" AND ativo = 1;';
	mysqli_query($link , $sql);


	$sql = 'UPDATE Transportadoras_Cotacoes SET selecionado = 1 WHERE idUser = "'.$_SESSION['idUser'].'" AND ativo = 1 AND id = "'.$_POST['idCotacaoTransportadora'].'";';
	mysqli_query($link , $sql);

}else{

	echo '<script type="text/javascript">alert(\'Antes de efetuar o pagamento, por favor selecione uma transportadora.\');</script>';
	ir($site.'checkout2');
	exit;

}







$sql = 'INSERT INTO Compras (
	idUser
	,idUsers_X_Enderecos
	,idTransportadoras_Cotacoes
	,idCupom
	,dataHora
) VALUES (

	'.$_SESSION['idUser'].'
	, "'.$_POST['enderecoSelecionado'].'"
	, "'.$_POST['idCotacaoTransportadora'].'"
	, "0"
	, NOW()
);';
//echo nl2br($sql);
$q = mysqli_query($link , $sql) or die(mysqli_error($link));
$idCompra = mysqli_insert_id($link);

$sql = 'INSERT INTO Compras_X_Produtos (idCompra , idProduto , idCorTampa , qtde, idProjeto, valor )
SELECT '.$idCompra.' idCompra , c.idProduto , c.idCorTampa , c.qtde , c.idProjeto,
 (SELECT valorUnitario FROM PrecosQuantidades WHERE idProduto = c.idProduto AND qtde >= c.qtde ORDER BY valorUnitario DESC LIMIT 1) valorUnitario
FROM Carrinho c
JOIN Produtos p ON p.id = c.idProduto
WHERE idUser = '.$_SESSION['idUser'].'
ORDER BY valorUnitario DESC


;';


mysqli_query($link , $sql);


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
								<li><a href="<?php echo $site;?>checkout2"><i class="fa fa-truck "> </i><span>Frete</span> </a></li>
								<li class="active"><a href="<?php echo $site;?>checkout3"><i class="fa fa-money  "> </i><span>Pagamento</span> </a></li>
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

																		if($total_carrinho>$vl_min_parc){
																			for ($i=1; $i <= $qt_max_parc; $i++) {
																				if(($total_carrinho/$i)>$vl_min_parc){
																					$parcelas[] = $i;
																				}
																			}
																		}else{
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
				<?php require_once($siteHD.'checkout_conta.php');?>
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

	// EMAIL
            require_once('inc/PHPMailer/PHPMailerAutoload.php');

            date_default_timezone_set('Etc/UTC');
            //Create a new PHPMailer instance
            $mail = new PHPMailer;

            //Tell PHPMailer to use SMTP
            $mail->isSMTP();

            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;

            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';

            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';
            // use
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // if your network does not support SMTP over IPv6

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;

            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "recupera.senhaldl@gmail.com";

            //Password to use for SMTP authentication
            $mail->Password = "ldl.esqueci.minha.senha2019";

            //Set who the message is to be sent from
            $mail->setFrom('recupera.senhaldl@gmail.com', 'Loja da Lata');

            //Set an alternative reply-to address
            

            // PEGA O EMAIL E O NOME DO CLIENTE
            $sqlInfo = 'SELECT u.nome, u.email
            FROM Compras c
            JOIN Users u ON u.id = c.idUser
            WHERE c.id='.$idCompra;
            $resInfo = mysqli_query($link,$sqlInfo);
            $rowInfo = mysqli_fetch_array($resInfo);
            //Set who the message is to be sent to
            $mail->addReplyTo($rowInfo['email'], $rowInfo['nome']);
			$mail->addAddress($rowInfo['email'], $rowInfo['nome']);
			

			$sqlbcc = 'SELECT valor FROM Configuracao WHERE id=10';
			
			
			$resbcc = mysqli_query($link,$sqlbcc);
			$rowbcc = mysqli_fetch_array($resbcc);
			$bccExplode = explode(",",$rowbcc['valor']);
			foreach($bccExplode as $key => $bcc){
				$mail->AddBCC($bcc);
			}


            //Set the subject line
            $mail->Subject = utf8_decode('Recebemos seu pedido #'.$idCompra.'');

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            ?>
            <div class="col-lg-7 col-center">
              <h4></h4>

              <div class="cartContent table-responsive  w100">
                <table style="width:100%" class="cartTable cartTableBorder">
                  <tbody>

                   

                    <?php
                    $sql = 'SELECT cp.idProduto ,p.url, p.titulo , p.img , cp.qtde , cor.cor, cp.valor, (cp.qtde*cp.valor) tot, p.estoque, p.quantidade, p.prazo_producao
                    FROM Compras_X_Produtos cp
                    JOIN Produtos p ON p.id = cp.idProduto
                    JOIN Cores cor ON cor.id = cp.idCorTampa
                    WHERE idCompra = '.$idCompra.';';
                    $q = mysqli_query($link , $sql);
                    $produtoEmail = '';
                    $totalValor = 0;
                    while($r = mysqli_fetch_assoc($q)){
                      $plural = $r['qtde'] > 1 ? 's' : '';
                      if($r['estoque']==1){
                        $quantidadeRestante = $r['quantidade']-$r['qtde'];
                        $upd = 'UPDATE Produtos SET quantidade='.$quantidadeRestante.' WHERE id='.$r['idProduto'];
                        mysqli_query($link, $upd);
                      }


                    

					  $produtoEmail .= '<tr style="border-collapse:collapse;">
					  
                      <td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$r['titulo'].' ('.$r['cor'].')</p></td>
                      <td style="padding:5px 0;Margin:0;" width="20%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">R$ '.$r['tot'].'</p></td>
					  </tr> 
					  <tr class="CartProduct">
                      <td class="CartProductThumb">
                      <div><a href="'.$site.'produto/'.$r['url'].'"><img alt="img" src="'.$site.'images/product/mini/'.$r['img'].'"></a></div>
                      </td>
                      <td>
                      <div class="CartDescription">
                      <h4><a href="'.$site.'produto/'.$r['idProduto'].'">'.$r['titulo'].'</a></h4>
					  <span class="size">Cor da tampa: '.$r['cor'].'</span>
					  <span class="size">Prazo Producao : '.$r['prazo_producao'].'</span>

					  </div>
					  
                      </td>
                      <td class="price">'.$r['qtde'].' unidade'.$plural.' </td>
                      </tr>';
                      $totalValor = $totalValor+$r['tot'];
                    }

                    $sqlFrete = 'SELECT tc.preco_frete, CONCAT(uxe.logradouro,", ",uxe.numero," - ",uxe.complemento ) endereco, uxe.cep, CONCAT(city.cidade,"/",e.sigla) endereco2
                    FROM Compras c
                    JOIN Transportadoras_Cotacoes tc ON tc.id = idTransportadoras_Cotacoes
                    JOIN Users_X_Enderecos uxe ON uxe.id = c.idUsers_X_Enderecos
                    JOIN CidadesIBGE city ON city.id = uxe.idCidade
                    JOIN Estados e ON e.id = uxe.idEstado
                    WHERE c.id='.$idCompra.';';
                    $qFrete = mysqli_query($link , $sqlFrete);
                    $rFrete = mysqli_fetch_assoc($qFrete);
         
                    $totalValor = $totalValor+$rFrete['preco_frete'];
                    $totalValor = number_format($totalValor,2, ',', '.');
                    ?>


                  </tbody>
                </table>
              </div>

            </div>
            <?php
            $mail->msgHTML(utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html style="width:100%;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
             <head>
              <meta charset="UTF-8">
              <meta content="width=device-width, initial-scale=1" name="viewport">
              <meta name="x-apple-disable-message-reformatting">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta content="telephone=no" name="format-detection">
              <title>Confirmação do Pedido</title>
              <!--[if (mso 16)]>
                <style type="text/css">
                a {text-decoration: none;}
                </style>
                <![endif]-->
              <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
              <!--[if !mso]><!-- -->
              <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
              <!--<![endif]-->
              <style type="text/css">
            @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:32px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button { font-size:16px!important; display:inline-block!important; border-width:15px 30px 15px 30px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
            #outlook a {
            	padding:0;
            }
            .ExternalClass {
            	width:100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
            	line-height:100%;
            }
            .es-button {
            	mso-style-priority:100!important;
            	text-decoration:none!important;
            }
            a[x-apple-data-detectors] {
            	color:inherit!important;
            	text-decoration:none!important;
            	font-size:inherit!important;
            	font-family:inherit!important;
            	font-weight:inherit!important;
            	line-height:inherit!important;
            }
            .es-desk-hidden {
            	display:none;
            	float:left;
            	overflow:hidden;
            	width:0;
            	max-height:0;
            	line-height:0;
            	mso-hide:all;
            }
            </style>
             </head>
             <body style="width:100%;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
              <div class="es-wrapper-color" style="background-color:#EEEEEE;">
               <!--[if gte mso 9]>
            			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
            				<v:fill type="tile" color="#eeeeee"></v:fill>
            			</v:background>
            		<![endif]-->
               <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
                 <tr style="border-collapse:collapse;">
                  <td valign="top" style="padding:0;Margin:0;">
                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                     <tr style="border-collapse:collapse;"></tr>
                   </table>
                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                     <tr style="border-collapse:collapse;"></tr>
                     <tr style="border-collapse:collapse;">
                      <td align="center" style="padding:0;Margin:0;">
                       <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#4bb777;" width="600" cellspacing="0" cellpadding="0" bgcolor="#4bb777" align="center">
                         <tr style="border-collapse:collapse; height:100px;">
                          <td class="es-m-txt-c" align="center" style="padding:0;Margin:0;"><img src="https://www.lojadalata.com/images/logo.png" title="Loja da lata"></td>
                         </tr>
                         </tr>
                       </table></td>
                     </tr>
                   </table>
                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                     <tr style="border-collapse:collapse;">
                      <td align="center" style="padding:0;Margin:0;">
                       <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;">
                         <tr style="border-collapse:collapse;">
                          <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;">
                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                             <tr style="border-collapse:collapse;">
                              <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                 <tr style="border-collapse:collapse;">
                                  <td align="center" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-left:35px;padding-right:35px;"><a target="_blank" href="#" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:16px;text-decoration:none;color:#ED8E20;"><img src="https://www.lojadalata.com/images/67611522142640957.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="120"></a></td>
                                 </tr>
                                 <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;padding-bottom:10px;"><h2 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:30px;font-style:normal;font-weight:bold;color:#333333;">Obrigado pelo seu pedido.</h2></td>
                                 </tr>
                                 <tr style="border-collapse:collapse;">
								  <td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#777777;">Seu pedido logo será enviado após confirmação do pagamento!&nbsp;</p>
								  <align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#cc0000;">Aguardando Pagamento... &nbsp;</p></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table>
                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                     <tr style="border-collapse:collapse;">
                      <td align="center" style="padding:0;Margin:0;">
                       <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;">
                         <tr style="border-collapse:collapse;">
                          <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:35px;padding-right:35px;">
                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                             <tr style="border-collapse:collapse;">
                              <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                 <tr style="border-collapse:collapse;">
                                  <td bgcolor="#eeeeee" align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;">
                                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                     <tr style="border-collapse:collapse;">
                                      <td width="80%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">Pedido</h4></td>
                                      <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">#'.$idCompra.'</h4></td>
                                     </tr>
                                   </table></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                         <tr style="border-collapse:collapse;">
                          <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;">
                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                             <tr style="border-collapse:collapse;">
                              <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                 <tr style="border-collapse:collapse;">
                                  <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;">
                                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                     '.$produtoEmail.'
                                   </table></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                         <tr style="border-collapse:collapse;">
                          <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px;">
                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                             <tr style="border-collapse:collapse;">
                              <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                               <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE;" width="100%" cellspacing="0" cellpadding="0">
                                 <tr style="border-collapse:collapse;">
                                  <td align="left" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;">
                                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                     <tr style="border-collapse:collapse;">
                                      <td width="80%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">TOTAL</h4></td>
                                      <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">R$ '.$totalValor.'</h4></td>
									 </tr>
									 <tr style="border-collapse:collapse;">
									 <td width="80%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">FRETE</h4></td>
									 <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">R$ '.$rFrete['preco_frete'].'</h4></td>
									</tr>
                                   </table></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                         <tr style="border-collapse:collapse;">
                          <td align="left" style="Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;padding-bottom:40px;">
                           <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="255" valign="top"><![endif]-->
                           <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                             <tr style="border-collapse:collapse;">
                              <td class="es-m-p20b" width="255" align="left" style="padding:0;Margin:0;">
                               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                 <tr style="border-collapse:collapse;">
                                  <td align="left" style="padding:0;Margin:0;padding-bottom:15px;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">Endereço de Entrega</h4></td>
                                 </tr>
                                 <tr style="border-collapse:collapse;">
                                  <td align="left" style="padding:0;Margin:0;padding-bottom:10px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$rFrete['endereco'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$rFrete['endereco2'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$rFrete['cep'].'</p></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table>
                           <!--[if mso]></td><td width="20"></td><td width="255" valign="top"><![endif]-->

                           <!--[if mso]></td></tr></table><![endif]--></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table>


                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                     <tr style="border-collapse:collapse;">
                      <td align="center" style="padding:0;Margin:0;">
                       <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" align="center">
                         <tr style="border-collapse:collapse;">
                          <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;">
                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                             <tr style="border-collapse:collapse;">

                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
              </div>
             </body>
            </html>
            '));


            // Replace the plain text body with one created manually
            $mail->AltBody = 'Pedido Efetuado com sucesso '.$idCompra;

            //send the message, check for errors
            if (!$mail->send()) {
            //    echo "Mailer Error: " . $mail->ErrorInfo;
              // voltar('Erro ao enviar Email.');
            } else {
              // ir($site.'contato','Email enviado com sucesso.');
            }
          
          
          ?>


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
