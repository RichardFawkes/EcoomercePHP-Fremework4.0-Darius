<?php
require_once('inc/def.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'inc/PHPMailerNew/src/Exception.php';
require 'inc/PHPMailerNew/src/PHPMailer.php';
require 'inc/PHPMailerNew/src/SMTP.php';

// require_once('inc/recaptchalib.php');
//
// // definir a chave secreta
// $secret = "6LccCL0UAAAAAOnTvCnltc6AYVJ5dEGpF6KaZZMy";
//
// // verificar a chave secreta
// $response = null;
// $reCaptcha = new ReCaptcha($secret);
//
// if ($_POST["g-recaptcha-response"]) {
//     $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
// }
//
// // deu tudo certo?
// if ($response != null && $response->success) {
//     // processar o formulario
  if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

    // $sql = 'INSERT INTO Contatos (nome, email, telefone, assunto, mensagem, dataHora, ip, local_entrega, produto, quantidade, tipo, envazado, tamanho)
    // VALUES ("'.addslashes($_POST['nome']).'","'.addslashes($_POST['email']).'","'.addslashes($_POST['telefone']).'","'.addslashes($_POST['assunto']).'",
    // "'.addslashes($_POST['descricao']).'",NOW(),"'.$_SERVER['REMOTE_ADDR'].'","'.addslashes($_POST['local_entrega']).'","'.addslashes($_POST['produto']).'",
    // "'.addslashes($_POST['quantidade']).'","'.addslashes($_POST['tipo']).'","'.addslashes($_POST['envazado']).'","'.addslashes($_POST['tamanho']).'");';
    // $q = mysqli_query($link , $sql);
    //
    // if($_POST['local_entrega']!=""){
    //   $local = '<p><b>Local da Entrega:</b> '.$_POST['local_entrega'].' </p>';
    //   $local2 = 'Local da Entrega: '.$_POST['local_entrega'].' ';
    // }else{
    //   $local = '';
    //   $local2 = '';
    // }
    //
    // if($_POST['produto']!=""){
    //   $produto = '<p><b>Produto:</b> '.$_POST['produto'].' </p>';
    //   $produto2 = 'Produto: '.$_POST['produto'].' ';
    // }else{
    //   $produto = '';
    //   $produto2 = '';
    // }
    //
    // if($_POST['quantidade']!=""){
    //   $quantidade = '<p><b>Quantidade:</b> '.$_POST['quantidade'].' </p>';
    //   $quantidade2 = 'Quantidade: '.$_POST['quantidade'].' ';
    // }else{
    //   $quantidade = '';
    //   $quantidade2 = '';
    // }
    //
    // if($_POST['tipo']!=""){
    //   $tipo = '<p><b>Tipo do Produto:</b> '.$_POST['tipo'].' </p>';
    //   $tipo2 = 'Tipo do Produto: '.$_POST['tipo'].' ';
    // }else{
    //   $tipo = '';
    //   $tipo2 = '';
    // }
    //
    // if($_POST['envazado']!=""){
    //   $envazado = '<p><b>Produto a ser envazado:</b> '.$_POST['envazado'].' </p>';
    //   $envazado2 = 'Produto a ser envazado: '.$_POST['envazado'].' ';
    // }else{
    //   $envazado = '';
    //   $envazado2 = '';
    // }
    //
    // if($_POST['tamanho']!=""){
    //   $tamanho = '<p><b>Tamanho:</b> '.$_POST['tamanho'].' </p>';
    //   $tamanho2 = 'Tamanho: '.$_POST['tamanho'].' ';
    // }else{
    //   $tamanho = '';
    //   $tamanho2 = '';
    // }

    // if($q){

      date_default_timezone_set('Etc/UTC');
      //Create a new PHPMailer instance
      $mail = new PHPMailer(true);

      //Tell PHPMailer to use SMTP
      $mail->isSMTP();

      //Enable SMTP debugging
      // 0 = off (for production use)
      // 1 = client messages
      // 2 = client and server messages
      $mail->SMTPDebug = 2;

      //Ask for HTML-friendly debug output
      $mail->Debugoutput = 'html';

      //Set the hostname of the mail server
      $mail->Host = 'smtp.office365.com';
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
      $mail->Username = "contato@lojadalata.com.br";

      //Password to use for SMTP authentication
      $mail->Password = "lata@2019";

      //Set who the message is to be sent from
      $mail->setFrom('contato@lojadalata.com.br', 'Loja da Lata');

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
      $mail->IsHTML(true);
      $mail->msgHTML(utf8_decode('TESTE OK'));


      // Replace the plain text body with one created manually
      $mail->AltBody = 'teste';

      //send the message, check for errors
      if (!$mail->send()) {
         echo "Mailer Error: " . $mail->ErrorInfo;
        // voltar('Erro ao enviar Email.');
      } else {
        ir($site.'contato','Email enviado com sucesso.');
      }
    // }else{
    //   voltar('Erro ao salvar Contato.');
    // }


  }else{
    voltar('Email inválido.');
  }

// }else{
//   voltar('Captcha inválido.');
// }
