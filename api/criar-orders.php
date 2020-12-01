<?php

    include('login.php');
   
   
    $token = '9F3D85FD4F090049BB298E479056BB67';
    $key = 'E8024D21A2B9A5785CEFB28AAA538E820EF50DAA2D0A1582AA5CBE545E8A4E64';
    // $tokeuser = '9734545f87f142b0b184bdde260bd1e0511e1fe1bf08426a856f273b91292d28';
    $url = 'https://api.printnow.com/api/v1/pipo/order/create';

    $id = $_GET['productid'];
    $epi = $_GET['epi'];

    //create a new cURL resource
    $ch = curl_init($url);
    
    //setup request to send json via POST
    $data = array(
        'product_id' => [$id],
        'external_id' => [$epi]
    );
   


    $payload = json_encode($data);
    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $token . ':' . $key),
         'X-PN-TOKEN: '.json_decode($tokeuser) ,
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
    $result = curl_exec($ch);
    // var_dump($result);
    // exit;
    //close cURL resource
    curl_close($ch);
    
?>




