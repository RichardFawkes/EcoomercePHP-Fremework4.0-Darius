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
				<h4 class="page-title">Produtos <a href="cadastrar.php" class="btn btn-primary"><i class="fa fa-plus"></i> Produto</a></h4>

			</div>
		</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box">
					<table id="tabela" class="table table-striped">
						<thead>
						    <th>ID</th>
						    <th>Imagem</th>
							<th>Título</th>
							<th>Formato</th>
							<th>Categoria</th>
							<th>Preço (R$)</th>
							<th>Funções</th>
						</thead>
						<tbody>
							<?php
								$sql = 'SELECT p.id,p.ativo, p.mostra_cor_da_tampa,p.titulo, p.url,p.largura_rotulo, p.altura_rotulo, c.categoria,p.img,
								(SELECT valorUnitario FROM PrecosQuantidades WHERE idProduto = p.id ORDER BY valorUnitario DESC LIMIT 1) valorUnitario
								FROM Categorias_X_Produtos cp 
								JOIN Produtos p ON cp.idProduto= p.id
								JOIN Categorias c ON c.id = cp.idCategoria					
								ORDER BY p.id DESC';


								$res = mysqli_query($link,$sql);


								while($row = mysqli_fetch_array($res)){
									echo "<tr id='produto_".$row['id']."'>";
									echo "<td>".$row['id']."</td>";
									echo "<td><img 
									 src='".$site."/images/product/mini/".$row['img']."' style='height: 100px;'></td>";
									echo "<td>".$row['titulo']."</td>";
									echo "<td>".$row['largura_rotulo']."x".$row['altura_rotulo']."</td>";
									echo "<td>".$row['categoria']."</td>";
									echo "<td><b>R$</b> ".$row['valorUnitario']."</td>";
									echo "<td>";
										echo "<a class='btn btn-default' title='Abrir em nova Aba' data-toggle='tooltip' target='_blank' href='".$site."produto/".$row['url']."'><i class='fa fa-external-link'></i></a> ";
										echo "<a class='btn btn-primary' title='Editar' data-toggle='tooltip' href='editar.php?id=".$row['id']."'><i class='fa fa-pencil'></i></a> ";

										if($row['mostra_cor_da_tampa']==1){
											echo "<a href='#' id='mostra_cor_da_tampa_".$row['id']."' class='btn btn-success activeTampa' title='Produto com tampa' data-toggle='tooltip'><i class='fa fa-circle'></i></a> ";
										}else{
											echo "<a href='#' id='mostra_cor_da_tampa_".$row['id']."' class='btn btn-warning activeTampa' title='Produto sem tampa' data-toggle='tooltip'><i class='fa fa-circle-o'></i></a> ";
										}

										if($row['especifico']==0){
											echo "<a href='#' id='especifico_".$row['id']."' class='btn btn-success activeHome' title='Habilitado/Home' data-toggle='tooltip'><i class='fa fa-file'></i></i></a> ";
										}else{
											echo "<a href='#' id='especifico_".$row['id']."' class='btn btn-warning activeHome' title='Desabilitado/Home' data-toggle='tooltip'><i class='fa fa-file-o'></i></i></a> ";
										}


										if($row['ativo']==1){
											echo "<a href='#' id='eye_".$row['id']."' class='btn btn-success activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-up'></i></a> ";
										}else{
											echo "<a href='#' id='eye_".$row['id']."' class='btn btn-warning activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-down'></i></a> ";
										}
										// echo "<a href='#' id='".$row['id']."' class='btn btn-danger delBtn' title='Excluir' data-toggle='tooltip'><i class='fa fa-trash'></i></a> ";
										echo "<a  id='".$row['id']."' class='btn btn-primary addBtn' title='Duplicar' data-toggle='tooltip' href='duplicar.php?id=".$row['id']."'><i class='glyphicon glyphicon-plus'></i></a> ";

									echo "</td>";
									echo "</tr>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>

	</div>
</div>
		<!-- Final da página -->
		<?php
		require_once($siteHD.'adm/rodape.php');
		require_once($siteHD.'adm/js.php');
		?>
		<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js" type="text/javascript"></script>
		<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js" type="text/javascript"></script> -->
		<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>


		<script type="text/javascript">
		  $(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
	    	$('#tabela').DataTable();

				// Apagar
				$("#tabela").on('click','.delBtn', function(event) {
			 	// $(".delBtn").click(function (event) {
					console.log(this.id);
			     event.preventDefault();
			     var id = this.id;
			     var clickedID = 'id=' + id;
			 		if(confirm("Certeza em apagar definitivamente este Produto?")){
			 	    jQuery.ajax({
			 	        type: "GET", // HTTP method POST or GET
			 	        url: "deletar.php", //Where to make Ajax calls
			 	        dataType: "text", // Data type, HTML, json etc.
			 	        data: clickedID, //Form variables
			 	        success: function (response) {
			 	            alert(response);
			 	            $("#produto_" + id).fadeOut(300, function(){ $(this).remove();});
			 	        },
						 

						 
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



			 $("#tabela").on('click','.activeHome', function(event) {
			 // $(".activeBtn").click(function (event) {
			 	event.preventDefault();
			 	var id = this.id.substr(11);
			 	var clickedID = 'id=' + id;
			 	jQuery.ajax({
			 			type: "GET", // HTTP method POST or GET
			 			url: "altera-status-index.php", //Where to make Ajax calls
			 			dataType: "json", // Data type, HTML, json etc.
			 			data: clickedID, //Form variables
			 			success: function (json) {
			 				// $("#eye_"+id).removeClass("btn-warning btn-success").addClass(response);
			 				$("#eye_"+id).fadeIn(300, function(){
								$("#especifico_"+id).removeClass("btn-warning btn-success").addClass(json.class);
								$("#especifico_"+id +" i").removeClass("fa-file fa-file-o").addClass(json.icon);
							});
			 			}
			 	});
			 });


			 // AJAX Produto com/sem tampa
			 $("#tabela").on('click','.activeTampa', function(event) {
			 // $(".activeBtn").click(function (event) {
			 	event.preventDefault();
			 	var id = this.id.substr(20);
			 	var clickedID = 'id=' + id;
			 	jQuery.ajax({
			 			type: "GET", // HTTP method POST or GET
			 			url: "altera-status-tampa.php", //Where to make Ajax calls
			 			dataType: "json", // Data type, HTML, json etc.
			 			data: clickedID, //Form variables
			 			success: function (json) {
			 				// $("#eye_"+id).removeClass("btn-warning btn-success").addClass(response);
			 				$("#eye_"+id).fadeIn(300, function(){
								$("#mostra_cor_da_tampa_"+id).removeClass("btn-warning btn-success").addClass(json.class);
								$("#mostra_cor_da_tampa_"+id +" i").removeClass("fa-circle fa-circle-o").addClass(json.icon);
							});
			 			}
			 	});
			 });

		





		  });

		</script>

		

	</body>
	</html>
