<?php
require_once('../../inc/def.php');
libera_acesso(1);



$sql = ' UPDATE Categorias SET mailcliente = "'.$_POST['mail'].'" WHERE id =  '.$_POST['id'].'';


    //UPDATE Categorias SET `mailcliente` = '@lojadalata.com.br' WHERE `id` = '26';

    $q = mysqli_query($link,$sql);

   



?>


<script>

window.history.back();
</script>