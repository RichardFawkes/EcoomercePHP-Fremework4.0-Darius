<?php

        require_once('inc/def.php');
        require($siteHD."inc/API_Rede.php");
	      require_once($siteHD.'header.php');
        require_once($siteHD.'menu.php');
error_reporting(0);


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



  
    echo '<h1 style="color:#4bb777; text-align:center"> Sua compra foi realizada com sucesso!</h1>
    <h2 style="text-align:center"">
     Número do Pedido:&nbsp;&nbsp;<strong>#000'.$idCompra.'</strong></h2><br>
    <h4 style="color:red ;text-align:center"">Estamos aguardando seu pagamento!</h3>
    <div style="text-align:center;"">Você pode acompanhar o status suas compras, através do menu <strong style="color:green; "><a href="'.$site.'minhas-compras">MINHAS COMPRAS</a></strong>.
    </h4></div>
    <br>';

   
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
     color:#4bb777; 
    }
    .badge badge-success{
    color:#4bb777;
    }
    </style>
   
    <a href='.$r3['boletoUrl'].'  style="font-weight: bold; color: #4bb777;     padding: 2px 2px;
    text-decoration: none;
    display: block;
    font-weight: bold;
    text-align:center;
    font-size: 15px;
    border-radius: 5%;"> <i class="fa fa-file-text"></i> VISUALIZAR BOLETO</a>     
<hr size="10"> 
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
            <td colspan="3" style="background-color:#4bb777; color:white; " > Itens </td>
            <td style="width:15% ;background-color:#4bb777;"></td>
          </tr>


          <?php
          $sqltotalz = 'SELECT SUM(cp.valor) as total, cp.idProduto , p.titulo , p.img , cp.qtde , cor.cor, cp.valor, (cp.qtde*cp.valor) tot, p.estoque, p.quantidade
          FROM Compras_X_Produtos cp
          JOIN Produtos p ON p.id = cp.idProduto
          JOIN Cores cor ON cor.id = cp.idCorTampa
          WHERE idCompra = '.$idCompra.';';
          
          $qrz = mysqli_query($link , $sqltotalz);
          $qr = mysqli_fetch_assoc($qrz);
          
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
          
            $totalzao = ($rFrete['preco_frete']) + ($qr['tot']);

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
            <td class="price">'.$r['qtde'].' unidade'.$plural. ' &nbsp;    </td>
          
            
          
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
    echo '      <table style=" border-collapse: collapse;
    border:  2px solid #4bb777;">
    <tr style="border-collapse:collapse;">
     <td width="80%" style="padding:0;Margin:0;"><h4 style=" Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif; font-weight: bold;">Subtotal:</h4></td>
     <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif; font-weight: bold;">  '.formata_real($totalzao).'</h4></td>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <td width="70%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif; font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frete:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4></td>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight: bold;">'.formata_real($rFrete['preco_frete']).' </h4></td>

    </tr>
  </table></td>';
  
        echo '<iframe src="'.$boleto->boletoUrl.'" frameborder="0" width="100%" height="1250px" scrolling="no" ></iframe></div></div></div></div></div>';
        
	}else{
    echo '      <table style=" border-collapse: collapse;
    border: 2px solid #4bb777;">
    <tr style="border-collapse:collapse;">
     <td width="10%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight: bold;">Subtotal:</h4></td>
     <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight: bold;">  '.formata_real($totalzao).'</h4></td>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <td width="5%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frete:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4></td>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <td width="10%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight: bold;">'.formata_real($rFrete['preco_frete']).' </h4></td>

    </tr>
  </table></td>';
  
  echo '<a style="color:red;"> &nbsp;&nbsp; Ops! Ocorreu um erro ao gerar o boleto. </a> ';

  ;
    

		// echo "<pre>";
		// print_r($boleto);
		// echo "</pre><br><br>";
		// echo $boleto->responseCode;
        // echo "<br><br>".$boleto->responseMessage;
      
        
		
    }

   
    
		
		




	
	require_once($siteHD.'footer.php');
  //CREATE JOB
  $sqlcou = 'SET @row_number=0;';
  $sqldalim = 'SELECT (@row_number:=@row_number + 1) id ,p.titulo,d.idCompra,d.qtde,d.idProjeto,u.nome,cor.cor, (NOW()+INTERVAL p.prazo_producao day)data   FROM Compras_X_Produtos d
  JOIN Compras c ON c.id = d.idCompra
  JOIN Users u ON u.id = c.idUser
  JOIN Cores cor ON cor.id = d.idCorTampa
  JOIN Produtos p ON d.idProduto = p.id
  WHERE idCompra = "'.$idCompra.'" AND p.mostra_3d = 1';
  
  mysqli_query($link,$sqlcou);

  
  $qd = mysqli_query($link, $sqldalim);
  
 
  while($r = mysqli_fetch_assoc($qd)){

  $username = 'admin';
  $senha = 'lata@2020';
  
  $url = 'http://lojadalata.brasilata.com.br/Esprit/public/Interface/rpc';
  
  
      //create a new cURL resource
      $ch = curl_init($url);
      
      //setup request to send json via POST
  
      
      $json ='[
          {"id": 1, "method": "admin.login"}, 
          {"id": 2, "method": "job.create", "params":
          {"customerName":"lojadalata.com", "jobName":"PEDIDO #'.$idCompra.'-item-'.$r['id'].'", "projectTemplateName":"74", "roles": [{user:"richard.geraldo@lojadalata.com.br",role:"Creator"}]
          }
          },
          
          
          {"id": 7, "method": "admin.logout"}
          
     ]';
     
           
    
  
  
  
  
       $payload = $json;
    
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); //DOCUMENT
  
      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
          'Content-Type:application/json'));
      
      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      //execute the POST request
     $results = curl_exec($ch);
  
      // exit;
      //close cURL resource
      curl_close($ch);
  
    }

    
    
    
    //CREATE DOCUMENT 
  
    $sqlcouz = 'SET @row_number=0;';
    $sqldalims = 'SELECT (@row_number:=@row_number + 1) id ,p.titulo,d.idCompra,d.qtde,d.idProjeto,u.nome,cor.cor, (NOW()+INTERVAL p.prazo_producao day)data   FROM Compras_X_Produtos d
    JOIN Compras c ON c.id = d.idCompra
    JOIN Users u ON u.id = c.idUser
    JOIN Cores cor ON cor.id = d.idCorTampa
    JOIN Produtos p ON d.idProduto = p.id
    WHERE idCompra = "'.$idCompra.'" AND p.mostra_3d = 1';
    
    mysqli_query($link,$sqlcouz);
  
    
    $qds = mysqli_query($link, $sqldalims);
    
    $url2 = 'http://lojadalata.brasilata.com.br/Esprit/public/Interface/rpc';


while($rd = mysqli_fetch_assoc($qds)){


    //create a new cURL resource
    $chs = curl_init($url2);
    
    //setup request to send json via POST
    $json2 ='[
        {"id": 1, "method": "admin.login"}, 
        {"id":2, "method":"document.create", 
        "params":{
        "jobPath": "/lojadalata.com/PEDIDO #'.$idCompra.'-item-'.$rd['id'].'", 
        "name": "P'.$rd['idProjeto'].'.pdf", 
        "URL": "https://lojadalata.com/api/P'.$rd['idProjeto'].'.1.pdf",
        "documentWorkflow":"WFL_SiteLDL",
        "moveFile": "false",
        "metadatas":[["LDL","Nome_Cliente","'.$rd['nome'].'"],["LDL","ID_Pedido_Site","'.$idCompra.'"],["LDL","Item","'.$rd['titulo'].'"],["LDL","cor_tampa","'.$rd['cor'].'"],["LDL","prazo_prod","'.$rd['data'].'"],["LDL","qtd","'.$rd['qtde'].'"]]

    }

},
	{"id": 1, "method": "admin.logout"}
]

        
        
        ';
   


    $payload2 = $json2;
    //attach encoded JSON string to the POST fields
    curl_setopt($chs, CURLOPT_POSTFIELDS, $payload2);

    //set the content type to application/json
    curl_setopt($chs, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
   $results = curl_exec($chs);
   
    // exit;
    //close cURL resource
    curl_close($chs);
}

$sqlco = 'SET @row_number=0;';
$sqldali = 'SELECT (@row_number:=@row_number + 1) id ,p.titulo,d.idCompra,d.qtde,d.idProjeto,u.nome,cor.cor, (NOW()+INTERVAL p.prazo_producao day)data   FROM Compras_X_Produtos d
JOIN Compras c ON c.id = d.idCompra
JOIN Users u ON u.id = c.idUser
JOIN Cores cor ON cor.id = d.idCorTampa
JOIN Produtos p ON d.idProduto = p.id
WHERE idCompra = "'.$idCompra.'" AND p.mostra_3d = 1';

mysqli_query($link,$sqlco);


$qdl = mysqli_query($link, $sqldali);


while($r = mysqli_fetch_assoc($qdl)){
$username = 'admin';
$senha = 'lata@2020';

$url2 = 'http://lojadalata.brasilata.com.br/Esprit/public/Interface/rpc';


    //create a new cURL resource
    $chs = curl_init($url2);
    
    //CRIAR DOCUMENT TAMPA 
    $json2 ='[
        {"id": 1, "method": "admin.login"}, 
        {"id":2, "method":"document.create", 
        "params":{
        "jobPath": "/lojadalata.com/PEDIDO #'.$idCompra.'-item-'.$r['id'].'", 
        "name": "Tampa'.$r['idProjeto'].'.pdf", 
        "URL": "https://lojadalata.com/api/P'.$r['idProjeto'].'.2.pdf",
        "documentWorkflow":"WFL_SiteLDL",
        "moveFile": "false",
        "metadatas":[["LDL","Nome_Cliente","'.$r['nome'].'"],["LDL","ID_Pedido_Site","'.$idCompra.'"],["LDL","Item","'.$r['titulo'].'"],["LDL","cor_tampa","'.$r['cor'].'"],["LDL","prazo_prod","'.$r['data'].'"],["LDL","qtd","'.$r['qtde'].'"]]
    }

},
	{"id": 1, "method": "admin.logout"}
]

        
        
        ';
   


    $payload2 = $json2;
    //attach encoded JSON string to the POST fields
    curl_setopt($chs, CURLOPT_POSTFIELDS, $payload2);

    //set the content type to application/json
    curl_setopt($chs, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
   $results = curl_exec($chs);
   
    // exit;
    //close cURL resource
    curl_close($chs);
}
  
//FIM DOCUMENT CREATE DALIM


//FINAL API DALIM

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
