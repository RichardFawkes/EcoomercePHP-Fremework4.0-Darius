<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
	    <li><a href="<?php echo $site; ?>">Home</a></li>
                <li class="active"> Compra finalizada </li>
            </ul>
        </div>
    </div>
    <!--/.row-->


    <div class="row">
        <div class="col-lg-12 ">
            <div class="row userInfo">

                <div class="thanxContent text-center">

                    <h1> Sua compra foi efetuada com sucesso!</h1>
		    						<h4>
											Número do Pedido: <?php echo $_POST['idCompra'];?><br>
											Você pode acompanhar as entregas das suas compras, através do menu <strong><a href="<?php echo $site; ?>minhas-compras">MINHAS COMPRAS</a></strong>.
										</h4>

                </div>

                <div class="col-lg-7 col-center">
                    <h4></h4>

                    <div class="cartContent table-responsive  w100">
                        <table style="width:100%" class="cartTable cartTableBorder">
                            <tbody>

                            <tr class="CartProduct  cartTableHeader">
                                <td colspan="2"> Itens Comprados</td>


                                <td style="width:15%"></td>
                            </tr>
