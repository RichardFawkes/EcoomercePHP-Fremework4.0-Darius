<?php

function verProjeto(){
ob_start();

$token = '9F3D85FD4F090049BB298E479056BB67';
$key = 'E8024D21A2B9A5785CEFB28AAA538E820EF50DAA2D0A1582AA5CBE545E8A4E64';
$tokeuser = '58474ecddef4471bb07a591c733f19af28e15921571c4e31bf80846c6cbd4949';

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, 'https://api.printnow.com/api/v1/pipo/project/all' ); 
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(    'Authorization: Basic ' . base64_encode( $token . ':' . $key),
	
'X-PN-TOKEN: '.$tokeuser,

'Content-Type: application/json',

 ) );
curl_exec( $ch );
$resposta = ob_get_contents();
ob_end_clean();
$httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
$jsonRet = json_decode(curl_exec($ch));

curl_close( $ch );

header("Content-Type: text/html; charset=utf8");
echo "$httpCode<br>$jsonRet";

}

verProjeto();