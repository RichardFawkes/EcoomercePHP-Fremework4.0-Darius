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
					<h4 class="page-title">Usuários</h4>
				</div>
			</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box">
				<table id="tabela" class="table table-striped">
					<thead>
						<th>#</th>
						<th>Nome</th>
						<th>Email</th>
						<th>CPF/CNPJ</th>
						<th>Data/Hora Cadastro</th>
						<th>Funções</th>
					</thead>
					<tbody>
						<?php
							$sql = 'SELECT id, nome, email, cpf, cnpj, formata_data_hora(dataHora) dataHora, tipo_pessoa, ativo
							FROM Users
							WHERE email IS NOT NULL';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
								echo "<tr>";
								echo "<td>".$row['id']."</td>";
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['email']."</td>";
								if($row['tipo_pessoa']==1){
									echo "<td class='cpf'>".$row['cpf']."</td>";
								}else{
									echo "<td class='cnpj'>".$row['cnpj']."</td>";
								}
								echo "<td>".$row['dataHora']."</td>";
								echo "<td>";
									echo "<a class='btn btn-primary' title='Editar' data-toggle='tooltip' href='editar.php?id=".$row['id']."'><i class='fa fa-pencil'></i></a> ";
									if($row['ativo']==1){
										echo "<a href='#' id='eye_".$row['id']."' class='btn btn-success activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-up'></i></a> ";
									}else{
										echo "<a href='#' id='eye_".$row['id']."' class='btn btn-warning activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-down'></i></a> ";
									}
									echo "<a href='#' id='".$row['id']."' class='btn btn-danger delBtn' title='Excluir' data-toggle='tooltip'><i class='fa fa-trash'></i></a> ";
								echo "</td>";
								echo "</tr>";
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

				$('.cpf').mask('000.000.000-00', {reverse: true});
  			$('.cnpj').mask('00.000.000/0000-00', {reverse: true});

		    $('#tabela').DataTable();

				// Apagar
				$("#tabela").on('click','.delBtn', function(event) {
			 	// $(".delBtn").click(function (event) {
					// console.log(this.id);
			     event.preventDefault();
			     var id = this.id;
			     var clickedID = 'id=' + id;
			 		if(confirm("Certeza em apagar definitivamente este Usuário?")){
			 	    jQuery.ajax({
			 	        type: "GET", // HTTP method POST or GET
			 	        url: "deletar.php", //Where to make Ajax calls
			 	        dataType: "text", // Data type, HTML, json etc.
			 	        data: clickedID, //Form variables
			 	        success: function (response) {
			 	            alert(response);
			 	            $("#produto_" + id).fadeOut(300, function(){ $(this).remove();});
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
