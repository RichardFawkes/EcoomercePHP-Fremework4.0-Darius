<?php
require_once('inc/def.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once('inc/recaptchalib.php');

// definir a chave secreta
$secret = "6LccCL0UAAAAAOnTvCnltc6AYVJ5dEGpF6KaZZMy";

// verificar a chave secreta
$response = null;
$reCaptcha = new ReCaptcha($secret);

if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
}

// deu tudo certo?
if ($response != null && $response->success) {
    // processar o formulario
  if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

    $sql = 'INSERT INTO Contatos (nome, email, telefone, assunto, mensagem, dataHora, ip, local_entrega, produto, quantidade, tipo, envazado, tamanho)
    VALUES ("'.addslashes($_POST['nome']).'","'.addslashes($_POST['email']).'","'.addslashes($_POST['telefone']).'","'.addslashes($_POST['assunto']).'",
    "'.addslashes($_POST['descricao']).'",NOW(),"'.$_SERVER['REMOTE_ADDR'].'","'.addslashes($_POST['local_entrega']).'","'.addslashes($_POST['produto']).'",
    "'.addslashes($_POST['quantidade']).'","'.addslashes($_POST['tipo']).'","'.addslashes($_POST['envazado']).'","'.addslashes($_POST['tamanho']).'");';
    $q = mysqli_query($link , $sql);

    if($_POST['local_entrega']!=""){
      $local = '<p><b>Local da Entrega:</b> '.$_POST['local_entrega'].' </p>';
      $local2 = 'Local da Entrega: '.$_POST['local_entrega'].' ';
    }else{
      $local = '';
      $local2 = '';
    }

    if($_POST['produto']!=""){
      $produto = '<p><b>Produto:</b> '.$_POST['produto'].' </p>';
      $produto2 = 'Produto: '.$_POST['produto'].' ';
    }else{
      $produto = '';
      $produto2 = '';
    }

    if($_POST['quantidade']!=""){
      $quantidade = '<p><b>Quantidade:</b> '.$_POST['quantidade'].' </p>';
      $quantidade2 = 'Quantidade: '.$_POST['quantidade'].' ';
    }else{
      $quantidade = '';
      $quantidade2 = '';
    }

    if($_POST['tipo']!=""){
      $tipo = '<p><b>Tipo do Produto:</b> '.$_POST['tipo'].' </p>';
      $tipo2 = 'Tipo do Produto: '.$_POST['tipo'].' ';
    }else{
      $tipo = '';
      $tipo2 = '';
    }

    if($_POST['envazado']!=""){
      $envazado = '<p><b>Produto a ser envazado:</b> '.$_POST['envazado'].' </p>';
      $envazado2 = 'Produto a ser envazado: '.$_POST['envazado'].' ';
    }else{
      $envazado = '';
      $envazado2 = '';
    }

    if($_POST['tamanho']!=""){
      $tamanho = '<p><b>Tamanho:</b> '.$_POST['tamanho'].' </p>';
      $tamanho2 = 'Tamanho: '.$_POST['tamanho'].' ';
    }else{
      $tamanho = '';
      $tamanho2 = '';
    }

    if($q){
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
      $mail->addReplyTo($_POST['email'], $_POST['nome']);

      $sqlInfos = 'SELECT valor FROM Configuracao WHERE chave="email"';
      $resInfos = mysqli_query($link, $sqlInfos);
      $rowInfos = mysqli_fetch_array($resInfos);

      //Set who the message is to be sent to
      $mail->addAddress($rowInfos['valor'], 'Contato');

      $sqlInfos2 = 'SELECT valor FROM Configuracao WHERE chave="trello"';
      $resInfos2 = mysqli_query($link, $sqlInfos2);
      $rowInfos2 = mysqli_fetch_array($resInfos2);
      $mail->AddBCC($rowInfos2['valor'], 'Trello');

      //Set the subject line
      $mail->Subject = utf8_decode('Contato Enviado ('.$_POST['assunto'].' - '.$_POST['nome'].')');

      //Read an HTML message body from an external file, convert referenced images to embedded,
      //convert HTML into a basic plain-text alternative body
      //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

      $mail->msgHTML(utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <title>Contato - Loja da Lata</title>


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
                      <a href="https://www.lojadalata.com" class="email-masthead_name" style="box-sizing: border-box; color: #bbbfc3; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                        <img src="https://www.lojadalata.com/images/logo.png" title="Loja da lata">
                      </a>
                    </td>
                  </tr>

                  <tr>
                    <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #34373b; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
                      <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">

                        <tr>
                          <td class="content-cell" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                            <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Contato Enviado pelo site.</h1>
                            <p style="box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left"><strong style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;"></strong></p>

                            <p><b>Nome:</b> '.$_POST['nome'].' </p>
                            <p><b>Email:</b> '.$_POST['email'].' </p>
                            <p><b>Telefone:</b> '.$_POST['telefone'].' </p>
                            <p><b>Assunto:</b> '.$_POST['assunto'].' </p>
                            <p><b>Mensagem:</b> '.$_POST['descricao'].' </p>
                            '.$local.'
                            '.$produto.'
                            '.$tamanho.'
                            '.$quantidade.'
                            '.$tipo.'
                            '.$envazado.'

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
      $mail->AltBody = 'Nome: '.$_POST['nome'].'
                        Email: '.$_POST['email'].'
                        Telefone: '.$_POST['telefone'].'
                        Assunto: '.$_POST['assunto'].'
                        Mensagem: '.$_POST['descricao'].'
                        '.$local2.'
                        '.$produto2.'
                        '.$tamanho2.'
                        '.$quantidade2.'
                        '.$tipo2.'
                        '.$envazado2.'';

      //send the message, check for errors
      if (!$mail->send()) {
         // echo "Mailer Error: " . $mail->ErrorInfo;
        voltar('Erro ao enviar Email.');
      } else {
        ir($site.'contato','Email enviado com sucesso.');
      }
    }else{
      voltar('Erro ao salvar Contato.');
    }


  }else{
    voltar('Email inválido.');
  }

}else{
  voltar('Captcha inválido.');
}
