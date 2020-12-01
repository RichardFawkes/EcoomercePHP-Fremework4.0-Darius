<?php 
	require_once('../inc/def.php');
	
	$plocoff = 0;

?>



<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8"> 
<script src="b4w.min.js"></script>

<script>

	function load_cb(){
		m_data.load("json_bin/lata.json", loaded_cb);
	}


	function loaded_cb(data_id , success){

		if (!success) {
			console.log("b4w load failure");
			return;
		}

		m_app.enable_camera_controls();
		mostrar_rotulo355();
		mostrar_tampa(<?php echo $plocoff;?>);
		
	}

	m_app.init({
		canvas_container_id: "container_id",
		callback: load_cb  
	})
          
        


</script>

<style>
	#container_id{
		margin-top: 200px;
		position: absolute;
	}
</style>

</head>

<body style="background-color: #CCCCCC;">
<br><br><br><br><br><br><br>

	<div style="width: 1050px; text-align: center;">
		<input type="button" value="Esconder Decortop" onclick="esconde_decortop()">&nbsp;
		<input type="button" value="Esconder Plocoff" onclick="esconde_plocoff()">&nbsp;
		<input type="button" value="Esconder Rótulo 360" onclick="esconde_rotulo360()">&nbsp;
		<input type="button" value="Esconder Rótulo 355" onclick="esconde_rotulo355()">&nbsp;<br>

		<input type="button" value="Mostrar Decortop" onclick="mostrar_decortop()">&nbsp;
		<input type="button" value="Mostrar Plocoff" onclick="mostrar_plocoff()">&nbsp;
		<input type="button" value="Mostrar Rótulo 360" onclick="mostrar_rotulo360()">&nbsp;
		<input type="button" value="Mostrar Rótulo 355" onclick="mostrar_rotulo355()">&nbsp;<br>

		<input type="button" value="Mostrar espuma" onclick="mostrar_espuma()">&nbsp;<br>
		<input type="button" value="Opaco" onclick="opaco()">
		<input type="button" value="Transparente" onclick="transparente()">

		<input type="button" value="Trocar Tampa" onclick="troca_tampa()">&nbsp;
<!--		<input type="button" value="Trocar Rótulo" onclick="troca_rotulo()"> -->
	</div>
	<div id="container_id" style="width: 1050px; height: 600px; margin-top:10px; position:relative"></div>

</body>

</html>
