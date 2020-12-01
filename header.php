<?php
    require_once('inc/def.php');

    // Seta as infos
    $sqlInfos = 'SELECT chave, valor FROM Configuracao';
    $resInfos = mysqli_query($link, $sqlInfos);
    while ($rowInfos = mysqli_fetch_array($resInfos)) {
        $infos[$rowInfos['chave']] = $rowInfos['valor'];
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140899258-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-140899258-1');
		</script>


<script src="ow/owl.carousel.min.js"></script>


		<style>
			    html,body{max-width: 100vw;
    overflow-x: hidden;}
        </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta name="description" content="<?php echo $infos['description'];?>">
    <meta name="keywords" content="<?php echo $infos['keywords'];?>">
    <meta http-equiv="Content-Language" content="pt-br">
		<meta property="og:locale" content="pt_BR">
		<?php if (isset($customHeader) && $customHeader==1) { ?>
			<meta property="og:url" content="<?php echo $_SERVER['SCRIPT_URI'];?>">
			<meta property="og:title" content="Loja da Lata <?php echo ' - '.$r['titulo'];?>.">
			<meta property="og:site_name" content="Loja da Lata">
			<meta property="og:description" content="<?php echo limita_caracteres(nl2br(strip_tags($r['descricaoFB'])), 100);?>">
			<meta property="og:image" content="<?php echo $site.'images/product/big/'.$r['img']; ?>">
			<meta property="og:image:type" content="image/png">
			<meta property="og:image:width" content="1000">
			<meta property="og:image:height" content="1000">
			<meta property="og:type" content="website">
		<?php } else { ?>
			<meta property="og:url" content="<?php echo $_SERVER['SCRIPT_URI'];?>">
			<meta property="og:title" content="Loja da Lata">
			<meta property="og:site_name" content="Loja da Lata">
			<meta property="og:description" content="<?php echo $infos['description'];?>">
			<meta property="og:image" content="<?php echo $site; ?>assets/ico/logo200.png">
			<meta property="og:image:type" content="image/png">
			<meta property="og:image:width" content="200">
			<meta property="og:image:height" content="200">
			<meta property="og:type" content="website">
		<?php } ?>


	<!-- Fav and touch icons -->
	   <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
	   <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
	   

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $site; ?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $site; ?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $site; ?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $site; ?>ico/apple-touch-icon-57-precomposed.png">
	<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo $site; ?>assets/ico/favicon.png">
    <title>Loja da Lata</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $site; ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- <link href="<?php echo $site; ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'"> -->

    <!-- Custom styles for this template -->
    <link href="<?php echo $site; ?>assets/css/style.css" rel="stylesheet">
		<!-- <link href="<?php echo $site; ?>assets/css/style.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'"> -->
