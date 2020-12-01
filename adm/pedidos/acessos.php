<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");
// TODO: Pegar o motivo da recusa
?>


<div class="wrapper">
	<div class="container">
    <!-- hotfix for title on mobile -->
    <br class="hidden-md hidden-lg" />
    <br class="hidden-md hidden-lg" />

			<!-- Titulo -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title">PAGINAS MAIS ACESSADA:</h4>
				</div>
			</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box table-responsive">
				<table id="tabela" class="table table-striped">
					<thead>
						
						
						<th>ACESSOS</th>
						<th>PAGINA</th>
                        <th>IP</th>
						<th>Data/Hora</th>	
						<!-- <th>Valor</th>
						<th>Pago</th>
						<th>Funções</th> -->
					</thead>
					<tbody>
						<?php

							$sql = 'SELECT COUNT(id) acessos ,ip, url, dataHora
                                FROM UsersTracking 
                                GROUP BY url
                                ORDER BY 1 DESC
                                LIMIT 11;';

                            $q = mysqli_query($link , $sql);
                            $row = mysqli_fetch_assoc($q);
                            
							while($row = mysqli_fetch_assoc($q)){
							

								echo "<tr>";
								echo "<td>".$row['acessos']."</td>";
								echo "<td>".$row['url']."</td>";
								echo "<td>".$row['ip']."</td>";
								echo "<td>".$row['dataHora']."</td>";
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
		<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>
		


				

	
		

	</body>
	</html>
