<?php

require_once('../inc/def.php');
include('login.php');



   // define some variables
   $local_file = 'P'.$_GET['id'].'.1.pdf';
   $local_file2 = 'P'.$_GET['id'].'.2.pdf';

   $server_file = './Order '.$_GET['order'].'/Product '.$_GET['id'].'/P'.$_GET['id'].'.1.pdf';
   $server_file2 = './Order '.$_GET['order'].'/Product '.$_GET['id'].'/P'.$_GET['id'].'.2.pdf';
   $ftp_server="204.145.90.95";
   $ftp_user_name="dalim";
   $ftp_porta="22";
   $ftp_user_pass="lata@2020";
   
   $conn_id = ftp_ssl_connect($ftp_server,$ftp_porta);
   
   // login with username and password
   $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
   
   // turn passive mode on
   ftp_pasv($conn_id, true);
   
   // try to download $server_file and save to $local_file
   if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
      ftp_get($conn_id, $local_file2, $server_file2, FTP_BINARY);
    header('Location:'.$site.'produtou/'.$_GET['url'].'?id='.$_GET['id'].'');
    
   }
   else {
    header('Location:'.$site.'api/ftpdow.php?order='.$_GET['order'].'&id='.$_GET['id'].'&url='.$_GET['url'].'');

   }
   // close the connection
   ftp_close($conn_id);


//redirect thumbnail project printnow
 

?>