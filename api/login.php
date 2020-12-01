<?php


 
    $idUser = $_SESSION['idUser'];


    $sql = 'SELECT nome, email, id FROM Users WHERE id = '.$idUser;
    
    $q = mysqli_query($link , $sql);
    $r = mysqli_fetch_array($q);


    $nome = $r['nome'];
    $email = $r['email'];
    $id    =$r['id'];


    // login api printnow
    $token = '9F3D85FD4F090049BB298E479056BB67';
    $key = 'E8024D21A2B9A5785CEFB28AAA538E820EF50DAA2D0A1582AA5CBE545E8A4E64';
    
    
    //url endpoint
    $url = 'https://api.printnow.com/api/v1/pipo/user/login';

   
    //create a new cURL resource
    $ch = curl_init($url);
    
    //requesicao via post
    $data = array(
        'username' => $nome,
        'password' => 'lojadalata',
        'storefront_id' => '1'
    );
    $payload = json_encode($data);
    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    
    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $token . ':' . $key),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
    $result = curl_exec($ch);
  
if($result == '{"Message":"An error has occurred."}')
$tokeuser = '';
elseif($result == '{"Message":"token is invalid or expired"}'){

    header('Location:'.$site.'index-login');


}
else{ 
   
    $tokeuser = $result;


}

    
    //close cURL resource
    curl_close($ch);

?>