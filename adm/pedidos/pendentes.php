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
					<h4 class="page-title">Pedidos: Pendentes</h4>
				</div>
			</div>

			<!-- Formulário -->
			<div class="row">
				<div class="card-box table-responsive">
				<table id="tabela" class="table table-striped">
					<thead>
						<th>#</th>
						<th>Nome</th>
						<th>Cidade</th>
						<th>Data/Hora</th>
						<th>Frete</th>
						<th>Valor</th>
						<th>Pago</th>
						<th>Funções</th>
					</thead>
					<tbody>
						<?php

							$sql = 'SELECT c.id, u.nome, formata_data(c.dataHora) dataHora,
								 c.pago, c.enviado, c.entregue, c.statusProducao,
								 CONCAT(ci.cidade,"/",e.sigla) cidade,
								 (SELECT preco_frete FROM Transportadoras_Cotacoes WHERE id= c.idTransportadoras_Cotacoes) custo_frete,
								 (SELECT SUM(valor*qtde) FROM Compras_X_Produtos WHERE idCompra=c.id) valor
								FROM Compras c
								JOIN Users u ON u.id = c.idUser
								LEFT JOIN Users_X_Enderecos uxe ON uxe.id = c.idUsers_X_Enderecos
								LEFT JOIN CidadesIBGE ci ON ci.id = uxe.idCidade
								LEFT JOIN Estados e ON e.id = ci.idEstado
                WHERE pago=0 AND enviado=0 AND entregue=0 AND statusProducao=0
								ORDER BY c.dataHora DESC
								;';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
								if($row['pago']==0){
									// $status1 = "Não Pago";
									$status1 = '<button id="pay_'.$row['id'].'" class="btn btn-warning pay disabled"><i class="fa fa-remove"></i></button>';
								}else{
									$status1 = '<button id="pay_'.$row['id'].'" class="btn btn-success pay disabled"><i class="fa fa-check"></i></button>';
									// $status1 = "Pago";
								}

								echo "<tr>";
								echo "<td>".$row['id']."</td>";
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['cidade']."</td>";
								echo "<td>".$row['dataHora']."</td>";
								echo "<td class='money'>".$row['custo_frete']."</td>";
								echo "<td class='money2'>".$row['valor']."</td>";
								echo "<td>".$status1."</td>";
								echo "<td>";
								echo "<a class='btn btn-primary' title='Pedido' data-toggle='tooltip' href='pedido.php?id=".$row['id']."'><i class='fa fa-search'></i></a> ";
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
    				{ "orderable": false },
    				{ "orderable": false },
  				]
    		});


				// Pago
				// $("#tabela").on('click','.pay', function(event) {
				//  event.preventDefault();
				//  var id = this.id.substr(4);
				//  var clickedID = 'id=' + id;
				//  jQuery.ajax({
				// 		 type: "GET", // HTTP method POST or GET
				// 		 url: "altera-pay.php", //Where to make Ajax calls
				// 		 dataType: "json", // Data type, HTML, json etc.
				// 		 data: clickedID, //Form variables
				// 		 success: function (json) {
				// 			 $("#pay_"+id).fadeIn(300, function(){
				// 				 $(this).removeClass("btn-warning btn-success").addClass(json.class);
				// 				 $("#pay_"+id +" i").removeClass("fa-check").addClass(json.icon);
				// 			 });
				// 		 }
				//  });
				// });



		  });

		</script>

	</body>
	</html>
