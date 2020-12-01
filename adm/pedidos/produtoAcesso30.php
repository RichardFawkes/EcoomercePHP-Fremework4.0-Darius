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
			<h4 class="page-title">PRODUTOS MAIS ACESSADOS:</h4>
	                <a href="produtoAcesso" class="badge badge-success">TOTAL MAIS VISITADOS</a>
					<a href="produtoAcesso30" class="badge badge-success">ULTIMOS 30 DIAS</a>
					<a href="produtoAcesso15" class="badge badge-success">ULTIMOS 15 DIAS</a>
					<a href="produtoAcesso5" class="badge badge-success">ULTIMOS 5 DIAS</a>
<br>	
<br>					
				</div>
			</div>

			<!-- Formulário -->
			<div class="row">
	
				<div class="card-box table-responsive">
				<table id="tabela" class="table table-striped">
					<thead>
					    <th>LINK</th>
						<th>Acessos</th>
                        <th>Produto</th>
						<th>Imagem</th>		
					</thead>
					<tbody>
						<?php

							$sql = 'SELECT p.url, p.id, a.acessos ,  p.titulo , p.img
							FROM (
								SELECT COUNT(ut.id) acessos , REPLACE(ut.url,"/produto/","") produto, ut.url
								FROM UsersTracking ut
								WHERE ut.url LIKE "%produto/%"
								AND DATE(dataHora + INTERVAL 30 DAY) >= NOW()

								GROUP BY ut.url
							) a
							JOIN Produtos p ON p.url = a.produto
							ORDER BY a.acessos DESC;';

                            $q = mysqli_query($link , $sql);
                           
                            
							while($row = mysqli_fetch_assoc($q)){
							

								echo "<tr>";
								echo "<td><a href='".$site."produto/".$row['url']."'><i class='fa fa-external-link'></i></a></td>";
                                echo "<td>".$row['acessos']."</td>";
								echo "<td>".$row['titulo']."</td>";
								echo "<td><img style= width='40%' height='20%'  src='/images/product/mini/".$row['img']."'/></td>";
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
		<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>
		
   

				

	
		

	</body>
	</html>
