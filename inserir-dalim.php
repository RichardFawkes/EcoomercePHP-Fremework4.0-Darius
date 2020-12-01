<?php

require_once('inc/def.php');
$idCompra = $_GET['pedido'];
?>




          <?php


date_default_timezone_set('America/Sao_Paulo');

echo date('d/m/Y \à\s H:i:s');
             
            

                  
  //CREATE JOB
  $sqlcou = 'SET @row_number=0;';
  $sqldalim = 'SELECT (@row_number:=@row_number + 1) id ,p.titulo,d.idCompra,d.qtde,d.idProjeto,u.nome,cor.cor, (NOW()+INTERVAL p.prazo_producao day)data   FROM Compras_X_Produtos d
  JOIN Compras c ON c.id = d.idCompra
  JOIN Users u ON u.id = c.idUser
  JOIN Cores cor ON cor.id = d.idCorTampa
  JOIN Produtos p ON d.idProduto = p.id
  WHERE idCompra = "'.$idCompra.'" AND p.mostra_3d = 1';
  
  mysqli_query($link,$sqlcou);

  
  $qd = mysqli_query($link, $sqldalim);
  
  $url = 'http://lojadalata.brasilata.com.br/Esprit/public/Interface/rpc';
  $username = 'admin';
  $senha = 'lata@2020';

  while($r = mysqli_fetch_assoc($qd)){


      //create a new cURL resource
      $ch = curl_init($url);
      
      //setup request to send json via POST
  
      
      $json2 ='[
          {"id": 1, "method": "admin.login"}, 
          {"id": 2, "method": "job.create", "params":
          {"customerName":"lojadalata.com", "jobName":"PEDIDO #'.$idCompra.'-item-'.$r['id'].'", "projectTemplateName":"74", "roles": [{user:"richard.geraldo@lojadalata.com.br",role:"Creator"}]
          }
          },
          
          
          {"id": 1, "method": "admin.logout"}
          
     ]';
     
           
    
  
  
  
  
       $payload = $json2;
    
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); //DOCUMENT
  
      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
          'Content-Type:application/json'));
      
      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      //execute the POST request
     $results = curl_exec($ch);
  
      // exit;
      //close cURL resource
      curl_close($ch);

  
    

    
    
    
    //CREATE CORPO DOCUMENTE 
 

    $chs = curl_init($url);
    
    //setup request to send json via POST
    $json3 ='[
      {"id": 1, "method": "admin.login"}, 
      {"id":2, "method":"document.create", 
      "params":{
      "jobPath": "/lojadalata.com/PEDIDO #'.$idCompra.'-item-'.$r['id'].'", 
      "name": "Corpo'.$r['idProjeto'].'.pdf", 
      "URL": "https://lojadalata.com/api/P'.$r['idProjeto'].'.1.pdf",
      "documentWorkflow":"WFL_SiteLDL",
      "moveFile": "false",
      "metadatas":[["LDL","Nome_Cliente","'.$rd['nome'].'"],["LDL","ID_Pedido_Site","'.$idCompra.'"],["LDL","Item","'.$rd['titulo'].'"],["LDL","cor_tampa","'.$rd['cor'].'"],["LDL","prazo_prod","'.$rd['data'].'"],["LDL","qtd","'.$rd['qtde'].'"]]

  }

},
{"id": 1, "method": "admin.logout"}
]

      
      
      ';
 

    $payload3 = $json3;
    //attach encoded JSON string to the POST fields
    curl_setopt($chs, CURLOPT_POSTFIELDS, $payload3);

    //set the content type to application/json
    curl_setopt($chs, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
   $results = curl_exec($chs);
   
    // exit;
    //close cURL resource
    curl_close($chs);






    //CRIAR DOCUMENT TAMPA 

    $chz = curl_init($url);
    
    $json2 ='[
        {"id": 1, "method": "admin.login"}, 
        {"id":2, "method":"document.create", 
        "params":{
        "jobPath": "/lojadalata.com/PEDIDO #'.$idCompra.'-item-'.$r['id'].'", 
        "name": "Tampa'.$r['idProjeto'].'.pdf", 
        "URL": "https://lojadalata.com/api/P'.$r['idProjeto'].'.2.pdf",
        "documentWorkflow":"WFL_SiteLDL",
        "moveFile": "false"
    }

},
	{"id": 1, "method": "admin.logout"}
]

        
        
        ';
   


    $payload2 = $json2;
    //attach encoded JSON string to the POST fields
    curl_setopt($chz, CURLOPT_POSTFIELDS, $payload2);

    //set the content type to application/json
    curl_setopt($chz, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
        'Content-Type:application/json'));
    
    //return response instead of outputting
    curl_setopt($chz, CURLOPT_RETURNTRANSFER, true);
    
    //execute the POST request
   $results = curl_exec($chz);
   
    // exit;
    //close cURL resource
    curl_close($chz);
    // echo $results;

    }


  
//FIM DOCUMENT CREATE DALIM


//FINAL API DALIM






            echo '<h1> Pedido foi enviado para dalim com sucesso!</h1>
            <h3>
            Número do Pedido: <a style="color=#4bb777; "><strong>#00'.$idCompra.'</strong></a><br></h3>
            </h4>';

           ?>
         
         


    







