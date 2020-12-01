<?php
	require_once('inc/def.php');
  libera_acessoSite(1,2,3,4,5);
	require_once('header.php');
?>

    <!-- styles needed by footable  -->
    <link href="<?php echo $site; ?>assets/css/footable-0.1.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $site; ?>assets/css/footable.sortable-0.1.css" rel="stylesheet" type="text/css"/>


    <!-- Just for debugging purposes. -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- include pace script for automatic web page progress bar  -->


<?php
	require_once('menu.php');
	require_once($siteHD.'inc/api_frete_rapido.php');
	$freteRapido = new FreteRapido();

?>

<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
	    <li><a href="<?php echo $site;?>">Home</a></li>
<?php /*                <li><a href="account.html">My Account</a></li> */ ?>
                <li class="active"> Minhas compras</li>
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Minhas Compras </span></h1>

            <div class="row userInfo">
                <div class="col-lg-12">

                </div>

                <div style="clear:both"></div>

                <div class="col-xs-12 col-sm-12">
                    <table class="footable">
                        <thead>
                        <tr>
                            <th data-class="expand" data-sort-initial="true"><span>Número do pedido</span></th>
			    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                            <th data-hide="default"> Valor</th>
                            <th data-hide="default" data-type="numeric"> Data</th>
                            <th data-hide="phone" data-type="numeric"> Status</th>
                        </tr>
                        </thead>
			<tbody>

<?php
	$sql = 'SELECT c.id , (SUM(cp.valor * cp.qtde) + tc.preco_frete) valor , formata_data_hora(c.dataHora) dataHora , c.pago , c.enviado , c.entregue , c.codigoRastreio , c.statusEntrega , c.statusProducao
		FROM Compras c
		JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes
		JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
		WHERE c.idUser = '.$_SESSION['idUser'].'
		GROUP BY c.id;';
		

	$q = mysqli_query($link , $sql);

	while($r = mysqli_fetch_assoc($q)){

		$tracking = '';

		if($r['entregue'] == 1){
			$label = 'success';
			$msg = 'Entregue';
		}elseif($r['enviado'] == 1){
			$label = 'warning';
			$msg = 'A camimho';

			$trackingFrete = $freteRapido->getTracking($r['id']);
			$tracking = '<strong><i class="fa fa-truck"></i> Acompanhamento da entrega:</strong>';
			foreach($trackingFrete as $k=>$v){
		        	$tracking .= "<br>" . data_hora_formatoBR($v['data_ocorrencia']) . ' - ' . $v['nome'];
                	}

		}
	elseif($r['pago'] == 1){
		$label = 'success';
		$msg = 'Pagamento Aprovado!';
	}
		else{
			$label = 'danger';
			$msg = 'Aguardando Pagamento';
		}



		$sql2 = 'SELECT p.titulo , cor.cor , cp.qtde,p.img, cp.idCorTampa, cp.id,cor.hexadecimal
			FROM Compras_X_Produtos cp
			JOIN Produtos p ON p.id = cp.idProduto
			JOIN Cores cor ON cor.id = cp.idCorTampa
			WHERE cp.idCompra = '.$r['id'].';';


		$sql3 ='SELECT boletoUrl,processorName,creditCardScheme,creditCardLast4 FROM Compras_X_Invoices WHERE idCompra = '.$r['id'].';';
		$q3 = mysqli_query($link , $sql3);
		$q4 = mysqli_query($link , $sql3);
		$r4 = mysqli_fetch_assoc($q4);
		
		if($r4['processorName']== 'BOLETO ITAU'){
		while($r3 = mysqli_fetch_assoc($q3)){
			
			@$linhaProdutos .= '
			<a href='.$r3['boletoUrl'].' class="badge badge-success" style="font-weight: bold;" ><i class="fa fa-file-text"></i> VISUALIZAR BOLETO</a>
		
			
			';
		}
	}elseif($r4['processorName']== 'REDE'){
		while($r3 = mysqli_fetch_assoc($q3)){
		@$linhaProdutos .= '
			<a  style="font-weight: bold;" > <i class="fa fa-credit-card-alt"></i> Cartão de Crédito  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;   ' .$r3['creditCardScheme'].' &bull;&bull;&bull;&bull;'.$r3[creditCardLast4].' </a>
		
			
			';
		}
	}
		$q2 = mysqli_query($link , $sql2);
		while($r2 = mysqli_fetch_assoc($q2)){

			@$linhaProdutos .= 
		
			
			
			'
		         	<br> <img style= width="50px" height="50px"  src="'.$site.'/images/product/big/'.$r2['img'].'"/>
			    	<br><strong>Produto:</strong> '.$r2['titulo'].'
				<br><strong>Qtde:</strong> '.$r2['qtde'].'
				<br><strong>Cor da tampa:</strong> 
				<form action="alteraCor.php" method="POST">
				
			 	<select name="status">
				                    <option >'.$r2['cor'].' </option> 
				                    <option value="1" >Trasparente </option> 
									<option value="2" >Laranja</option>
									<option value="3" >Marrom</option>
									<option value="4" >Branca</option>
									<option value="5" >Azul</option>
									<option value="6" >Vermelha</option>
									<option value="7" >Verde</option>
									<option value="8" >Preta</option>

							
								<input type="hidden" name="id" value="'.$r2['id'].'">
								
                               
								<button type="submit"  class="btn btn-primary visible value="Submit" disabled="disabled">ALTERAR</button>

								</form>

				<br>
			';
		}//while $r2




		echo '
		<tr>
		    <td>'.$r['id'].'</td>
		    <td>'.@$linhaProdutos.'<br><br>'.$tracking.'</td>
		    <td>R$'.$r['valor'].'</td>
		    <td data-value="78025368997">'.$r['dataHora'].'</td>
		    <td data-value="3"><span class="label label-'.$label.'">'.$msg.'</span>
		    </td>
		</tr>';

		unset($linhaProdutos);
		unset($linhaProdutos2);

	}//while
?>

                        </tbody>
                    </table>
                </div>

                <div style="clear:both"></div>

                <div class="col-lg-12 clearfix">
                    <ul class="pager">
		    <li class="previous pull-right"><a href="<?php echo $site; ?>"> <i class="fa fa-home"></i> Ir pra loja </a></li>
<?php /*                        <li class="next pull-left"><a href="account.html"> &larr; Back to My Account</a></li> */ ?>
                    </ul>
                </div>
            </div>
            <!--/row end-->

        </div>
        <div class="col-lg-3 col-md-3 col-sm-5"></div>
    </div>
    <!--/row-->

    <div style="clear:both"></div>
</div>
<!-- /main-container -->

<div class="gap"></div>

<?php
	require_once('footer.php');
?>
<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery/jquery-2.1.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- include footable plugin -->
<script src="assets/js/footable.js" type="text/javascript"></script>
<script src="assets/js/footable.sortable.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('.footable').footable();
    });
</script>


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
