<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ADM</title>
	
	<!-- Include media queries -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://supermatch.group/LDL/assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://supermatch.group/LDL/assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://supermatch.group/LDL/assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="https://supermatch.group/LDL/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="https://supermatch.group/LDL/assets/ico/favicon.png">


	<link href="<?php echo $rot;?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/css/core.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/css/components.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/css/pages.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/css/menu.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

	<!--Morris Chart CSS -->
	<link href="<?php echo $rot;?>assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $rot;?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
	<!-- Menu -->
	<link href="<?php echo $rot;?>assets/css/responsivemultimenu.css" rel="stylesheet" type="text/css" />
	<!-- DATATABLES CSS -->


	<!-- DatePicker -->
	<link href="<?php echo $rot;?>assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

	<!-- CSS -->
	<link href="<?php echo $rot;?>assets/css/main.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<script src="<?php echo $rot;?>assets/js/modernizr.min.js"></script>
</head>

<body>
	<!-- Navigation Bar-->
	<header id="topnav">
		<div class="topbar-main">
			<div class="container">

				<div class="topbar-left">
					<a href="<?php echo $rot ?>dashboard/index" class="logo">
						<img src="https://supermatch.group/LDL/images/logo.png" />
					</a>
				</div>

				<div class="menu-extras">
					<div class="nav navbar-nav navbar-right pull-right">
						<div class="dropdown user-box">
							<span class="dropdown-toggle profile " style="cursor:default;">
								<?php echo $_SESSION['nome'];?>
								<img src="<?php echo $rot;?>assets/images/users/user.png" alt="user-img" class="img-circle user-img">
							</span>
						</div>
					</div>
				</div>
			</div> <!-- !container -->
		</div> <!-- !topbar-main -->
		<div class="container">
			<div class="rmm style">
				<!-- Navigation Menu-->
				<ul>
					<li>
						<a class="" href="<?php echo $rot;?>dashboard/index"> <span><i class="zmdi zmdi-view-dashboard"></i> Dashboard </span> </a>
					</li>
					<li>
						<a class="" href="<?php echo $rot;?>pedidos/pedidos"><span><i class="glyphicon glyphicon-th-list"></i> Pedidos</span></a>
						<ul>

						<li><a class="" href="<?php echo $rot;?>usuarios/index-cliente"><span>Criar Pedido</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/pendentes"><span>Pgto. Pendente</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/producao"><span>Em Produção</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/enviar"><span>A Enviar</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/entrega"><span>Aguardando Entrega</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/produtoAcesso"><span>Produtos Visitados </span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/acessos"><span>Paginas Visitadas </span></a></li>



						</ul>
					</li>
					<li>
						<a class="" href="<?php echo $rot;?>usuarios/index"><span><i class="fa fa-users"></i> Usuários Clientes</span></a>
						<ul>
						<li><a class="" href='<?php echo $site?>adm/pedidos/criarPedido/criar' target="_blank"><span>Cadastrar Cliente</span></a></li>
							<li><a class="" href="<?php echo $rot;?>usuarios/index"><span>Buscar</span></a></li>
							<li><a class="" href="<?php echo $rot;?>usuarios/newsletters"><span>Newsletter</span></a></li>
							<li><a class="" href="<?php echo $rot;?>usuarios/contatos"><span>Contatos Site</span></a></li>
						</ul>
					</li>

			
					<li>
						<a class="" href=""><span><i class="fa fa-th-list"></i> Relatorios</span></a>
						<ul>
							
							<li><a class="" href="<?php echo $rot;?>pedidos/relatorio-pedidos"><span>Relatorio Data/Produto/Pago</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/relatorio-pedidos-all"><span>Relatorio Data/Pago</span></a></li>
							<li><a class="" href="<?php echo $rot;?>pedidos/relatorio-pedidos-categoria"><span>Relatorio Data/Categoria/Pago</span></a></li>


							<!-- <li><a class="" href="<?php echo $rot;?>pedidos/acessos"><span>Relagorio Visitadas </span></a></li> -->



						</ul>
					</li>
					<li>
						<a class="" href="<?php echo $rot;?>cupons/cupons"><span><i class="fa fa-tags"></i> Cupons</span></a>
						<ul>
							
							<li><a class="" href="<?php echo $rot;?>cupons/cupons"><span>Cupons</span></a></li>



							<!-- <li><a class="" href="<?php echo $rot;?>pedidos/acessos"><span>Relagorio Visitadas </span></a></li> -->



						</ul>
					</li>

					<?php
                    if ($_SESSION['id_hierarquia'] == 1) {
                        ?>
						<li>
							<a class="" href="#"><span><i class="fa fa-cogs"></i> Configurações </span> </a>
							<ul>
								<li><a class="" class="" href="<?php echo $rot; ?>banners/index"> <span> Banner </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>clientes/index"> <span> Clientes </span></a></li>
								<!-- <li><a class="" class="" href="<?php echo $rot; ?>linhas-proprias/index"> <span> Linhas Próprias </span></a></li>  DESATIVADO SEM USO--> 
								<li><a class="" class="" href="<?php echo $rot; ?>categorias/index"> <span> Grupo de Produtos </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>temas/index"> <span> Temas de Produto</span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>tipos/index"> <span> Tipos de Personalizacao</span></a></li>

								<li><a class="" class="" href="<?php echo $rot; ?>produtos/index"> <span> Produtos </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>faq/index"> <span> FAQ </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>whats/app"> <span> WHATSAPP </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>pages/editar?id=1"> <span> Política de Troca </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>pages/editar?id=2"> <span> Quem Somos </span></a></li>
								<li><a class="" class="" href="<?php echo $rot; ?>configuracao/index"> <span> Geral </span></a></li>
							</ul>
						</li>



					<?php
                    }  ?>
				</ul>
				<!-- End navigation menu  -->

			</div><!-- !rm -->
		</div><!-- !container -->
	</header>
	<!-- End Navigation Bar-->
