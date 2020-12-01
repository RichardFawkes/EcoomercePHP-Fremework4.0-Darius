<?php

require_once('../../inc/def.php');



$username = 'richard';
$senha = '26040604';

$url = 'http://10.1.5.6/Esprit/public/Interface/rpc';


    //create a new cURL resource
    $ch = curl_init($url);
    
    //setup request to send json via POST
    $json ='[
        {"id": 1, "method": "admin.login"}, 
        {"id": 2, "method": "job.create", "params":
        {"customerName":"lojadalata.com", "jobName":"PEDIDO #234", "projectTemplateName":"74", "roles": [{user:"richard.geraldo@lojadalata.com",role:"Creator"}],
        "metadatas":[["LDL","Nome_Cliente","Richard Geraldo"],["LDL","ID_Pedido_Site","233"]]}
        
        },
        
        
        {"id": 7, "method": "admin.logout"}
        
   ]';
   


    $payload = $json;
    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
   $results = curl_exec($ch);
   var_dump($results);
    // exit;
    //close cURL resource
    curl_close($ch);
?>