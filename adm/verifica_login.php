<?php
require_once('../inc/def.php');
require_once('../inc/hash.php');

$sql = 'SELECT id , senha, primeiro_nome(nome) nome , idCargo, email FROM Admin WHERE email = \''.$_POST['email'].'\';';
$q = mysqli_query($link, $sql);
$r = mysqli_fetch_assoc($q);

if(passwordCheck($_POST['senha'],$r['senha'])){
	$_SESSION['idUserAdm'] = $r['id'];
	$_SESSION['id_hierarquia'] = $r['idCargo'];
	$_SESSION['nome'] = $r['nome'];
	$_SESSION['email'] = $r['email'];
	ir('dashboard/index');
}else{
	echo '<script type="text/javascript">
	alert("Dados Incorretos! Tente novamente...");
	window.location = "index.php"
	</script>
	';
	session_destroy();
}

?>
