<?php 
	require_once('../inc/def.php');

	$tipoDeTampa = 'plocoff';

?>



<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8"> 
<script src="b4w.min.js"></script>

<script>

	var m_app = b4w.require("app");
	var m_data = b4w.require("data");
	var m_scenes  = b4w.require("scenes");
	var m_tex = b4w.require("textures");
	var m_mat = b4w.require("material");






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
		mostrar_<?php echo $tipoDeTampa;?>();
	}

	function esconde_rotulo360(){
		var obj = m_scenes.get_object_by_name("rotulo360");
		m_scenes.hide_object(obj);
	}

	function esconde_rotulo355(){
		var obj = m_scenes.get_object_by_name("rotulo355");
		m_scenes.hide_object(obj);

		var obj = m_scenes.get_object_by_name("tarja");
		m_scenes.hide_object(obj);
	}

	function esconde_plocoff(){
		var obj = m_scenes.get_object_by_name("espuma");
		m_scenes.hide_object(obj);

		var obj = m_scenes.get_object_by_name("aneldecima");
		m_scenes.hide_object(obj);

		var obj = m_scenes.get_object_by_name("plocoff");
		m_scenes.hide_object(obj);
	}

	function esconde_decortop(){
		var obj = m_scenes.get_object_by_name("decortop");
		m_scenes.hide_object(obj);
	}

	function mostrar_rotulo360(){
		var obj = m_scenes.get_object_by_name("rotulo360");
		m_scenes.show_object(obj);


	}

	function mostrar_rotulo355(){
		var obj = m_scenes.get_object_by_name("rotulo355");
		m_scenes.show_object(obj);

		var obj = m_scenes.get_object_by_name("tarja");
		m_scenes.show_object(obj);
	}

	function mostrar_espuma(){
		var obj = m_scenes.get_object_by_name("aneldecima");
		m_scenes.show_object(obj);

		var obj = m_scenes.get_object_by_name("espuma");
		m_scenes.show_object(obj);
	}

	function mostrar_plocoff(){
		var obj = m_scenes.get_object_by_name("plocoff");
		m_scenes.show_object(obj);

		var obj = m_scenes.get_object_by_name("aneldecima");
		m_scenes.show_object(obj);

		var obj = m_scenes.get_object_by_name("espuma");
		m_scenes.show_object(obj);
	}

	function mostrar_decortop(){
		var obj = m_scenes.get_object_by_name("decortop");
		m_scenes.show_object(obj);
	}

	function troca_tampa(){

		var obj = m_scenes.get_object_by_name("plocoff");
		var image = new Image();
		image.onload = function() {
		    m_tex.replace_image(obj, "texturatampacima.001", image);
		}
		image.src = "json_bin/tampa_laranja.jpg";

	}

	function troca_rotulo(){
	//	console.log(load_cb);	
	//	console.log(m_app);
	//	console.log(m_data);
	//	console.log(m_scenes);

//		var cube = m_scenes.get_object_by_name("Cylinder");
		//console.log(cube);
		//var tes = m_tex.get_texture_names(cube);
		//console.log(tes);


//		var image = new Image();
//		image.src = "./paisagem.jpg";
//		m_tex.replace_image("Cylinder", "Texture.003", image);
//		image.onload = function() {

//		}



		var obj = m_scenes.get_object_by_name("rotulo");
		var image = new Image();
		image.onload = function() {
		    m_tex.replace_image(obj, "texturarotulo", image);
		}
		var numero = Math.floor(Math.random() * 3) + 1;
		image.src = "./rotulo_"+numero+".jpg";


	}


	function opaco(){
		var obj = m_scenes.get_object_by_name("decortop");
//		m_mat.set_alpha_factor(obj, "materialtampacima.000", 0.5);
		m_mat.set_alpha_factor(obj, "materialtampacima.000", 1);

		var obj = m_scenes.get_object_by_name("plocoff");
		m_mat.set_alpha_factor(obj, "materialtampacima.000", 1);
	}


	function transparente(){
		var obj = m_scenes.get_object_by_name("decortop");
		m_mat.set_alpha_factor(obj, "materialtampacima.000", 0.345);

		var obj = m_scenes.get_object_by_name("plocoff");
		m_mat.set_alpha_factor(obj, "materialtampacima.000", 0.345);
	}

//console.log(m_scenes);

//var cube = m_scenes.get_object_by_name('Cylinder');


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
<?php
/*	<img src="<?php echo $site;?>assets/img/img1px.png" onload="alert('teste') , alert('teste2') , mostrar_rotulo355() , alert('teste3');"> */
?>
</body>

</html>
