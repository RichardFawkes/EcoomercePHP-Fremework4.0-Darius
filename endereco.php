<?php
	require_once('inc/def.php');
  libera_acessoSite(1,2,3,4,5);
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');

  if(!isset($_GET['id'])){
    $textoTitle = "Novo Endereço";
  }else{
    $textoTitle = "Editar Endereço";
    $sql = 'SELECT *, uxe.id idEndereco
    FROM Users_X_Enderecos uxe
    JOIN CidadesIBGE c ON c.id = uxe.idCidade
    JOIN Estados e ON e.id = uxe.idEstado
    WHERE uxe.idUser='.$_SESSION['idUser'].'
    AND uxe.id='.$_GET['id'].';';
    $q = mysqli_query($link , $sql);
    $row = mysqli_fetch_assoc($q);
    $cont = mysqli_num_rows($q);
    if($cont==0){
      voltar('Erro ao buscar o Endereço');
    }

  }
?>

<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li><a href="<?php echo $site; ?>meus-enderecos">Meus Enderecos</a></li>
                <li class="active"> <?php if(isset($_GET['id'])){ echo "Novo Endereço";}else{ echo "Editar Endereço";}?></li>
            </ul>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i
                    class="glyphicon glyphicon-pushpin"></i> Meus Endereços</span></h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
            <h4 class="caps"><a href="<?php echo $site; ?>meus-enderecos"><i class="fa fa-chevron-left"></i> Voltar para os Meus Endereços </a></h4>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12 col-md-12col-sm-12">
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-12">




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
                                        <div id="BillingInformation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="BillingInformation">
                                            <div class="panel-body">
                                                <form method="POST" action="save_address">
                                                <div id="newBillingAddressBox" class="collapse in">
                                                    <div class="form-group uppercase"><strong><?php echo $textoTitle; ?></strong></div>

                                                        <div class="col-xs-12 col-sm-6">

                                                            <div class="form-group required">
                                                                <label for="InputName">Nome <sup>*</sup> </label>
                                                                <input type="text" class="form-control" placeholder="Nome" name="nome" value="<?php if(isset($row['nome'])){ echo $row['nome']; }?>">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputLastName">Sobrenome <sup>*</sup> </label>
                                                                <input type="text" class="form-control" placeholder="Sobrenome" name="sobrenome" value="<?php if(isset($row['sobrenome'])){ echo $row['sobrenome']; }?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputEmail">Email </label>
                                                                <input type="text" class="form-control" name="email" placeholder="Email" value="<?php if(isset($row['email'])){ echo $row['email']; }?>">
                                                            </div>
																														<div class="form-inline">
																															<label>Tipo Pessoa </label>
																																<label class="radio inline">
																																		<input id="tipo_pessoaPF" class="tipo_pessoa" type="radio" value="PF" name="tipo_pessoa" <?php if(isset($row['tipo_pessoa']) && $row['tipo_pessoa']=='PF'){ echo "checked"; }else{ echo 'checked';}?>> Física
																																</label>&nbsp;&nbsp;&nbsp;&nbsp;

																																<label class="radio inline">
																																		<input id="tipo_pessoaPJ" class="tipo_pessoa" type="radio" value="PJ" name="tipo_pessoa" <?php if(isset($row['tipo_pessoa']) && $row['tipo_pessoa']=='PJ'){ echo "checked"; }?>> Jurídica
																																</label>
																														</div>

																														<div class="form-group required PF <?php if(isset($row['tipo_pessoa']) && $row['tipo_pessoa']=='PJ'){ echo "hide"; }else{ echo "";}?>">
																																<label for="InputMobile">CPF <sup>*</sup></label>
																																<input required type="text" name="cpf" class="form-control cpf" placeholder="CPF" value="<?php if(isset($row['cpf'])){ echo $row['cpf']; }?>">
																														</div>

                                                            <div class="form-group <?php if(isset($row['tipo_pessoa']) && $row['tipo_pessoa']=='PF'){ echo "hide"; }elseif(!isset($row['tipo_pessoa'])){ echo "hide";}else{ echo "";}?> PJ">
                                                                <label for="InputCompany">Empresa </label>
                                                                <input type="text" class="form-control" name="empresa" placeholder="Empresa"  value="<?php if(isset($row['empresa'])){ echo $row['empresa']; }?>">
                                                            </div>
                                                            <div class="form-group required <?php if(isset($row['tipo_pessoa']) && $row['tipo_pessoa']=='PF'){ echo "hide"; }elseif(!isset($row['tipo_pessoa'])){ echo "hide";}else{ echo "";}?> PJ">
                                                                <label for="InputMobile">CNPJ <sup>*</sup></label>
                                                                <input type="text" name="cnpj" class="form-control cnpj" placeholder="CNPJ"  value="<?php if(isset($row['cnpj'])){ echo $row['cnpj']; }?>" >
                                                            </div>
                                                            <div class="form-group required <?php if(isset($row['tipo_pessoa']) && $row['tipo_pessoa']=='PF'){ echo "hide"; }elseif(!isset($row['tipo_pessoa'])){ echo "hide";}else{ echo "";}?> PJ">
                                                                <label for="InputMobile">Inscricao estadual <sup>*</sup></label>
                                                                <input type="text" name="inscricao_estadual" class="form-control" placeholder="Inscrição Estadual" value="<?php if(isset($row['inscricao_estadual'])){ echo $row['inscricao_estadual']; }?>">
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="InputMobile">Telefone <sup>*</sup></label>
                                                                <input type="tel" name="telefone" class="form-control tel" placeholder="Telefone" value="<?php if(isset($row['telefone'])){ echo $row['telefone']; }?>">
                                                            </div>



                                                            <div class="form-group">
                                                                <label for="InputAdditionalInformation">Informações adicionais </label>
                                                                <textarea rows="3" cols="26" name="informacoes_adicionais" class="form-control" ><?php if(isset($row['informacoes_adicionais'])){ echo $row['informacoes_adicionais']; }?></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
																													<div class="form-group required">
																																<label for="InputZip">CEP <sup>*</sup> </label>
																																<input type="text" class="form-control cep" name="cep" placeholder="CEP" value="<?php if(isset($row['cep'])){ echo $row['cep']; }else{ }?>">
																														</div>
                                                            <div class="form-group required">
                                                                <label for="InputState">Estado <sup>*</sup> </label>
                                                                <input class="form-control estado" disabled placeholder="DIGITE UM CEP" value="<?php if(isset($row['estado'])){ echo $row['estado']; }else{ }?>">
        																												<input type="hidden" class="form-control idEstado" name="idEstado" value="<?php if(isset($row['idEstado'])){ echo $row['idEstado']; }else{ }?>">
                                                            </div>
                                                             <div class="form-group required">
                                                                <label for="InputCountry">Cidade <sup>*</sup> </label>
                                                                <input class="form-control cidade" disabled placeholder="DIGITE UM CEP" value="<?php if(isset($row['cidade'])){ echo ucwords(mb_strtolower($row['cidade'])); }else{ }?>">
																																<input type="hidden" class="form-control idCidade" name="idCidade" value="<?php if(isset($row['idCidade'])){ echo $row['idCidade']; }else{ }?>">
                                                            </div>

                                                           <div class="form-group required">
                                                                <label for="InputZip">Bairro <sup>*</sup> </label>
                                                                <input type="text" class="form-control bairro" name="bairro" placeholder="Bairro" value="<?php if(isset($row['bairro'])){ echo $row['bairro']; }else{ }?>" >
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="InputAddress">Logradouro <sup>*</sup> </label>
                                                                <input type="text" class="form-control logradouro" name="logradouro" placeholder="Logradouro" value="<?php if(isset($row['logradouro'])){ echo $row['logradouro']; }else{ }?>">
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="InputCity">Número <sup>*</sup> </label>
                                                                <input type="text" class="form-control numero" name="numero" placeholder="Número" value="<?php if(isset($row['numero'])){ echo $row['numero']; }else{ }?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="InputAddress2">Complemento </label>
                                                                <input type="text" class="form-control" name="complemento" placeholder="Complemento" value="<?php if(isset($row['complemento'])){ echo $row['complemento']; }else{ }?>">
                                                            </div>

                                                            <div class="form-group required">
                                                                <label for="addressAlias">Por favor coloque um título para este endereço. <sup>*</sup></label>
                                                                <input type="text" name="titulo" class="form-control" placeholder="Título deste endereço"  value="<?php if(isset($row['titulo'])){ echo $row['titulo']; }else{ }?>">
                                                            </div>
                                                        </div>

                                                </div>


                                            </div>
                                            <div style="clear: both"></div>
                                            <?php
                                            if(isset($_GET['id'])){
                                            ?>
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $_GET['id'];?>">
                                            <?php
                                              }
                                            ?>

                                            <div class="pull-right"><button type="submit" class="btn btn-primary btn-lg "> Salvar &nbsp; <i class="fa fa-arrow-circle-right"></i> </button></div>
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

			$('.tipo_pessoa').on('ifChanged', function (event) {
					if ($("input[name='tipo_pessoa']:checked").val() == 'PF') {
              // console.log("PF");
							$(".PF").fadeIn('slow').removeClass("hide");
							$(".PJ").fadeOut('slow').addClass("hide");
          }
          if ($("input[name='tipo_pessoa']:checked").val() == 'PJ') {
              // console.log("PJ");
							$(".PJ").fadeIn('slow').removeClass("hide");
							$(".PF").fadeOut('slow').addClass("hide");
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
