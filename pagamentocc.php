<?php

require_once('inc/def.php');
require($siteHD."inc/API_Rede.php");


$idCompra = @$_POST['idCompra'];
$numeroDoCartao = str_replace(' ' , '' , @$_POST['numeroDoCartao']);

$e = explode('/' , @$_POST['exp']);
$mesExp = @$e[0];
$anoExp = @$e[1];
$cvv = @$_POST['cvv'];

/*
$sql = 'SELECT SUM(valor*qtde) valor FROM Compras_X_Produtos WHERE idCompra = '.$idCompra.';';
$q = mysqli_query($link , $sql);
$r = mysqli_fetch_assoc($q);
$valor = number_format($r['valor'] , 2 , '.' , '');
*/

$MaxiPago = new MaxiPago();

$MaxiPago->setCreditCard($numeroDoCartao , $mesExp , $anoExp , $cvv);

// $pagamento = $MaxiPago->pagarCC($idCompra);
// Descomentar para parcelamento
$pagamento = $MaxiPago->pagarCC($idCompra,$_POST['parcelas']);

require_once($siteHD.'header.php');
require_once($siteHD.'menu3.php');



/*
exit;
$sqlCupom = 'UPDATE Cupons SET dataUtilizacao = NOW() WHERE id = '.$idCupom;
mysqli_query($link , $sqlCupom);


echo '<br><br>
<div class="container">
<div class="row">
<div class="col-sm-12 text-center">
<h3>Sua compra foi realizada com sucesso!</h3><br><h5>Assim que o código de rastreio dos correios estiver disponível, enviaremos pra você por email.<br><br>A identificação desta transação é: '.$cc['invoice_id'].'<br><br>Obrigado!</h5>
</div>
</div>
</div>
<br><br>';



echo '<br><br>
<div class="container">
<div class="row">
<div class="col-sm-12 text-center">
<h3>Ocorreu um erro!</h3><br><h5>O pagamento não foi autorizado pela operadora do seu cartão...</h5>
</div>
</div>
</div>
<br><br>';



require_once($siteHD.'inc/rodape.php');
*/




?>
<div class="se-pre-con"></div>


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
          <?php
                   if(@$pagamento->responseCode == '0' && @$pagamento->responseMessage == 'CAPTURED'){
            

                    require_once($siteHD.'inc/api_frete_rapido.php');
                    $freteRapido = new FreteRapido();
                    $freteRapido->contratarFrete($idCompra);
                    //	echo $codigoRastreio; exit;
           
                  
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
  
  $url = 'http://lojadalata.brasilata.com.br/Esprit/public/Interface/rpc';
  $username = 'admin';
  $senha = 'lata@2020';

  while($r = mysqli_fetch_assoc($qd)){


      //create a new cURL resource
      $ch = curl_init($url);
      
      //setup request to send json via POST
  
      
      $json2 ='[
          {"id": 1, "method": "admin.login"}, 
          {"id": 2, "method": "job.create", "params":
          {"customerName":"lojadalata.com", "jobName":"PEDIDO #'.$idCompra.'-item-'.$r['id'].'", "projectTemplateName":"74", "roles": [{user:"richard.geraldo@lojadalata.com.br",role:"Creator"}]
          }
          },
          
          
          {"id": 1, "method": "admin.logout"}
          
     ]';
     
           
    
  
  
  
  
       $payload = $json2;
    
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

  
    

    
    
    
    //CREATE CORPO DOCUMENTE 
 

    $chs = curl_init($url);
    
    //setup request to send json via POST
    $json3 ='[
      {"id": 1, "method": "admin.login"}, 
      {"id":2, "method":"document.create", 
      "params":{
      "jobPath": "/lojadalata.com/PEDIDO #'.$idCompra.'-item-'.$r['id'].'", 
      "name": "Corpo'.$r['idProjeto'].'.pdf", 
      "URL": "https://lojadalata.com/api/P'.$r['idProjeto'].'.1.pdf",
      "documentWorkflow":"WFL_SiteLDL",
      "moveFile": "false",
      "metadatas":[["LDL","Nome_Cliente","'.$rd['nome'].'"],["LDL","ID_Pedido_Site","'.$idCompra.'"],["LDL","Item","'.$rd['titulo'].'"],["LDL","cor_tampa","'.$rd['cor'].'"],["LDL","prazo_prod","'.$rd['data'].'"],["LDL","qtd","'.$rd['qtde'].'"]]

  }

},
{"id": 1, "method": "admin.logout"}
]

      
      
      ';
 

    $payload3 = $json3;
    //attach encoded JSON string to the POST fields
    curl_setopt($chs, CURLOPT_POSTFIELDS, $payload3);

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






    //CRIAR DOCUMENT TAMPA 

    $chz = curl_init($url);
    
    $json2 ='[
        {"id": 1, "method": "admin.login"}, 
        {"id":2, "method":"document.create", 
        "params":{
        "jobPath": "/lojadalata.com/PEDIDO #'.$idCompra.'-item-'.$r['id'].'", 
        "name": "Tampa'.$r['idProjeto'].'.pdf", 
        "URL": "https://lojadalata.com/api/P'.$r['idProjeto'].'.2.pdf",
        "documentWorkflow":"WFL_SiteLDL",
        "moveFile": "false"
    }

},
	{"id": 1, "method": "admin.logout"}
]

        
        
        ';
   


    $payload2 = $json2;
    //attach encoded JSON string to the POST fields
    curl_setopt($chz, CURLOPT_POSTFIELDS, $payload2);

    //set the content type to application/json
    curl_setopt($chz, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($chz, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
   $results = curl_exec($chz);
   
    // exit;
    //close cURL resource
    curl_close($chz);
    // echo $results;

    }


  
//FIM DOCUMENT CREATE DALIM


//FINAL API DALIM

            // require_once($siteHD.'inc/api_frete_rapido.php');
            // $freteRapido = new FreteRapido();
            // $freteRapido->contratarFrete($idCompra);
            //	echo $codigoRastreio; exit;

            echo '<h1> Sua compra foi efetuada com sucesso!</h1>
            <h3>
            Número do Pedido: <a style="color=#4bb777; "><strong>#00'.$idCompra.'</strong></a><br></h3>
            <h4>Você pode acompanhar as entregas das suas compras, através do menu <strong><a style="color=#4bb777; " href="'.$site.'minhas-compras"><i class="fa fa-shopping-bag"></i> MINHAS COMPRAS</a></strong>.
            </h4>';

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
            $mail->addReplyTo('recupera.senhaldl@gmail.com', 'Loja da Lata');

            // PEGA O EMAIL E O NOME DO CLIENTE
            $sqlInfo = 'SELECT u.nome, u.email
            FROM Compras c
            JOIN Users u ON u.id = c.idUser
            WHERE c.id='.$idCompra;
            $resInfo = mysqli_query($link,$sqlInfo);
            $rowInfo = mysqli_fetch_array($resInfo);
            //Set who the message is to be sent to
            $mail->addAddress($rowInfo['email'], $rowInfo['nome']);

            //Set the subject line
            $mail->Subject = utf8_decode('Recebemos seu pedido #'.$idCompra.'');

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            ?>
            <div class="col-lg-7 col-center">
              <h4></h4>

              <div class="cartContent table-responsive w100 ">
                <table style="width:100%  position: fixed;" class="cartTable cartTableBorder">
                  <tbody>
                  
                    <tr class="CartProduct  cartTableHeader">
                    <td colspan="3" style="background-color:#4bb777; color:white; border-style: solid ;border-width: 2px ; border-color:#4bb777;" > Itens </td>
                      <!-- <td style="width:15%; background-color:#4bb777;"></td> -->
                    </tr>


                    <?php
                    $sql = 'SELECT cp.idProduto , p.titulo , p.img , cp.qtde ,cor.cor, cp.valor, (cp.qtde*cp.valor) tot, p.estoque, p.quantidade,cp.idProjeto
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

                   if($r['idProjeto']==''){
                      echo '
                      <tr class="CartProduct" style=" border-style: solid ;
                      border-width: 2px ; border-color:#4bb777; ">
                      <td class="CartProductThumb">
                      
                      <div><a href="'.$site.'produto/'.$r['idProduto'].'"><img alt="img" src="'.$site.'images/product/mini/'.$r['img'].'"></a></div>
                      </td>
                      <td>
                      <div class="CartDescription" >
                      <h4><a style="color:#4bb777; "href="'.$site.'produto/'.$r['idProduto'].'"> &nbsp;'.$r['titulo'].'</a></h4>
                      <span class="size">Cor da tampa: '.$r['cor'].'</span>
                      </div>
                      </td>
                      <td class="price">'.$r['qtde'].' unidade'.$plural.' </td>
                      </tr>';
                   }else{
                    echo '
                    <tr class="CartProduct"  style=" border-style: solid ;
                    border-width: 2px ; border-color:#4bb777; ">
                    <td class="CartProductThumb border-color:#4bb777; " >
                    
                    <div ><a style="color:#4bb777;" href="'.$site.'produto/'.$r['idProduto'].'"><img alt="img" src="'.$editorlink.'productthumb.ashx?p='.$r['idProjeto'].'"></a></div>
                    </td>
                    <td>
                    <div class="CartDescription"  >
                    <h4><a style="color:#4bb777; href="'.$site.'produto/'.$r['idProduto'].'">&nbsp; '.$r['titulo'].'</a></h4>
                    <span class="size">Cor da tampa: '.$r['cor'].'</span>
                    </div>
                    </td>
                    <td class="price">'.$r['qtde'].' unidade'.$plural.' </td>
                    </tr>';
                   }

                      $produtoEmail .= '<tr style="border-collapse:collapse;">
                      <td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$r['titulo'].' ('.$r['cor'].')</p></td>
                      <td style="padding:5px 0;Margin:0;" width="20%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">R$ '.$r['tot'].'</p></td>
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
                    $produtoEmail .= '<tr style="border-collapse:collapse;">
                    <td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">Frete</p></td>
                    <td style="padding:5px 0;Margin:0;" width="20%" align="left"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333;">R$ '.$rFrete['preco_frete'].'</p></td>
                    </tr>';
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
                                  <td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#777777;">Seu pedido logo será enviado.&nbsp;</p></td>
                                  <align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#009000;">Pagamento Aprovado!. &nbsp;</p></td>

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
          }else{
            echo '<h1> Ops! Ocorreu um erro ao efetuar seu pagamento.</h1>';
            /*
            echo '<br><br>Erro: ';
            echo "<pre>";
            print_r($pagamento);
            echo "</pre><br><br>";
            echo $pagamento->responseCode;
            echo "<br><br>".$pagamento->responseMessage;
            */
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

<div class="gap"></div>
<?php


// $sqldelete = 'DELETE FROM Carrinho WHERE idUser = "'.$_SESSION['idUser'].'"';
// mysqli_query($link,$sqldelete);
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

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>


</body>
</html>
