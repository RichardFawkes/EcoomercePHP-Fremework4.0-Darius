<?php

        require_once('inc/def.php');
        require($siteHD."inc/API_Rede.php");

	require_once($siteHD.'header.php');
        require_once($siteHD.'menu.php');



/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 */


?>


<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
      
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i class="glyphicon glyphicon-shopping-cart"></i> CHECKOUT</span></h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
            <h4 class="caps"><a href="<?php echo $site; ?>carrinho"><i class="fa fa-chevron-left"></i> Voltar para o carrinho </a></h4>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-12">


                    <div class="w100 clearfix">
                        <ul class="orderStep orderStepLook2">
                            <li><a href="<?php echo $site;?>checkout2"><i class="fa fa-truck "> </i><span>Frete</span> </a></li>
                            <li class="disable"><a href="<?php echo $site;?>checkout3"><i class="fa fa-money  "> </i><span>Pagamento</span> </a></li>
                            <li class="active"><a href="<?php echo $site;?>checkout3"><i class="fa fa-check-circle"></i><span>Finalizado</span> </a></li>

                            </li>
                        </ul>
                        <!--/.orderStep end-->
                    </div>



<?php


/*
	if(!is_null($idCupom)){
//		$sqlCupom = 'UPDATE CUpons SET dataUtilizacao = NOW() WHERE id = '.$idCupom;
//		mysqli_query($link , $sqlCupom);

		$sqlCupom = 'SELECT valor , origem FROM Cupons WHERE id = '.$idCupom;
		$qCupom = mysqli_query($link , $sqlCupom);
		$rCupom = mysqli_fetch_assoc($qCupom);
		$valorCupom = str_replace(".","",$rCupom['valor']);
		
		array_push($itens , Array("description" => "Cupom: " .$rCupom['origem'],"quantity" => 1, "price_cents" => -$valorCupom));
	}

*/




//	echo '<div class="text-center" style="width:100%;"><a href="'.$boleto['url'].'" target="_blank">Clique aqui, caso não visualize o boleto</a></div>';


	$idCompra = $_POST['idCompra'];


	$MaxiPago = new MaxiPago();
	$boleto = $MaxiPago->geraBoleto($idCompra);



  
    echo '<h1 style="color:green"> Sua compra foi realizada com sucesso!</h1>
    <h2>
     Número do Pedido:&nbsp;&nbsp;<strong>#000'.$idCompra.'</strong></h2><br>
    <h4 style="color:red">Estamos aguardando seu pagamento!</h3>
    Você pode acompanhar o status suas compras, através do menu <strong style="color:green;"><a href="'.$site.'minhas-compras">MINHAS COMPRAS</a></strong>.
    </h4>';

   
    $sqlFrete = 'SELECT tc.preco_frete, CONCAT(uxe.logradouro,", ",uxe.numero," - ",uxe.complemento ) endereco, uxe.cep, CONCAT(city.cidade,"/",e.sigla) endereco2
    FROM Compras c
    JOIN Transportadoras_Cotacoes tc ON tc.id = idTransportadoras_Cotacoes
    JOIN Users_X_Enderecos uxe ON uxe.id = c.idUsers_X_Enderecos
    JOIN CidadesIBGE city ON city.id = uxe.idCidade
    JOIN Estados e ON e.id = uxe.idEstado
    WHERE c.id='.$idCompra.';';
    $qFrete = mysqli_query($link , $sqlFrete);
    $rFrete = mysqli_fetch_assoc($qFrete);
  


    $sqlValor = 'SELECT SUM(qtde*valor) prod,(SELECT preco_frete FROM Compras c JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes WHERE c.id='.$idCompra.') frete,
    SUM(qtde*valor) + (SELECT preco_frete FROM Compras c JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes WHERE c.id='.$idCompra.') tot
    FROM Compras_X_Produtos
    WHERE idCompra='.$idCompra.'
    GROUP BY idCompra;';
    $resValor = mysqli_query($link, $sqlValor);
    $rowValor = mysqli_fetch_array($resValor);
    $total_carrinho = $rowValor['tot'];
  

    // $tota_carrinho2 =  $rowValor['tot'] + $rFrete['preco_frete'];


    // $sqlValor2 = 'SELECT SUM(qtde*valor) prod,
    // SUM(qtde*valor) + (SELECT preco_frete FROM Compras c JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes WHERE c.id='.$_POST['idCompra'].') tot
    // FROM Compras_X_Produtos
    // WHERE idCompra='.$_POST['idCompra'].';
    // GROUP BY idCompra;';
    // $resValor2 = mysqli_query($link, $sqlValor2);
    // $rowValor2 = mysqli_fetch_array($resValor2);
    // $total_carrinho2 = $rowValor2['prod'];

    


		$sql3 ='SELECT boletoUrl FROM Compras_X_Invoices WHERE idCompra = '.$idCompra.';';
    $q3 = mysqli_query($link , $sql3);
    $r3 = mysqli_fetch_assoc($q3);

			
		
			
			
		

    
    echo' <tr style="border-collapse:collapse;">
    <br>
    <style>
    strong{
     color:green; 
    }
    .badge badge-success{
    color:green
    }
    </style>
   
    <a href='.$r3['boletoUrl'].' class="badge badge-success">CLIQUE AQUI LINK DO BOLETO</a>     

    <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px; ">
     <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
       <tr style="border-collapse:collapse;">
        <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
         <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE;" width="100%" cellspacing="0" cellpadding="0">
           <tr style="border-collapse:collapse;">
           '
    ?>
    <div>
   <?php
echo '           <tr class="CartProduct">
<td class="CartProductThumb">


     <h4>  Endereço de Entrega :</h4></td>

        <td align="right" style="padding:0;Margin:0;padding-bottom:10px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$rFrete['endereco'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$rFrete['endereco2'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$rFrete['cep'].'</p></td>
       </tr>
     </table></td>
   </tr>
 </table>';
   ?>

    <div class="cartContent table-responsive ">
      <table  class="cartTable cartTableBorder">
        <tbody>

          <tr class="CartProduct  cartTableHeader">
            <td colspan="3" > Itens </td>
            <td style="width:15%"></td>
          </tr>


          <?php
          $sql = 'SELECT cp.idProduto , p.titulo , p.img , cp.qtde , cor.cor, cp.valor, (cp.qtde*cp.valor) tot, p.estoque, p.quantidade
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

           $totals = ($rFrete['preco_frete']) +  ($rFrete['preco_frete']);

            echo '
            <tr class="CartProduct">
            <td class="CartProductThumb">
            <div><a href="'.$site.'produto/'.$r['idProduto'].'"><img alt="img" src="'.$site.'images/product/mini/'.$r['img'].'"></a></div>
            </td>
            <td>
            <div class="CartDescription">
            <h4><a href="'.$site.'produto/'.$r['idProduto'].'">'.$r['titulo'].'</a></h4>
            <span class="size">Cor da tampa: '.$r['cor'].'</span>
            </div>
            </td>
              <td>'.formata_real($r['valor']).'&nbsp; &nbsp;&nbsp;</td>
            <td class="price">'.$r['qtde'].' unidade &nbsp;   '.$plural. ' </td>
          
            
          
 </td>
 </td>
     </tr>
   



            ';
            

            $produtoEmail .= '<tr style="border-collapse:collapse;">
            <td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$r['titulo'].' ('.$r['cor'].')</p></td>
            <td style="padding:5px 0;Margin:0;" width="20%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">R$ '.$r['tot'].'</p></td>
            </tr>
            
            ';
            $totalValor = $totalValor+$r['tot'];
          }

       
          ?>


        </tbody>
      </table>
    </div>

  </div>

  
  <?php
    
	if($boleto->responseCode == '0' && $boleto->responseMessage == 'ISSUED'){
        echo '<iframe src="'.$boleto->boletoUrl.'" frameborder="0" width="100%" height="1250px" scrolling="no" ></iframe></div></div></div></div></div>';
        
	}else{
    echo '<br><br>Ops! Ocorreu um erro ao gerar o boleto. ';
    

		// echo "<pre>";
		// print_r($boleto);
		// echo "</pre><br><br>";
		// echo $boleto->responseCode;
        // echo "<br><br>".$boleto->responseMessage;
      
        
		
    }

   
    
		
		




	
	require_once($siteHD.'footer.php');


 //       $sql = 'DELETE FROM Carrinho WHERE idUser = '.$idUser.';';
 //       mysqli_query($link , $sql);

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
