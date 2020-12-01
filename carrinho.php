<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');
	require_once($siteHD.'inc/carrinho.php');

	$carrinho = new Carrinho;
?>

<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li class="active">Carrinho</li>
            </ul>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6 col-xxs-12 text-center-xs">
            <h1 class="section-title-inner"><span><i
                    class="glyphicon glyphicon-shopping-cart"></i> Carrinho </span>

									</h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar col-xs-6 col-xxs-12 text-center-xs">
            <h4 class="caps"><a href="javascript:; history.back();"><i class="fa fa-chevron-left"></i> Voltar </a></h4>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-12">
		<form method="post" action="<?php echo $site; ?>atualiza_carrinho">
                    <div class="cartContent w100">
                        <table class="cartTable table-responsive" style="width:100%">
                            <tbody>

                            <tr class="CartProduct cartTableHeader">
                                <td style="width:15%"> Produto</td>
                                <td style="width:40%">Descrição</td>
                                <td style="width:10%" class="delete">&nbsp;</td>
                                <td style="width:15%">QTD</td>
								<td style="width:15%">PU</td>

<?php //                                <td style="width:10%">Desconto</td> ?>
                                <td style="width:20%">Total</td>
                            </tr>

		<?php
			foreach($carrinho->getProdutos() as $k=>$v){
				if($v['estoque']==1){
					$max = $v['quantidade'];
				}else{
					$max = '10000';
				}


				if($v['rangeqtde'] == 0 ){
			$disable = 'disabled';
				}
				
				$total = $v['preco']*$v['qtde'];
				echo '
				    <tr class="CartProduct">
					<td class="CartProductThumb">';
					if($v['idProjeto']== ''){
						echo'
					   
					<div><a href="'.$site.'produto/'.$v['url'].'"> <img src="'.$site.'images/product/mini/'.$v['img'].'" alt="img">';
					}else{ echo ' 
					<div><a href="'.$site.'produto/'.$v['url'].'"> <img src="'.$editorlink.'productthumb.ashx?p='.$v['idProjeto'].'" alt="img">';
				}
				echo'
					    </div>
					</td>
					<td>
					    <div class="CartDescription">
						<h4 style="padding-bottom:5px;"><a href="'.$site.'produto/'.$v['url'].'">'.$v['titulo'].' </a></h4>


						<span class="size">'.$v['cor'].'<br> '.$v['descricao'].'</span><br>
						<span>Prazo Produção: '.$v['prazo'].' dias + frete</span>

					    </div>
					</td>
					<td class="delete"><a title="Delete" href="'.$site.'remove_produto_do_carrinho?idCarrinho='.$v['idCarrinho'].'"> <i class="glyphicon glyphicon-trash fa-2x"></i></a></td>

';
	echo '					<td><input '.$disable.' class="quanitySniper" type="number" min="1" max="'.$max.'" value="'.$v['qtde'].'" name="quanitySniper'.$v['idCarrinho'].'" ></td>';




echo'



<td class="price">'.formata_real($v['preco']).'</td>

					<td class="price">'.formata_real($v['preco']*$v['qtde']).'</td>
				    </tr>';

			}//foreach
// 					<td><input class="quanitySniper" type="text" value="'.$v['qtde'].'" name="qtde_'.$v['idCarrinho'].'"></td>
		if(empty($carrinho->getProdutos())){
			$disabled = 'disabled';
		}else{
			$disabled = '';
		}
		?>


                            </tbody>
                        </table>
                    </div>
                    <!--cartContent-->

                    <div class="cartFooter w100">
                        <div class="box-footer">
                            <div class="pull-left"><a href="<?php echo $site; ?>" class="btn btn-default"> <i
                                    class="fa fa-arrow-left"></i> &nbsp; Continuar comprando </a></div>
                            <div class="pull-right">
                                <button class="btn btn-default" type="submit"><i class="fa fa-undo"></i> &nbsp; Atualizar carrinho</button>
                            </div>

													</form>


                        </div>
                    </div>
                    <!--/ cartFooter -->
										<!--FRETE-->
										<div class="row">
											<h3 class="col-md-12"><span>Simule o Frete</span> </h3>
										</div>
										<div class="row">
											<div class="form-group col-md-3">
												<input type="text" name="cep" id="cep" class="form-control" data-mask="00000-000" maxlength="9" placeholder="Digite seu CEP"
												value="<?php if(isset($_SESSION['endereco']['cep'])){ echo $_SESSION['endereco']['cep']; }?>" <?php echo $disabled;?>/>
											</div>
											<div class="form-group col-md-2">
												<button   onclick="this.disabled = true;" class="btn btn-primary <?php echo $disabled;?>"  id="calculaFrete"><i class="fa fa-truck"></i> &nbsp; CALCULAR FRETE</button>


												
												
											</div>
											<div class="form-group col-md-12" id="resultado"></div>
										</div>
										<!--/ FRETE -->



                </div>
            </div>
            <!--/row end-->

        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
            <div class="contentBox">

                <div class="w100 costDetails">
                    <div class="table-block" id="order-detail-content">
											<a class="btn btn-primary btn-lg btn-block "
                      title="checkout" style="margin-bottom:20px"
											<?php
												if(!isset($_SESSION['tempUser'])){
											?>
											href="<?php echo $site;?>checkout1">
											<?php
											}else{
											?>
											data-toggle="modal" data-target="#ModalLogin">
											<?php
											}
											?>
											Prosseguir &nbsp; <i class="fa fa-arrow-right"></i> </a>
			<?php require_once($siteHD.'checkout_conta.php');?>
                    </div>
                </div>
            </div>
            <!-- End popular -->
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

<!-- include mask plugin  -->
<script src="<?php echo $site; ?>assets/plugins/jquery-mask/jquery.mask.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>
<script>
$( "#calculaFrete" ).click(function(e) {
	e.preventDefault;
	var cep = $("#cep").val();
	$.ajax({
	  url : "<?php echo $site?>inc/calculaFrete.php",
	  type : 'post',
	  data : {
	    cep : cep
	  },
	  beforeSend : function(){
	    $("#resultado").html("<label style='color:#4ec66b; font-weight:bold;'> Calculando... </label><img src='http://lojadalata.com/loading.gif'  width=20/>");
	  }
	})
	.done(function(msg){
	  $("#resultado").html(msg);
	})
	.fail(function(jqXHR, textStatus, msg){
	  alert(msg);
	});
});


</script>
</body>
</html>
