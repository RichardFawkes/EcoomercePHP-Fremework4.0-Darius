<?php

	require_once('inc/def.php');

    require_once($siteHD.'inc/hash.php');
    
  $sqlcheck= 'SELECT * From Users WHERE email = "'.$_POST['email'].'"';

$qr = mysqli_query($link,$sqlcheck);

$row = mysqli_num_rows($qr);

    if($row <= 0){

	$sql = 'INSERT INTO Users (idHierarquia , nome , email , senha , dataHora) VALUES ( 2 , "'.$_POST['nome'].'" , "'.$_POST['email'].'" , "'.password_encryption($_POST['senha']).'" , NOW());';

	$q = mysqli_query($link , $sql) or die(mysqli_error($link));
	$idUser = mysqli_insert_id($link);

    }else{
        irurl('https://www.lojadalata.com/index-usuario');
    }


                // Passando o tracking do usuário temporário, para seu idUser definitivo
                $sql = 'UPDATE UsersTracking SET idUser = "'.$idUser.'" WHERE idUser = "'.$_SESSION['idUser'].'";';
                mysqli_query($link , $sql);


                // Passando os itens do carrinho, do usuário temporário, para seu idUser definitivo
                $sql = 'UPDATE Carrinho SET idUser = "'.$idUser.'" WHERE idUser = "'.$_SESSION['idUser'].'";';
                mysqli_query($link , $sql);



                $sql = 'UPDATE Compras SET idUser = "'.$idUser.'" WHERE idUser = "'.$_SESSION['idUser'].'";';
                mysqli_query($link , $sql);



                // Passando os itens da tabela Transportadoras_Cotacoes, do usuário temporário, para seu idUser definitivo
                $sql = 'UPDATE Transportadoras_Cotacoes SET idUser = "'.$idUser.'" WHERE idUser = "'.$_SESSION['idUser'].'";';
                mysqli_query($link , $sql);

                // Passando os itens da tabela UsersUploads, do usuário temporário, para seu idUser definitivo
                $sql = 'UPDATE UsersUploads SET idUser = "'.$idUser.'" WHERE idUser = "'.$_SESSION['idUser'].'";';
                mysqli_query($link , $sql);



                // Excluindo usuário temporário da tabela User
                $sql = 'DELETE FROM Users WHERE id = "'.$_SESSION['idUser'].'";';
                mysqli_query($link , $sql) or die(mysqli_error($link));
                unset($_SESSION['tempUser']);


                // Zerando Autoincrement da tabela Users, pra não ir crescendo indefinitivamente
                $sql = 'ALTER TABLE Users AUTO_INCREMENT = 1;';
                mysqli_query($link , $sql);


                $_SESSION['idUser'] = $idUser;
                $_SESSION['idHierarquia'] = 2;
                $_SESSION['nome'] = $_POST['nome'];
                $_SESSION['email'] = $_POST['email'];




	voltar();
?>

