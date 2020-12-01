<?php
require_once('inc/def.php');

if($_POST['password']!=$_POST['repassword']){
  voltar('Senhas Diferentes. As senhas precisam ser exatamente iguais.');
  exit;
}
require_once('inc/hash.php');

$senha = password_encryption($_POST['password']);

$sql = 'UPDATE Users SET senha="'.$senha.'" WHERE id='.$_POST['idUser'].';';
$res = mysqli_query($link, $sql);
if($res){
  $sql = 'UPDATE RecuperaSenha SET ativo=0 WHERE id='.$_POST['id'].';';
  $res = mysqli_query($link, $sql);

  $sql = 'SELECT email , nome FROM Users WHERE id = "'.$_POST['idUser'].'";';

  $q = mysqli_query($link , $sql);
  $r = mysqli_fetch_assoc($q);

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
  $mail->addReplyTo('noreply@lojadalata.com.br', 'Loja da Lata');

  //Set who the message is to be sent to
  $mail->addAddress($r['email'], $r['nome']);

  //Set the subject line
  $mail->Subject = 'Senha Alterada com Sucesso';

  //Read an HTML message body from an external file, convert referenced images to embedded,
  //convert HTML into a basic plain-text alternative body
  //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

  $mail->msgHTML(utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>Recuperar Senha - Loja da Lata</title>


    </head>
    <body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#34373b"><style type="text/css">
  body {
  width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #34373b; color: #74787E; -webkit-text-size-adjust: none;
  }
  @media only screen and (max-width: 600px) {
    .email-body_inner {
      width: 100% !important;
    }
    .email-footer {
      width: 100% !important;
    }
  }
  @media only screen and (max-width: 500px) {
    .button {
      width: 100% !important;
    }
  }
  </style>
      <span class="preheader" style="box-sizing: border-box; display: none !important; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; mso-hide: all; opacity: 0; overflow: hidden; visibility: hidden;"></span>
      <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#34373b">
        <tr>
          <td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
            <table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
              <tr>
                <td class="email-masthead" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
                  <a href="https://example.com" class="email-masthead_name" style="box-sizing: border-box; color: #bbbfc3; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                    <img src="https://www.lojadalata.com/images/logo.png" title="Loja da lata">
                  </a>
                </td>
              </tr>

              <tr>
                <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #34373b; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
                  <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">

                    <tr>
                      <td class="content-cell" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                        <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Oi '.$r['nome'].',</h1>
                        <p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Senha Alterada com Sucesso.</p>

                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
                          <tr>
                            <td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">

                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
                                <tr>
                                  <td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
                                    <table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
                                      <tr>
                                        <td style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Se não foi você que alterou a senha por favor <a href="mailto:contato@lojadalata.com" style="box-sizing: border-box; color: #3869D4; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;">entre em contato</a>.</p>
                        <p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Obrigado,
                          <br />Time da Loja da Lata</p>

                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
                  <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                    <tr>
                      <td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                        <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">© '.date('Y').' Loja da Lata. Todos Direitos Reservados.</p>
                        <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">
                          Loja da Lata, LDL
                          <br />Rua Robert Bosh, 450.
                          <br />Barra Funda, São Paulo, SP, 01141-010
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </body>
  </html>
'));


  // Replace the plain text body with one created manually
  $mail->AltBody = 'Senha Alterada com Sucesso';

  //send the message, check for errors
  if (!$mail->send()) {
  //    echo "Mailer Error: " . $mail->ErrorInfo;
    voltar('Erro ao enviar Email.');

  } else {

    ir($site,'Senha atualizada.');

  }
}else{
  voltar('Erro ao alterar a senha. Tente Novamente');
}
