<?php

require_once('../../inc/def.php');
libera_acesso(1);


$sth = $c->prepare('DELETE FROM User WHERE id = '.$_GET['id_usuario']);
$sth->execute();

//print_r($sth->errorInfo());

echo '<img src="'.$site.'img/img1px.png" width="1" height="1" onload="esconde_div(\'tr'.$_GET['contador'].'\')" class="invisivel" />';

?>
