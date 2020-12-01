<?php
require_once('inc/def.php');
header('Content-Type: application/json');
libera_acessoSite(1,2,3,4,5);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$upd = 'UPDATE Compras_X_Produtos SET idCorTampa='.$_POST['status'].' WHERE id ='.$_POST['id'].';';
$q = mysqli_query($link,$upd);


          
           echo $_POST['status'];
           echo $_POST['id'];
          
         
      
            
           header("Location: ".$site."minhas-compras");
          

        ?>
