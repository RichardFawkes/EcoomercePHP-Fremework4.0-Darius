<?php
require_once('../../inc/def.php');
header('Content-Type: application/json');
libera_acesso(1,2,3,4);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$upd = 'UPDATE Compras SET statusProducao="'.$_POST['status'].'" WHERE id='.$_POST['id'].';';
$q = mysqli_query($link,$upd);

if($q){
  $sqlStatus = 'SELECT s.status
  FROM StatusCompra s
  WHERE s.id='.$_POST['status'];
  $resStatus = mysqli_query($link,$sqlStatus);
  $rowStatus = mysqli_fetch_array($resStatus);
  // $rowStatus['status'];





            // EMAIL
            require_once('../../inc/PHPMailer/PHPMailerAutoload.php');

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
            $mail->Host = 'smtplw.com.br';
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
            $mail->Username = "brasilata";

            //Password to use for SMTP authentication
            $mail->Password = "zomeSzRz4278";

            //Set who the message is to be sent from
            $mail->setFrom('noreply@lojadalata.com.br', 'Loja da Lata');

            //Set an alternative reply-to address
            $mail->addReplyTo('contato@lojadalata.com.br', 'Loja da Lata');




            // PEGA O EMAIL E O NOME DO CLIENTE
            $sqlInfo = 'SELECT u.nome, u.email
            FROM Compras c
            JOIN Users u ON u.id = c.idUser
            WHERE c.id='.$_POST['id'];
            $resInfo = mysqli_query($link,$sqlInfo);
            $rowInfo = mysqli_fetch_array($resInfo);
            //Set who the message is to be sent to
            $mail->addAddress($rowInfo['email'], $rowInfo['nome']);
            // $mail->addBCC('contato@lojadalata.com.br');

            //Set an alternative reply-to address
            $mail->addReplyTo('contato@lojadalata.com.br', 'Loja da Lata');

            //Set the subject line
            $mail->Subject = utf8_decode('Status do seu Pedido #'.$_POST['id']);



            $mail->msgHTML(utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          
            <html style="width:100%;font-family:\&#39;open sans\&#39;, \&#39;helvetica neue\&#39;, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

                          <meta content="width=device-width, initial-scale=1" name="viewport">
                          <meta name="x-apple-disable-message-reformatting">
                          <meta http-equiv="X-UA-Compatible" content="IE=edge">
                          <meta content="telephone=no" name="format-detection">
                          <title>Confirmação do Pedido</title>

                          <link href="./Confirmação do Pedido_files/css" rel="stylesheet">
                          <!--<![endif]-->
                          <style type="text/css">
                        @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:32px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button { font-size:16px!important; display:inline-block!important; border-width:15px 30px 15px 30px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
                        #outlook a {
                          padding:0;
                        }
                        .ExternalClass {
                          width:100%;
                        }
                        element.style {
                     
                          padding-top: 0;
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
                         <body style="width:100%;font-family:\&#39;open sans\&#39;, \&#39;helvetica neue\&#39;, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
                          <div class="es-wrapper-color" style="background-color:#EEEEEE;">
                           <!--[if gte mso 9]>
                              <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                <v:fill type="tile" color="#eeeeee"></v:fill>
                              </v:background>
                            <![endif]-->
                           <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
                             <tbody><tr style="border-collapse:collapse;">
                              <td valign="top" style="padding:0;Margin:0;">
                               <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                                 <tbody><tr style="border-collapse:collapse;"></tr>
                               </tbody></table>
                               <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                                 <tbody><tr style="border-collapse:collapse;"></tr>
                                 <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;">
                                   <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#4bb777;" width="600" cellspacing="0" cellpadding="0" bgcolor="#4bb777" align="center">
                                     <tbody><tr style="border-collapse:collapse; height:100px;">
                                      <td class="es-m-txt-c" align="center" style="padding:0;Margin:0;"><img src="https://www.lojadalata.com/images/logo.png" title="Loja da lata"></td>

                                     </tr>
                                     

                                   </tbody></table></td>
                                   
                                 </tr>
                               </tbody></table>
                               <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                                 <tbody><tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;">
                                   <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;">
                                     <tbody><tr style="border-collapse:collapse;">
                                      <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;">
                                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                         <tbody><tr style="border-collapse:collapse;">
                                          <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                             <tbody><tr style="border-collapse:collapse;">
                                              <td align="center" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-left:35px;padding-right:35px;"><a target="_blank" href="file:///Users/richard/Desktop/pagina.html#" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\&#39;open sans\&#39;, \&#39;helvetica neue\&#39;, helvetica, arial, sans-serif;font-size:16px;text-decoration:none;color:#ED8E20;"><img src=".https://www.lojadalata.com/images/logo.png" alt="" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="120"></a></td>
                                             </tr>
                                          

                                           </tbody></table></td>
                                         </tr>
                                       </tbody></table></td>
                                     </tr>
                                   </tbody></table></td>
                                 </tr>
                               </tbody></table>
                               <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                                 <tbody><tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;">
                                   <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;">
                                     <tbody><tr style="border-collapse:collapse;">
                                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:35px;padding-right:35px;">
                                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                         <tbody><tr style="border-collapse:collapse;">
                                          <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                             <tbody><tr style="border-collapse:collapse;">

                                             </tr>
                                           </tbody></table></td>
                                         </tr>
                                       </tbody></table></td>
                                     </tr>
                                     <tr style="border-collapse:collapse;">
                                      <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;">
                                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                         <tbody><tr style="border-collapse:collapse;">

                                          <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                             <tbody><tr style="border-collapse:collapse;">
                                            
                                              <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;">
                                              <img src="http://www.lojadalata.com/images/andamento.jpg" title="Loja da lata">
                                              <h1> Caro Cliente, '.$rowInfo['nome'].' obrigado por finalizar sua compra<br/></h1>
                                             <h2> O número do seu pedido é:     #'.$_POST['id'].'<br/></h2>
                                              <h2 > Teve o status alterado para:</h2> <h1 style="color:green;"> '.$rowStatus['status'].'.</h1>
                                               <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"></table></td>
                                             </tr>
                                             <p> Loja da Lata © 2019 . Todos os direitos reservados
                                             as
                                             Política de Privacidade Termos de Uso</p>
                                             TELEVENDAS <br>

                                           contato@lojadalata.com.br
                                           </tbody></table></td>
                                         </tr>
                                       </tbody></table></td>
                                     </tr>
                                     <tr style="border-collapse:collapse;">
                                      <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px;">
                                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                         <tbody><tr style="border-collapse:collapse;">
                                          <td width="530" valign="top" align="center" style="padding:0;Margin:0;">
                                           <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE;" width="100%" cellspacing="0" cellpadding="0">
                                             <tbody><tr style="border-collapse:collapse;">

                                             </tr>
                                           </tbody></table></td>
                                         </tr>
                                       </tbody></table></td>
                                     </tr>
                                     <tr style="border-collapse:collapse;">

                                     </tr>
                                   </tbody></table></td>
                                 </tr>
                               </tbody></table>


                               <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                                 <tbody><tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;">
                                   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" align="center">
                                     <tbody><tr style="border-collapse:collapse;">
                                      <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;">
                                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                         <tbody><tr style="border-collapse:collapse;">

                                         </tr>
                                       </tbody></table></td>
                                     </tr>
                                   </tbody></table></td>
                                 </tr>
                               </tbody></table></td>
                             </tr>
                           </tbody></table>
                          </div>

                        </body></html>
            '));


            // Replace the plain text body with one created manually
            $mail->AltBody = 'Status do Pedido #'.$_POST['id'].'';

            //send the message, check for errors
            if ($mail->send()) {
              $json = array("msg"=>"Salvo com sucesso");
            } else {
              $json = array("msg"=>"Erro ao enviar email");
            }
          }else{
            $json = array("msg"=>"Erro ao alterar");

          }

        echo json_encode($json);
        ?>
