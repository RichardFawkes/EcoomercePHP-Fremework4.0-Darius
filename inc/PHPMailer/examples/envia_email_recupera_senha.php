<?php



/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

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
$mail->Username = "puratos.esqueci.minha.senha@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "puratos.esqueci.minha.senha2017";

//Set who the message is to be sent from
$mail->setFrom('puratos.esqueci.minha.senha@gmail.com', 'Puratos Brasil');

//Set an alternative reply-to address
$mail->addReplyTo('puratos.esqueci.minha.senha@gmail.com', 'Puratos Brasil');

//Set who the message is to be sent to
$mail->addAddress($_GET['email'], $_GET['nome']);

//Set the subject line
$mail->Subject = 'Esqueceu sua senha?i';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

$mail->msgHTML('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Puratos Brasil</title>
</head>
<body>
<div style="width: 700px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
	<img src="http://209.126.103.137/Puratos/img/testeiras/header1.png" width="700" height="121"><br>
  <h1>Recuperar Senha</h1>
  <div align="left">
    Esqueceu sua senha? <a href="http://209.126.103.137/Puratos/senha/recuperar-senha.php?parrs="'.$_GET['URL_aleatoria'].'">Clique aqui</a> para criar uma nova.
    <p style="font-size:9px; color: #AAAAAA;">OBS: Se você não pretende recuperar sua senha Puratos, por favor desconsidere este emai</p>
  </div>
</div>
</body>
</html>');


//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
