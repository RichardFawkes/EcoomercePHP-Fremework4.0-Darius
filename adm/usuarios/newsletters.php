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
				<h4 class="page-title">Newsletters <a class="btn btn-primary" href="exporta-newsletters.php"><i class="fa fa-download"></i> Exportar em .CSV</a></h4>

			</div>
		</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box">
				<table id="tabela" class="table table-striped">
					<thead>
						<th>Usuário</th>
						<th>Email</th>
						<th>IP</th>
						<th>Data do Cadastro</th>
						<th style="display:none;">Ordenar</th>
					</thead>
					<tbody>
						<?php
							$sql = 'SELECT IFNULL(u.nome,"-") nome, n.email, n.ip, formata_data_hora(n.dataHora) dataHoraTxt , n.dataHora
							FROM Newsletter n
							LEFT JOIN Users u ON u.id = n.idUser
							ORDER BY n.dataHora DESC;';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
								echo "<tr>";
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['email']."</td>";
								echo "<td>".$row['ip']."</td>";
								echo "<td>".$row['dataHoraTxt']."</td>";
								echo "<td  style='display:none;'>".$row['dataHora']."</td>";
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
		<script type="text/javascript">
		  $(document).ready(function(){

		     $('#tabela').DataTable({
					  "order": [[4, "desc"]]
				 });
		  });

		</script>

	</body>
	</html>
