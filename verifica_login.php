<?php

	require_once('inc/def.php');
	require_once($siteHD.'inc/hash.php');
        error_reporting(0);

	if(is_null($_POST['email']) || $_POST['email'] == '' || is_null($_POST['senha']) || $_POST['senha'] == ''){
                echo '<script type="text/javascript">
                        alert("Dados Incorretos! Tente novamente...");
                        window.location = "'.$site.'";
                </script>';
                session_destroy();
                exit;
	}


        $sql = 'SELECT id , email , senha , idHierarquia , nome , ativo FROM Users WHERE email = \''.$_POST['email'].'\';';

        $q = mysqli_query($link , $sql) or die (mysqli_errno($link));

        $r = mysqli_fetch_assoc($q);
        $nr = mysqli_num_rows($q);

        if($nr == 0){
                echo '<script type="text/javascript">
                        alert("Dados Incorretos! Tente novamente...");
                        window.location = "'.$site.'";
                </script>';

                session_destroy();
        }





	$senhaCorreta = passwordCheck($_POST['senha'] , $r['senha']);
	if ($r['ativo'] == '1' && $senhaCorreta == 1) {
		// Passando o tracking do usuário temporário, para seu idUser definitivo
		$sql = 'UPDATE UsersTracking SET idUser = "'.$r['id'].'" WHERE idUser = "'.$_SESSION['idUser'].'";';
		mysqli_query($link , $sql);


		// Passando os itens do carrinho, do usuário temporário, para seu idUser definitivo
		$sql = 'UPDATE Carrinho SET idUser = "'.$r['id'].'" WHERE idUser = "'.$_SESSION['idUser'].'";';
		mysqli_query($link , $sql);


		// Passando os itens da tabela Transportadoras_Cotacoes, do usuário temporário, para seu idUser definitivo
		$sql = 'UPDATE Transportadoras_Cotacoes SET idUser = "'.$r['id'].'" WHERE idUser = "'.$_SESSION['idUser'].'";';
		mysqli_query($link , $sql);

		// Passando os itens da tabela UsersUploads, do usuário temporário, para seu idUser definitivo
		$sql = 'UPDATE UsersUploads SET idUser = "'.$r['id'].'" WHERE idUser = "'.$_SESSION['idUser'].'";';
		mysqli_query($link , $sql);



		// Excluindo usuário temporário da tabela User
		$sql = 'DELETE FROM Users WHERE id = "'.$_SESSION['idUser'].'";';
		mysqli_query($link , $sql) or die(mysqli_error($link));
		unset($_SESSION['tempUser']);


		// Zerando Autoincrement da tabela Users, pra não ir crescendo indefinitivamente
		$sql = 'ALTER TABLE Users AUTO_INCREMENT = 1;';
		mysqli_query($link , $sql);


                $_SESSION['idUser'] = $r['id'];
                $_SESSION['idHierarquia'] = $r['idHierarquia'];
                $_SESSION['nome'] = $r['nome'];
                $_SESSION['email'] = $r['email'];

		voltar();

        }else{
                echo '<script type="text/javascript">
                        alert("Dados Incorretos! Tente novamente...");
                        
                </script>

                ';
                voltar();
        }

?>

