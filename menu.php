<?php
    require_once('inc/def.php');

    require_once($siteHD.'inc/carrinho.php');
 

    $carrinho = new Carrinho;

    
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
    $("#resultado").html("Calculando...");
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

</head>


<style>
@media (max-width: 767px) /* @grid-float-breakpoint -1 */
{

 
}
.no-paddings {
    background-color: #4bb777;
}
@media (min-width: 900px){
.no-paddings {
    padding: 0 !important;
    background-color: #4bb777;
    left: 187px;
    width: 300px;
    border-radius: 0px 0px 20px 20px;
}


}

@media (min-width: 200px) and(max-width: 400px) {
.no-paddings {
    padding: 0 !important;
    background-color: #4bb777;
    width: 100%;
    border-radius: 0px 0px 20px 20px;
}
}


.navbar-nav > li > .dropdown-menu {
    margin-top: 0;
    height: 57px;
    line-height: 22px;
    position: absolute;
    left: 10px;
    font-size: 14px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
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
				<input name="email" id="login-user" class="form-control input" size="20" placeholder="Entre com seu email" type="text" required>
			    </div>
			</div>
			<div class="form-group login-password">
			    <div>
				<input name="senha" id="login-password" class="form-control input" size="20" placeholder="Senha" type="password" required>
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
								<input name="nome" class="form-control input" size="20" placeholder="Nome" type="text" required>
							    </div>
							</div>
							<div class="form-group reg-email">
							    <div>
								<input name="email" class="form-control input" size="20" placeholder="Email" type="text" required>
							    </div>
							</div>
							<div class="form-group reg-password">
							    <div>
								<input name="senha" class="form-control input" size="20" placeholder="Senha" type="password" required>
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
<div class="navbar navbar-tshop megamenu " role="navigation">
    <div class="navbar-top">
        <div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <div class="pull-left ">
                        <ul class="userMenu ">
													
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-4 col-xs-12 col-md-4 no-margin no-paddings">
                    <div class="pull-right">
                        <ul class="">

                        

<?php
    if (!isset($_SESSION['tempUser'])) {
        echo ' 	<li  class="hidden-xs"><a style=" font-weight: bold;
        left: 34px;
        position: absolute;
    } font-weight: bold;
    color:white
        "><i class="fa fa-user"></i>&nbsp; '.$_SESSION['nome'].'<a style="position: absolute;
        left: 10px;
        color: white;
    }"> Olá,</a> </a></li>
			<li  style="    color: white;
            margin-right: 29px;
            /* margin-left: 0; */
        }"><a href="'.$site.'minhas-compras"> <span  style=" color: white;"class="hidden-xs">Minhas Compras </span>
			<i class="glyphicon glyphicon-user hide visible-xs "></i> </a></li>
			<li><a href="'.$site.'meus-enderecos"> <span style=" color: white;"class="hidden-xs">Meus Endereços </span>
			<i class="glyphicon glyphicon-pushpin hide visible-xs "></i> </a></li>

			<li><a href="'.$site.'sair"> <span style=" color: white;" class="hidden-xs"> Sair </span>
			<i class="glyphicon glyphicon-log-out hide visible-xs "></i> </a></li></ul>';
    } else {
        echo '
        <ul class="userMenu">
        <li><a href="#" data-toggle="modal" data-target="#ModalLogin"> <span class="hidden-xs"> <i class="fa fa-user-circle"></i></i>Olá,<span style="  font-weight: bold;
        "> Visitante</span></span>

          <i class="glyphicon glyphicon-log-in hide visible-xs "></i> <label class="hide visible-xs">ENTRAR</label> </a></li><li><a href="#" data-toggle="modal" data-target="#ModalLogin"> <span class="hidden-xs"></span>

           </a></li>
          <li class="hidden-xs"><a href="#" data-toggle="modal" data-target="#ModalSignup"> <span class="hidden-xs">Cadastre-se</span>
          <i class="fa fa-sign-in"></i></i> </a></li></ul>';
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
            <a class="navbar-brand "href="<?php echo $site; ?>"> <img src="<?php echo $site; ?>images/logo2.png" alt="TSHOP"> </a>

            <!-- this part for mobile -->
            <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
                <div class="input-group">
                </div>
                <!-- /input-group -->

            </div>
        </div>

        <!-- this part is duplicate from cartMenu  keep it for mobile -->
        <div class="navbar-cart  collapse">
            <div class="cartMenu <?php if ($_SESSION['open_cart']==1) {
     echo 'open';
 }?>  col-lg-4 col-xs-12 col-md-4 ">
                <div class="w100 miniCartTable scroll-pane">
                    <table>
                        <tbody>

				<?php
                foreach ($carrinho->getProdutos() as $k=>$v) {
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
						<td style="width:10%" class="miniCartQuantity"><a>  '.$v['qtde'].' X </a></td>
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
                    
		    <a class="btn btn-sm btn-primary" href="<?php echo $site; ?>carrinho"> FINALIZAR </a>
            
		</div>
                <!--/.miniCartFooter-->

            </div>
            <!--/.cartMenu-->
        </div>
        <!--/.navbar-cart-->

       
        
                    </form>
                    <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">


            <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          MENU
        </a>
        
        

                    <div class="searchbusca pull-right">
					<form action="<?php echo $site;?>produtos" method="get" id="formbusca" name="formbusca">
            <input type="search"  class="form-control form-controlsz mr-sm-2" data-searchurl="search?=" name="q" placeholder="Buscar" >
                    
            
        </form>
        </div>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            
                            <?php
			$sql = '   SELECT  p.id , p.categoria , p.img , SPLIT_STRING(descricao,"<br><br>",1) descricao ,  p.urlLink url  FROM Categorias p WHERE ativo = 1 ORDER BY p.id DESC , id DESC LIMIT 8;';
            $q = mysqli_query($link, $sql);
                                $nr = mysqli_num_rows($q);

                                if ($nr > 0) {
                                    
                                    while ($r = mysqli_fetch_assoc($q)) {
                                        echo '          <a class="btn btn-dark" style="font-size:8px;"  
 href="'.$site.'configurar-produto?i='.$r['id'].'">&nbsp; '.$r['categoria'].'&nbsp;<br></a>';
                                    }
                                }
                                

                   ?>
       
    </div>
                   </li>
                             

                            <?php


                                $sql3 = 'SELECT * FROM Categorias WHERE ativo = 1 AND idTipo = 1 AND mailcliente IS NOT NULL';
                                $qs = mysqli_query($link, $sql3);
                                $qsf = mysqli_query($link, $sql3);
                                $r = mysqli_fetch_assoc($qsf);

                                $nrs = mysqli_num_rows($qs);

                                $sqlmail = 'SELECT * FROM Categorias WHERE ativo = 1 AND idTipo = 1 AND mailcliente IS NOT NULL';

                                $resmail = mysqli_query($link, $sqlmail);
                                $rowbcc = mysqli_fetch_array($resmail);
                                $bccExplode = explode(",", $rowbcc['mailcliente']);
                                foreach ($bccExplode as $key => $bcc) {
                                    $sql2 = 'SELECT email FROM Users WHERE id = "'.$_SESSION['idUser'].'" AND email LIKE "%'.$bcc.'"';
                                }
                               $qsd = mysqli_query($link, $sql2);
                               $nrd = mysqli_num_rows($qsd);


                                if ($nrd > 0) {
                                    while ($r = mysqli_fetch_assoc($qs)) {
                                    }
                                }
                                ?>

            </ul>


            <!--- this part will be hidden for mobile version -->
            <div class="nav navbar-nav navbar-right hidden-xs">
                <div class="dropdown  cartMenu <?php if ($_SESSION['open_cart']==1) {
                                    echo 'open';
                                }?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                        class="fa fa-shopping-cart"> </i> <span class="cartRespons"> Carrinho (<?php echo formata_real($carrinho->getSubTotal()); ?>) </span> <b
                        class="caret"> </b> </a>

                    <div class="dropdown-menu col-lg-4 col-xs-12 col-md-4 ">
                        <div class="w100 miniCartTable scroll-pane">
                            <table>
                                <tbody>

				<?php
         

                
             
                    
                    foreach ($carrinho->getProdutos() as $k=>$v) {
                        echo '
						<tr class="miniCartProduct">
                            <td style="width:20%" class="miniCartProductThumb">
                            ';
                        if ($v['idProjeto']== '') {
                            echo'
                               
                            <div><a href="'.$site.'produto/'.$v['url'].'"> <img src="'.$site.'images/product/mini/'.$v['img'].'" alt="img">';
                        } else {
                            echo ' 
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
						    <td style="width:10%" class="miniCartQuantity"><a> '.$v['qtde'].' &nbsp;X </a></td>
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
				<a class="btn btn-sm btn-primary" href="<?php echo $site; ?>carrinho"> FINALIZAR </a></div>
                        <!--/.miniCartFooter-->

                    </div>
                    <!--/.dropdown-menu-->
                </div>
                <!--/.cartMenu-->

                <!--/.search-box -->
            </div>
            <!--/.navbar-nav hidden-xs-->
        </div>
        <!--/.nav-collapse -->

    </div>
    <!--/.container -->

  
    <!--/.search-full-->

</div>
