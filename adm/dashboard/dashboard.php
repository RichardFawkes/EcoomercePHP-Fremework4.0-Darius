<?php
	require_once('../../inc/def.php');
	libera_acesso(1);

	$cor = array('#ff8acc', '#5b69bc', '#35b8e0', '#AAAA00','#10c469','#188ae2'
	,'#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0'
	,'#f032e6', '#bcf60c', '#fabebe', '#008080', '#e6beff', '#9a6324', '#fffac8'
	,'#800000', '#aaffc3', '#808000', '#ffd8b1', '#000075', '#808080', '#ffffff'
	,'#f3558d','#c069db','#6fcba0','#b90e2c','#521cb1','#61c21f','#deb6f6','#f98a43'
	,'#3f17cf','#b2e746','#9b0325','#ddff45','#f876fe','#511f22','#09173b','#e79176'
	,'#0d9626','#75ea88','#d0c27c','#420d7e','#ba9144');
	// $cores = implode("','", $cor);
	// $cores = "'".$cores."'";



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="<?php echo $rot; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $rot; ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $rot; ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $rot; ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $rot; ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $rot; ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo $rot; ?>assets/js/modernizr.min.js"></script>

				<style>
					.linha2header-title{margin-top:10px;}
					.img-circle{max-width:75px; min-height:40px;}
					.inbox-widget .inbox-item .inbox-item-date{top:20px;}
					.inbox-widget .inbox-item img{height: 40px; width: 40px;}
				</style>

    </head>


    <body>




        <div class="wrapper">
            <div class="container">


            </div> <!-- end container -->
        </div> <!-- end wrapper -->



        <!-- jQuery  -->
        <script src="<?php echo $rot; ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo $rot; ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $rot; ?>assets/js/detect.js"></script>
        <script src="<?php echo $rot; ?>assets/js/fastclick.js"></script>

        <script src="<?php echo $rot; ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo $rot; ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo $rot; ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo $rot; ?>assets/js/jquery.scrollTo.min.js"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="<?php echo $rot; ?>assets/plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="<?php echo $rot; ?>assets/plugins/jquery-knob/jquery.knob.js"></script>


        <!-- Dashboard init -->
        <!-- código interno abaixo: script src="<?php echo $rot; ?>assets/pages/jquery.dashboard.js"></script> -->

        <!-- App js -->
        <script src="<?php echo $rot; ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo $rot; ?>assets/js/jquery.app.js"></script>





    </body>
</html>
