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
				<table id="tabela" class="table table-striped">
					<thead>
						<th>#</th>
						<th>Nome</th>
						<th>Cidade</th>
						<th>Data/Hora</th>
						<th>Frete</th>
						<th>Valor</th>
						<th>Pago</th>
						<th>Produção</th>
						<th>Enviado</th>
						<th>Entregue</th>
						<th>Funções</th>
					</thead>
					<tbody>
						<?php
							$sql = 'SELECT c.id, u.nome, formata_data(c.dataHora) dataHora,
								 c.pago, c.enviado, c.entregue, c.statusProducao,
								 CONCAT(ci.cidade,"/",e.sigla) cidade,
								 (SELECT preco_frete FROM Transportadoras_Cotacoes WHERE id= c.idTransportadoras_Cotacoes) custo_frete,
								 (SELECT SUM(valor) FROM Compras_X_Produtos WHERE idCompra=c.id) valor
								FROM Compras c
								JOIN Users u ON u.id = c.idUser
								LEFT JOIN Users_X_Enderecos uxe ON uxe.id = c.idUsers_X_Enderecos
								LEFT JOIN CidadesIBGE ci ON ci.id = uxe.idCidade
								LEFT JOIN Estados e ON e.id = ci.idEstado
								ORDER BY c.dataHora DESC
								;';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
								if($row['pago']==0){
									// $status1 = "Não Pago";
									$status1 = '<a id="pay_'.$row['id'].'" class="btn btn-warning pay"><i class="fa fa-check"></i></a>';
								}else{
									$status1 = '<a id="pay_'.$row['id'].'" class="btn btn-success pay"><i class="fa fa-check"></i></a>';
									// $status1 = "Pago";
								}
								if($row['statusProducao']==0){
									// $status2 = "Não Produzido";
									$status2 = '<a id="spr_'.$row['id'].'" class="btn btn-warning spr"><i class="fa fa-check"></i></a>';
								}else{
									// $status2 = "Produzido";
									$status2 = '<a id="spr_'.$row['id'].'" class="btn btn-success spr"><i class="fa fa-check"></i></a>';
								}
								if($row['enviado']==0){
									// $status3 = "Não Enviado";
									$status3 = '<a id="sen_'.$row['id'].'" class="btn btn-warning sen"><i class="fa fa-check"></i></a>';
								}else{
									// $status3 = "Enviado";
									$status3 = '<a id="sen_'.$row['id'].'" class="btn btn-success sen"><i class="fa fa-check"></i></a>';
								}
								if($row['entregue']==0){
									// $status4 = "Não Entregue";
									$status4 = '<a id="ent_'.$row['id'].'" class="btn btn-warning ent"><i class="fa fa-check"></i></a>';
								}else{
									// $status4 = "Entregue";
									$status4 = '<a id="ent_'.$row['id'].'" class="btn btn-success ent"><i class="fa fa-check"></i></a>';
								}

								echo "<tr>";
								echo "<td>".$row['id']."</td>";
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['cidade']."</td>";
								echo "<td>".$row['dataHora']."</td>";
								echo "<td class='money'>".$row['custo_frete']."</td>";
								echo "<td class='money2'>".$row['valor']."</td>";
								echo "<td>".$status1."</td>";
								echo "<td>".$status2."</td>";
								echo "<td>".$status3."</td>";
								echo "<td>".$status4."</td>";
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
    				{ "orderable": false },
    				{ "orderable": false },
						{ "orderable": false }
  				]
    		});


				// Pago
				$("#tabela").on('click','.pay', function(event) {
				 event.preventDefault();
				 var id = this.id.substr(4);
				 var clickedID = 'id=' + id;
				 jQuery.ajax({
						 type: "GET", // HTTP method POST or GET
						 url: "altera-pay.php", //Where to make Ajax calls
						 dataType: "json", // Data type, HTML, json etc.
						 data: clickedID, //Form variables
						 success: function (json) {
							 $("#pay_"+id).fadeIn(300, function(){
								 $(this).removeClass("btn-warning btn-success").addClass(json.class);
								 $("#pay_"+id +" i").removeClass("fa-check").addClass(json.icon);
							 });
						 }
				 });
				});

				// Produção
				$("#tabela").on('click','.spr', function(event) {
				 event.preventDefault();
				 var id = this.id.substr(4);
				 var clickedID = 'id=' + id;
				 jQuery.ajax({
						 type: "GET", // HTTP method POST or GET
						 url: "altera-spr.php", //Where to make Ajax calls
						 dataType: "json", // Data type, HTML, json etc.
						 data: clickedID, //Form variables
						 success: function (json) {
							 $("#spr_"+id).fadeIn(300, function(){
								 $(this).removeClass("btn-warning btn-success").addClass(json.class);
								 $("#spr_"+id +" i").removeClass("fa-check").addClass(json.icon);
							 });
						 }
				 });
				});

				// Enviado
				$("#tabela").on('click','.sen', function(event) {
				 event.preventDefault();
				 var id = this.id.substr(4);
				 var clickedID = 'id=' + id;
				 jQuery.ajax({
						 type: "GET", // HTTP method POST or GET
						 url: "altera-sen.php", //Where to make Ajax calls
						 dataType: "json", // Data type, HTML, json etc.
						 data: clickedID, //Form variables
						 success: function (json) {
							 $("#sen_"+id).fadeIn(300, function(){
								 $(this).removeClass("btn-warning btn-success").addClass(json.class);
								 $("#sen_"+id +" i").removeClass("fa-check").addClass(json.icon);
							 });
						 }
				 });
				});

				// Entregue
				$("#tabela").on('click','.ent', function(event) {
				 event.preventDefault();
				 var id = this.id.substr(4);
				 var clickedID = 'id=' + id;
				 jQuery.ajax({
						 type: "GET", // HTTP method POST or GET
						 url: "altera-ent.php", //Where to make Ajax calls
						 dataType: "json", // Data type, HTML, json etc.
						 data: clickedID, //Form variables
						 success: function (json) {
							 $("#ent_"+id).fadeIn(300, function(){
								 $(this).removeClass("btn-warning btn-success").addClass(json.class);
								 $("#ent_"+id +" i").removeClass("fa-check").addClass(json.icon);
							 });
						 }
				 });
				});

		  });

		</script>

	</body>
	</html>
