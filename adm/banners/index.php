<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");
?>


<div class="wrapper">
	<div class="container">
		<!-- hotfix for title on mobile -->
		<br class="hidden-md hidden-lg" />
		<br class="hidden-md hidden-lg" />
		<!-- Titulo -->
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Banners  <a href="cadastrar.php" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar</a></h4>

			</div>
		</div>

		<!-- Formulário -->
		<div class="row">
			<?php
			$sql = 'SELECT * FROM Carrossel ORDER BY id DESC';
			$q = mysqli_query($link,$sql);
			while($row = mysqli_fetch_array($q)){
				?>
				<div class="col-md-4" id="box_<?php echo $row['id'];?>">
					<div class="card-box" style="height:350px;">
						<div class="row">

							<span class="h4 heading"><?php echo $row['titulo']; ?></span>
						</div>
						<br/>
						<div class="row">
							<a href="<?php echo $site;?>images/carrossel/<?php echo $row['img'];?>" target="_blank" style="cursor:zoom-in;">
								<img src="<?php echo $site;?>images/carrossel/<?php echo $row['img'];?>" style="	max-width:100%; max-height:200px ;height:auto; object-fit: cover;" />
							</a>
						</div>
						<br />
						<span class="card-body">
								<span class="pull-right">
									<select class="form-control selMode" name="mode" id="<?php echo $row['id'];?>">
										<?php if($row['mode']=='_self'){ $newPage = ""; $samePage = "selected"; }else{ $newPage = "selected"; $samePage = "";} ?>
										<option value="_blank" <?php echo $newPage; ?>>Nova janela</option>
										<option value="_self" <?php echo $samePage; ?>>Mesma Janela</option>
									</select>
								</span>
								<a href="<?php if(!is_null($row['urlLink'])){ echo $row['urlLink']; }else{echo "#"; } ?>" target="_blank" data-toggle="tooltip" class="btn btn-default" title="Abrir em uma nova aba"><i class="fa fa-external-link"></i></a>
								<a href="editar.php?id=<?php echo $row['id'];?>" class="btn btn-primary" title="Editar" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
								<a href="#" class="btn activeBtn btn-<?php if($row['ativo']==1){ echo "success"; }else{ echo "warning"; }?>" id="eye_<?php echo $row['id'];?>" title="Ativar/Desativar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
								<a href="#" class="btn btn-danger delBtn" id="<?php echo $row['id'];?>" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
						</span>
					</div>
				</div>
			<?php } ?>
		</div>

	</div>
</div>
<!-- Final da página -->
<?php
require_once($siteHD.'adm/rodape.php');
require_once($siteHD.'adm/js.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	// Apagar
	$(".delBtn").click(function (event) {
    event.preventDefault();
    var id = this.id;
    var clickedID = 'id=' + id;
		if(confirm("Certeza em apagar este Banner?")){
	    jQuery.ajax({
	        type: "GET", // HTTP method POST or GET
	        url: "deletar.php", //Where to make Ajax calls
	        dataType: "text", // Data type, HTML, json etc.
	        data: clickedID, //Form variables
	        success: function (response) {
	            alert(response);
	            $("#box_" + id).fadeOut(300, function(){ $(this).remove();});
	        }
	    });
		}
});

// Ativa/Desativa
$(".activeBtn").click(function (event) {
	event.preventDefault();
	var id = this.id.substr(4);
	var clickedID = 'id=' + id;
	jQuery.ajax({
			type: "GET", // HTTP method POST or GET
			url: "altera-status.php", //Where to make Ajax calls
			dataType: "text", // Data type, HTML, json etc.
			data: clickedID, //Form variables
			success: function (response) {
				// $("#eye_"+id).removeClass("btn-warning btn-success").addClass(response);
				$("#eye_"+id).fadeIn(300, function(){ $(this).removeClass("btn-warning btn-success").addClass(response);});
			}
	});
});

// Alterar
$(".selMode").change(function (event) {
	var mode = $('select.selMode').val();
	var id = this.id;
	jQuery.ajax({
			type: "GET", // HTTP method POST or GET
			url: "alterar-modo.php", //Where to make Ajax calls
			dataType: "text", // Data type, HTML, json etc.
			data:  { mode: mode, id: id }, //Form variables
			success: function (response) {
					alert(response);
			}
	});
});

});

</script>

</body>
</html>
