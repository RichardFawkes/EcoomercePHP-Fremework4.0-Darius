     <?php
require_once('../../inc/def.php');
libera_acesso(1);




?>



<?php

     $sql4= 'SELECT * From PrecosQuantidades WHERE idProduto='.$_POST['idproduct'].' ORDER BY qtde ASC;';

      $res3 = mysqli_query($link, $sql4);
      $row3 = mysqli_fetch_array($res3);
      
  

      $a = mysqli_fetch_assoc($res3);
      $b = mysqli_fetch_assoc($res3);
      $c = mysqli_fetch_assoc($res3);
      $d = mysqli_fetch_assoc($res3);
      $e = mysqli_fetch_assoc($res3);
      $f = mysqli_fetch_assoc($res3);
      $g = mysqli_fetch_assoc($res3);
  

      $sql5 = 'DELETE * From PrecosQuantidades WHERE '.$_POST['idproduct'].' AND id='.$_POST['id'].' ;';
      $delete = mysqli_query($link, $sql5);



    
   
      
    ?>       

           
         
     <!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <meta http-equiv="X-UA-Compatible" content="ie=edge">
         <title>Document</title>
     </head>
     <body>
     <div class="card-box">
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">
     <div class="form-group col-12">
            
           </div>
           <div class="form-group col-md-4">
             <label>ID PRODUTO <span title="Valor a ser cobrado do cliente" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
             <input type="text" placeholder="ID PRODUTO" class="form-control money" name="idproduct" required value='<?php echo $_POST['idproduct'] ?>'  ?>
           </div>

           

<div class="card">
<h3 class="card-header text-center font-weight-bold text-uppercase py-4">Tabela Precos</h3>
<div class="card-body">
 <div id="table" class="table-editable">

   <table class="table table-bordered table-responsive-md table-striped text-center">
     <thead>
       <tr>
         <th class="text-center">QTD</th>
         <th class="text-center">PRECO QTD</th>
         <th class="text-center">REMOVER</th> 
       </tr>
     </thead>
     <tbody>
       <tr>
         <td> <input type="text" placeholder="QUANTIDADE" class="form-control" name="qtdep" required value=" <?php echo $row2['qtdep'] ?>" ></td>
         <td><input type="text" placeholder="PRECO UNITARIO QTD" class="form-control money" name="valorUnitario" value="<?php echo $row2['valorUnitario']  ?>"></td>
         
         <td>
         <input type="submit" class="btn btn-success" value="Cadastrar"/>         
         </td>
       </tr>
       <!-- This is our clonable table line -->
       <tr>

         <td class="pt-3-half" contenteditable="true"><?php echo $row3['qtde'] ?></td>

         <td class="pt-3-half" contenteditable="true"><?php echo $row3['valorUnitario'] ?></td>
      
         <td>
         </form>
 <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="rowid" value='.$row3['id'].'></td>
    </form>';
?>
</td>
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">

         </td>
       </tr>
       <!-- This is our clonable table line -->
       <tr>
    

         <td class="pt-3-half" contenteditable="true"><?php echo $a['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $a['valorUnitario'] ?></td>

         <td>
         </form>
         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="aid" value='.$a['id'].'></td>
    </form>';
?>
</td>
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">

         <tr>
         <td class="pt-3-half" contenteditable="true"><?php echo $b['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $b['valorUnitario'] ?></td>
        <td>
         </form>

         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="bid" value='.$b['id'].'></td>
    </form>';
?>
</td>
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">

         <tr>
         <td class="pt-3-half" contenteditable="true"><?php echo $c['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $c['valorUnitario'] ?></td>

         <td>
         </form>
         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="cid" value='.$c['id'].'></td>
    </form>';
?>
</td>
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">


         </td>
         <tr>
         <td class="pt-3-half" contenteditable="true"><?php echo $d['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $d['valorUnitario'] ?></td>

         
         </form>
         <td>
         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="did" value='.$d['id'].'></td>
    </form>';
    
?>
</td>
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">

         </td>
       </tr>
       <tr>
         <td class="pt-3-half" contenteditable="true"><?php echo $e['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $e['valorUnitario'] ?></td>

         
         </form>
         <td>
         
         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="eid" value='.$e['id'].'></td>
    </form>';
?>
         </td>
       </tr>
       <form method="POST" action="insereqtd.php" enctype="multipart/form-data">

         </td>
       </tr>
       <tr>
         <td class="pt-3-half" contenteditable="true"><?php echo $f['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $f['valorUnitario'] ?></td>

         
         </form>
         <td>
         
         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="fid" value='.$f['id'].'></td>
    </form>';
?>
         </td>
       </tr>
       <form method="POST" action="insereqtd.php" enctype="multipart/form-data">

         </td>
       </tr>
       <tr>
         <td class="pt-3-half" contenteditable="true"><?php echo $g['qtde'] ?></td>
         <td class="pt-3-half" contenteditable="true"><?php echo $g['valorUnitario'] ?></td>

         
         </form>
         <td>
         
         <?php
  echo'
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="gid" value='.$g['id'].'></td>
    </form>';
?>
         </td>
       </tr>
       
       <!-- This is our clonable table line -->
       <tr class="hide">
        
       </tr>
     </tbody>
   </table>
 </div>
</div>
</div>
<!-- Editable table -->



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

     </body>
     

     </html>