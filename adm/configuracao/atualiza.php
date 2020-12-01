<?php
require_once('../../inc/def.php');
libera_acesso(1);

foreach($_POST as $key => $value) {
  $upd = 'UPDATE Configuracao SET valor="'.$value.'",updated=NOW(), idUser_updated='.$_SESSION['idUserAdm'].' WHERE chave="'.$key.'";';
  mysqli_query($link,$upd);
}

ir($site.'adm/configuracao/index.php','Alterado com sucesso.');
