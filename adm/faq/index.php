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
				
			</div>
			<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">FAQ <a href="cadastrar.php" class="btn btn-primary"><i class="fa fa-plus"></i> FAQ</a></h4>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box table-responsive">
				<table id="tabela" class="table table-striped">
					<thead>
						<th>Pergunta</th>
						<th>Funções</th>
					</thead>
					<tbody>
						<?php
							$sql = 'SELECT id, pergunta, ativo
							FROM Faq';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
						?>
						<tr id="cliente_<?php echo $row['id'];?>">
							<td><?php echo $row['pergunta']; ?></td>
							<td>
								<a href="editar.php?id=<?php echo $row['id'];?>" class="btn btn-primary" title="Editar" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
								<?php if($row['ativo']==1){
									echo "<a href='#' id='eye_".$row['id']."' class='btn btn-success activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-up'></i></a> ";
								}else{
									echo "<a href='#' id='eye_".$row['id']."' class='btn btn-warning activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-down'></i></a> ";
								}
								 ?>
								<a href="#" class="btn btn-danger delBtn" id="<?php echo $row['id'];?>" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
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

		    $('#tabela').DataTable();

				// Apagar
				$("#tabela").on('click','.delBtn', function(event) {
				// $(".delBtn").click(function (event) {
					 event.preventDefault();
					 var id = this.id;
					 var clickedID = 'id=' + id;
					if(confirm("Certeza em apagar esta Questão?")){
						jQuery.ajax({
								type: "GET", // HTTP method POST or GET
								url: "deletar.php", //Where to make Ajax calls
								dataType: "text", // Data type, HTML, json etc.
								data: clickedID, //Form variables
								success: function (response) {
										alert(response);
										$("#cliente_" + id).fadeOut(300, function(){ $(this).remove();});
								}
						});
					}
			 });

			 // Ativa/Desativa
			 $("#tabela").on('click','.activeBtn', function(event) {
			 // $(".activeBtn").click(function (event) {
				event.preventDefault();
				var id = this.id.substr(4);
				var clickedID = 'id=' + id;
				jQuery.ajax({
						type: "GET", // HTTP method POST or GET
						url: "altera-status.php", //Where to make Ajax calls
						dataType: "json", // Data type, HTML, json etc.
						data: clickedID, //Form variables
						success: function (json) {
							// $("#eye_"+id).removeClass("btn-warning btn-success").addClass(response);
							$("#eye_"+id).fadeIn(300, function(){
								$(this).removeClass("btn-warning btn-success").addClass(json.class);
								$("#eye_"+id +" i").removeClass("fa-thumbs-o-up fa-thumbs-o-down").addClass(json.icon);
							});
						}
				});
			 });


		  });

		</script>

	</body>
	</html>
