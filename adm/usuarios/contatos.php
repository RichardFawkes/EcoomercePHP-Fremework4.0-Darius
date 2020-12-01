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
					<h4 class="page-title">Contatos</h4>
				</div>
			</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box">
				<table id="tabela" class="table table-striped">
					<thead>
						<th>Visualizado</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Telefone</th>
            <th>Assunto</th>
						<th>Data/Hora Cadastro</th>
						<th>Funções</th>
					</thead>
					<tbody>
						<?php
							$sql = 'SELECT id, nome, email, telefone, assunto, formata_data_hora(dataHora) dataHora, visualizado, mensagem
							FROM Contatos';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
								echo "<tr>";
                if($row['visualizado']==1){
                  echo "<td>Sim</td>";
                }else{
                  echo "<td>Não</td>";
                }
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['email']."</td>";
								echo "<td>".$row['telefone']."</td>";
                echo "<td>".$row['assunto']."</td>";
								echo "<td>".$row['dataHora']."</td>";
								echo "<td>";
								echo "<a class='btn btn-primary' href='contato.php?id=".$row['id']."'><i class='fa fa-eye'></i></a> ";
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

		    $('#tabela').DataTable({
        "order": [[ 5, "desc" ]]
        });



		  });

		</script>

	</body>
	</html>
