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
				<h4 class="page-title">Grupo de Produtos <a href="cadastrar.php" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar</a></h4>

			</div>
		</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box">
					<table id="tabela" class="table table-striped">
						<thead>
							<th>Imagem</th>
							<th>Título</th>
							<th>Funções</th>
						</thead>
						<tbody>
							<?php
                                $sql = 'SELECT id, categoria, urlLink, ativo, img, urlLink link,mailcliente
								FROM Categorias c
								WHERE idTipo=1
								ORDER BY c.id DESC;';
                                $res = mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<tr id='cliente_".$row['id']."'>";
                                    echo "<td width='5%'><a href='".$site."images/categorias/".$row['img']."' style='cursor:zoom-in;' target='_blank'><img src='".$site."images/categorias/".$row['img']."' class='img-responsive' /></a></td>";
                                    echo "<td>".$row['categoria']."</td>";
                                    echo "<td>";
                                    $activeLink = (is_null($row['urlLink']) || $row['urlLink']=="")? "disabled":"";
                                    echo "<a class='btn btn-default ".$activeLink."' title='Abrir em nova Aba' data-toggle='tooltip' target='_blank' href='".$site."Linhas-Proprias/".$row['link']."'><i class='fa fa-external-link'></i></a> ";
                                    echo "<a class='btn btn-primary' title='Editar' data-toggle='tooltip' href='editar.php?id=".$row['id']."'><i class='fa fa-pencil'></i></a> ";
                                    if ($row['ativo']==1) {
                                        echo "<a href='#' id='eye_".$row['id']."' class='btn btn-success activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-up'></i></a> ";
                                    } else {
                                        echo "<a href='#' id='eye_".$row['id']."' class='btn btn-warning activeBtn' title='Ativar/Desativar' data-toggle='tooltip'><i class='fa fa-thumbs-o-down'></i></a> ";
                                    }
                                    echo "<a href='#' id='".$row['id']."' class='btn btn-danger delBtn' title='Excluir' data-toggle='tooltip'><i class='fa fa-trash'></i></a> ";
                                    echo " <form method='POST' action='inseremail.php'> <br>  <input value='".$row['mailcliente']."' type='text'name='mail'>  <input  type='hidden' name='id' value='".$row['id']."'  > <button class='btn btn-success'> Salvar</button></form>";
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
			     event.preventDefault();
			     var id = this.id;
			     var clickedID = 'id=' + id;
			 		if(confirm("Certeza em apagar esta Categoria?")){
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
