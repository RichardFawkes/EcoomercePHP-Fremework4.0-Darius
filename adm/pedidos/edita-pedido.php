<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_resultado.php");
require_once($siteHD.'header2.php');



// ATUALIZA DADOS CLIENTE
$sqlmanual = 'UPDATE Pedidos_Manual SET nomecliente = "'.$_POST['nomerazao'].'", codtotvs = "'.$_POST['codtotvs'].'", cpfcnpj = "'.$_POST['cpf'].'",inscricoes = "'.$_POST['inscricaoestadual'].'",email = "'.$_POST['email'].'", tel = "'.$_POST['tel'].'", endereco = "'.$_POST['endereco'].'",bairro = "'.$_POST['bairro'].'",cep = "'.$_POST['cep'].'",cidade = "'.$_POST['cidade'].'",uf = "'.$_POST['uf'].'" WHERE idCompra = "'.$_POST['idPedido'].'"';

mysqli_query($link, $sqlmanual);





// ATUALIZA DADOS ENTREGA
$sqlentrega = 'UPDATE Pedidos_Manual_Dados_Entrega SET nomerazao = "'.$_POST['1nomerazao'].'", codtotvs = "'.$_POST['1codtotvs'].'", cpf = "'.$_POST['1cpf'].'",inscricaoes = "'.$_POST['1inscricaoes'].'",email = "'.$_POST['1email'].'", tel = "'.$_POST['1tel'].'", endereco = "'.$_POST['1endereco'].'",bairro = "'.$_POST['1bairro'].'",cep = "'.$_POST['1cep'].'",cidade = "'.$_POST['1cidade'].'",uf = "'.$_POST['1uf'].'" WHERE idCompra = "'.$_POST['idPedido'].'"';

mysqli_query($link, $sqlentrega);


// A
$sqlpagamento = 'INSERT INTO Pedidos_Manual_Dados_Pagamento (idCompra,metodo,condicaopag,trasporte,previsaoentrega)

VALUES("'.$idCompra.'","'.$_POST['metodo'].'","'.$_POST['condipag'].'","'.$_POST['trasporte'].'","'.$_POST['previentrega'].'")';


mysqli_query($link, $sqlpagamento);





//insercao produto

if($_POST['produto'] == null){
}else{

    $sql='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total,obs,dataHora,cidade,email,resultatototal,qtdtotal,frete)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'","'.$_POST['produto'].'","'.$_POST['tamanho'].'","'.$_POST['cortampa'].'","'.$_POST['qtd'].'","'.$_POST['verniz'].'","'.$_POST['base'].'","'.$_POST['person'].'","'.$_POST['unit'].'","'.$_POST['total'].'","'.$_POST['obs'].'",NOW(),"'.$_POST['cidade'].'","'.$_POST['email'].'","'.$_POST['resultadototal'].'","'.$_POST['qtdtotal'].'","'.$_POST['frete'].'");
    ';
    
    
    
    mysqli_query($link, $sql);
    

}

if($_POST['1produto'] == null){
}else{
    $sql1='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total,obs,dataHora,cidade,email,resultatototal,qtdtotal,frete)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'","'.$_POST['1produto'].'","'.$_POST['1tamanho'].'","'.$_POST['1cortampa'].'","'.$_POST['1qtd'].'","'.$_POST['1verniz'].'","'.$_POST['1base'].'","'.$_POST['1person'].'","'.$_POST['1unit'].'","'.$_POST['1total'].'","'.$_POST['obs'].'",NOW(),"'.$_POST['cidade'].'","'.$_POST['email'].'","'.$_POST['resultadototal'].'","'.$_POST['qtdtotal'].'","'.$_POST['frete'].'");
    ';
    
    
    mysqli_query($link, $sql1);
    

}

if($_POST['2produto'] == null){
}else{
    $sql2='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total,obs,dataHora,cidade,email,resultatototal,qtdtotal,frete)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'","'.$_POST['2produto'].'","'.$_POST['2tamanho'].'","'.$_POST['2cortampa'].'","'.$_POST['2qtd'].'","'.$_POST['2verniz'].'","'.$_POST['2base'].'","'.$_POST['2person'].'","'.$_POST['2unit'].'","'.$_POST['2total'].'","'.$_POST['obs'].'",NOW(),"'.$_POST['cidade'].'","'.$_POST['email'].'","'.$_POST['resultadototal'].'","'.$_POST['qtdtotal'].'","'.$_POST['frete'].'");
    ';
    
    
    mysqli_query($link, $sql2);
    

}
if($_POST['3produto'] == null){
}else{
    $sql3='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total,obs,dataHora,cidade,email,resultatototal,qtdtotal,frete)

VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'","'.$_POST['3produto'].'","'.$_POST['3tamanho'].'","'.$_POST['3cortampa'].'","'.$_POST['3qtd'].'","'.$_POST['3verniz'].'","'.$_POST['3base'].'","'.$_POST['3person'].'","'.$_POST['3unit'].'","'.$_POST['3total'].'","'.$_POST['obs'].'",NOW(),"'.$_POST['cidade'].'","'.$_POST['email'].'","'.$_POST['resultadototal'].'","'.$_POST['qtdtotal'].'","'.$_POST['frete'].'");
    ';
    
    
    
    mysqli_query($link, $sql3);
    

}

if($_POST['4produto'] == null){
}else{
    $sql4='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['1cpf'].'", "'.$_POST['4produto'].'","'.$_POST['4tamanho'].'","'.$_POST['4cortampa'].'","'.$_POST['4qtd'].'","'.$_POST['4verniz'].'","'.$_POST['4base'].'","'.$_POST['4person'].'","'.$_POST['4unit'].'","'.$_POST['4total'].'")
    ';
    
    
    
    mysqli_query($link, $sql4);
    

}


if($_POST['5produto'] == null){
}else{
    $sql5='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'", "'.$_POST['5produto'].'","'.$_POST['5tamanho'].'","'.$_POST['5cortampa'].'","'.$_POST['5qtd'].'","'.$_POST['5verniz'].'","'.$_POST['5base'].'","'.$_POST['5person'].'","'.$_POST['5unit'].'","'.$_POST['5total'].'")
    ';
    
    
    
    mysqli_query($link, $sql5);
    

}

if($_POST['6produto'] == null){
}else{
    $sql6='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'", "'.$_POST['6produto'].'","'.$_POST['6tamanho'].'","'.$_POST['6cortampa'].'","'.$_POST['6qtd'].'","'.$_POST['6verniz'].'","'.$_POST['6base'].'","'.$_POST['6person'].'","'.$_POST['6unit'].'","'.$_POST['6total'].'")
    ';
    
    
    
    mysqli_query($link, $sql6);
    

}
if($_POST['7produto'] == null){
}else{
    $sql6='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['1nomerazao'].'","'.$_POST['cpf'].'", "'.$_POST['7produto'].'","'.$_POST['7tamanho'].'","'.$_POST['7cortampa'].'","'.$_POST['7qtd'].'","'.$_POST['7verniz'].'","'.$_POST['7base'].'","'.$_POST['7person'].'","'.$_POST['7unit'].'","'.$_POST['7total'].'")
    ';
    
    
    
    mysqli_query($link, $sql7);
    

}



if($_POST['8produto'] == null){
}else{
    $sql8='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'", "'.$_POST['8produto'].'","'.$_POST['8tamanho'].'","'.$_POST['8cortampa'].'","'.$_POST['8qtd'].'","'.$_POST['8verniz'].'","'.$_POST['8base'].'","'.$_POST['8person'].'","'.$_POST['8unit'].'","'.$_POST['8total'].'")
    ';
    
    
    
    mysqli_query($link, $sql8);
    

}



if($_POST['9produto'] == null){
}else{
    $sql9='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'", "'.$_POST['9produto'].'","'.$_POST['9tamanho'].'","'.$_POST['9cortampa'].'","'.$_POST['9qtd'].'","'.$_POST['9verniz'].'","'.$_POST['9base'].'","'.$_POST['9person'].'","'.$_POST['9unit'].'","'.$_POST['9total'].'")
    ';
    
    
    
    mysqli_query($link, $sql9);
    

}


if($_POST['10produto'] == null){
}else{
    $sql10='INSERT INTO Pedidos_Manual (idCompra,nomecliente,cpfcnpj,produto,tamanho,cortampa,qtd,verniz,base,person,unit,total)

    VALUES ("'.$idCompra.'","'.$_POST['nomerazao'].'","'.$_POST['cpf'].'", "'.$_POST['10produto'].'","'.$_POST['10tamanho'].'","'.$_POST['10cortampa'].'","'.$_POST['10qtd'].'","'.$_POST['10verniz'].'","'.$_POST['10base'].'","'.$_POST['10person'].'","'.$_POST['10unit'].'","'.$_POST['10total'].'",)
    ';
    
    
    
    mysqli_query($link, $sql10);
    

}





// COMENTADO APARTI DAQUI


// //CREATE JOB
// $sqlcouz = 'SET @row_number=0;';
// $sqldalim = 'SELECT *,(@row_number:=@row_number + 1) ids FROM Pedidos_Manual WHERE idCompra = "'.$idCompra.'"';

// mysqli_query($link,$sqlcouz);
  
// $qd = mysqli_query($link, $sqldalim);


// while($r = mysqli_fetch_assoc($qd)){

// $username = 'admin';
// $senha = 'lata@2020';

// $url = 'http://lojadalata.brasilata.com.br/Esprit/public/Interface/rpc';


//     //create a new cURL resource
//     $ch = curl_init($url);
    
//     //setup request to send json via POST

    
//     $json ='[
//         {"id": 1, "method": "admin.login"}, 
//         {"id": 2, "method": "job.create", "params":
//         {"customerName":"lojadalata.com", "jobName":"PEDIDO #'.$r['idCompra'].'-item-'.$r['ids'].'", "projectTemplateName":"74", "roles": [{user:"richard.geraldo@lojadalata.com.br",role:"Creator"}],
//         "metadatas":[["LDL","Nome_Cliente","'.$r['nomecliente'].'"],["LDL","ID_Pedido_Site","'.$r['idCompra'].'"],["LDL","Produto","'.$r['produto'].'"],["LDL","qtd","'.$r['qtd'].'"],["LDL","cor_tampa","'.$r['cortampa'].'"],["LDL","Verniz","'.$r['verniz'].'"],["LDL","Tamanho","'.$r['tamanho'].'"],["LDL","Base","'.$r['base'].'"],["LDL","Personalizacao","'.$r['person'].'"],["LDL","OBS","'.$r['obs'].'"]]

//         }
//         },
        
        
//         {"id": 7, "method": "admin.logout"}
        
//    ]';
   
         
  




//      $payload = $json;
  
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); //DOCUMENT

//     //set the content type to application/json
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         'Authorization: Basic ' . base64_encode( $username . ':' . $senha),
//         'Content-Type:application/json'));
    
//     //return response instead of outputting
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
//     //execute the POST request
//    $results = curl_exec($ch);

//     // exit;
//     //close cURL resource
//     curl_close($ch);

//   }

  
// //   echo    $results;
 


// //FINAL API DALIM







echo'<br<br><br<br><br<br><br<br><br<br><br<br>';
require_once($siteHD.'adm/rodape.php');
require_once($siteHD.'adm/js.php');

voltar();

?>
