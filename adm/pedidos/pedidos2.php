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
					<h4 class="page-title">Pedidos</h4>
				</div>
			</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box table-responsive">
				<table id="tabela" class="table table-striped table-bordered dt-responsive nowrap">
					<thead >
						<th>#</th>
						<th>Nome</th>
						<th>Cidade</th>
						<th>Data/Hora</th>
						<th>Frete</th>
						<th>Total</th>
						<th>Metodo</th>
						
						<th>Funções</th>
					</thead>
					<tbody>
						<?php

                            $sql = 'SELECT   *,pd.metodo method FROM Pedidos_Manual  p
LEFT JOIN Pedidos_Manual_Dados_Pagamento pd ON pd.idCompra = p.idCompra
							group by p.idCompra
							
		
							
						   
								;';
                            $res = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($res)) {
                             
                                echo "<tr>";
                                echo "<td>".$row['idCompra']."</td>";
                                echo "<td>".$row['nomecliente']."</td>";
                                echo "<td>".$row['cidade']."</td>";
                                echo "<td>".$row['dataHora']."</td>";
                                echo "<td class>".formata_real($row['frete'])."</td>";
                                echo "<td>".formata_real($row['totaltudo'])."</td>";
                                
                               echo "<td >".$row['method']."</td>";
                         
                           
                                echo "<td>";
								echo "<a class='btn btn-primary' title='Pedido' data-toggle='tooltip' href='pedido-resultado?id=".$row['idCompra']."'><i class='fa fa-search'></i></a> ";
								echo "<a class='btn btn-danger' title='Pedido' data-toggle='tooltip' href='pedido-editar?id=".$row['idCompra']."'><i class='fa fa-pencil-square-o'></i></a> ";

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
		<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>

		<script type="text/javascript">
		  $(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();

				$('.money').mask('000.000.000.000.000,00', {reverse: true});
  			$('.money2').mask("#.##0,00", {reverse: true});
			  $('.money3').mask("#.##0,00", {reverse: true});


				// você pode usar um dos dois com data ou data e hora
		     $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );    //Formatação com Hora
		     $.fn.dataTable.moment('DD/MM/YYYY');    //Formatação sem Hora
				 jQuery.extend( jQuery.fn.dataTableExt.oSort, {
					 "date-br-pre": function ( a ) {
					  if (a == null || a == "") {
					   return 0;
					  }
					  var brDatea = a.split('/');
					  return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
					 },

					 "date-br-asc": function ( a, b ) {
					  return ((a < b) ? -1 : ((a > b) ? 1 : 0));
					 },

					 "date-br-desc": function ( a, b ) {
					  return ((a < b) ? 1 : ((a > b) ? -1 : 0));
					 }
					} );
		    $('#tabela').DataTable({
      		"order": [[0, "desc"]],
					"columnDefs": [{
            "type": 'date-br',
            "targets": 4
        	}],
					"columns": [
						null,
						null,
						null,
						null,
						null,
						null,
					
    				null,
    		
					
						{ "orderable": false }
  				]
    		});




		  });

		</script>

	</body>
	</html>
