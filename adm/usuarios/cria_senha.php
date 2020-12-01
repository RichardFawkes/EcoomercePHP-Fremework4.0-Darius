<?php
require_once "../../inc/hash.php";
// instancia a classe
$hash = new PasswordStorage;

echo $password = $hash->create_hash($_GET['pass']);
