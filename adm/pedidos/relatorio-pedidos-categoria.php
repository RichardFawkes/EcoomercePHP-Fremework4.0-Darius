<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");
// TODO: Pegar o motivo da recusa
?>






<div class="wrapper">
	<div class="container">

	<?php 
	$sqlproduto = 'SELECT * FROM Categorias WHERE ativo = 1';
	$pd = mysqli_query($link,$sqlproduto);
	
	
	?>

	<h4 class="page-title">Relatorio de Pedidos Categorias:</h4>
<form  name="form1" action="resultado-categoria.php"method="POST">

      <label >PRODUTO</label>   &nbsp;	<select  style="font-weight:bold;" class="btn btn-success " id="categoria" name="categoria" required> 
	  <?php 
	  while($ap = mysqli_fetch_assoc($pd)){
	  
echo '<option value="'.$ap['id'].'">'.$ap['categoria'].'</option>';
	  }
?>
</select> &nbsp; &nbsp;
	

				<label >Data-Inicial </label>	<input  type="date" style="font-weight:bold;"id="datainicio" name="datainicio" class="btn btn-success" required>
				<label >Data-Final </label>	<input type="date" id="" style="font-weight:bold;"id="datafinal" name="datafinal" class="btn btn-success" required><br>
				
				<br>
				<label >PAGO </label>	<select  class="btn btn-success " id="pago" name="pago" required> 
				<option value="1">SIM</option>
				<option value="0">NAO</option>

				</select>
				<br>
				<br>
<button type="submit" class="btn btn-primary text-center" style="font-weight:bold;" onclick="valida()">GERAR RELATORIO</button>
</form>
<br>
<br>
			<!-- Formulário -->
			<div class="row">
				<div class="card-box table-responsive">
				<table id="tabela" class="table table-striped display" tyle="width:100%">
					<thead>
						<th>#</th>
						<th> Nome Cliente</th>
						<th> Estado</th>
						<th>Data</th>
						<th>Item</th>
						<th>QTD</th>
						<th>ValorUnitario</th>
						<th>Total</th>
						<th>Metodo</th>
						<th>Pago</th>
					</thead>
					<tbody>
						<?php

							$sql = 'SELECT (c.id)idCompra,ue.nome,c.idUser,es.estado,pd.titulo,cp.qtde,pq.valorUnitario,c.pago,formata_data(c.dataHora)data





							FROM Compras_X_Produtos cp
							JOIN Compras c ON c.id = idCompra
							LEFT JOIN Users_X_Enderecos ue ON ue.idUser = c.idUser
							LEFT JOIN Estados es ON es.id = ue.idEstado
							LEFT JOIN Produtos pd ON cp.idProduto = pd.id
							LEFT JOIN PrecosQuantidades pq ON cp.idProduto = pq.idProduto
							WHERE pago = 1
						   
								;';
							$res = mysqli_query($link,$sql);
							while($row = mysqli_fetch_array($res)){
								if($row['pago']==0){
									// $status1 = "Não Pago";
									$status1 = '<button id="pay_'.$row['id'].'" class="btn btn-warning pay" disabled><i class="fa fa-remove"></i></button>';
								}else{
									$status1 = '<button id="pay_'.$row['id'].'" class="btn btn-success pay" disabled><i class="fa fa-check"></i><span class="hide">Pago</span></button>';
									// $status1 = "Pago";
								}
								if($row['statusProducao']==0){
									// $status2 = "Não Produzido";
									$status2 = '<button id="spr_'.$row['id'].'" class="btn btn-warning spr" disabled><i class="fa fa-remove"></i></button>';
								}else{
									// $status2 = "Produzido";
									$status2 = '<button id="spr_'.$row['id'].'" class="btn btn-success spr" disabled><i class="fa fa-check"></i><span class="hide">Produzido</span></button>';
								}
								if($row['enviado']==0){
									// $status3 = "Não Enviado";
									$status3 = '<button id="sen_'.$row['id'].'" class="btn btn-warning sen" disabled><i class="fa fa-remove"></i></button>';
								}else{
									// $status3 = "Enviado";
									$status3 = '<button id="sen_'.$row['id'].'" class="btn btn-success sen" disabled><i class="fa fa-check"></i><span class="hide">Enviado</span></button>';
								}
								if($row['entregue']==0){
									// $status4 = "Não Entregue";
									$status4 = '<button id="ent_'.$row['id'].'" class="btn btn-warning ent" disabled><i class="fa fa-remove"></i></button>';
								}else{
									// $status4 = "Entregue";
									$status4 = '<button id="ent_'.$row['id'].'" class="btn btn-success ent" disabled><i class="fa fa-check"></i><span class="hide">Entregue</span></button>';
								}
								if($row['pago']==3){
									// $status1 = "Não Pago";
									$status1 = '<button id="pay_'.$row['id'].'" class="btn btn-danger pay" disabled><i class="fa fa-reply"></i></button>';
								}else{
								}
								$totals = ($row['valorUnitario']*$row['qtde']);

								echo "<tr>";
								echo "<td>".$row['idCompra']."</td>";
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['estado']."</td>";
								echo "<td>".$row['data']."</td>";
								echo "<td>".$row['titulo']."</td>";
								echo "<td>".$row['qtde']."</td>";
								echo "<td class>".formata_real($row['valorUnitario'])."</td>";
								echo "<td>".formata_real($totals)."</td>";
								if($row['processorName']== 'REDE'){
								echo "<td ><i class='fa fa-credit-card-alt'></i>Cartão de Crédito</td>";
								}else{
									echo "<td ><i class='fa fa-barcode'></i>Boleto bancário</td>";
								}
								echo "<td>".$status1."</td>";
								echo "<td>";
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


		  });

// 		  $(document).ready(function () {
//     $.fn.dataTable.ext.search.push(
//         function (settings, data, dataIndex) {
//             var min = $('#datainicio').datepicker('getDate');
//             var max = $('#datafinal').datepicker('getDate');
//             var startDate = new Date(data[4]);
//             if (min == null && max == null) return true;
//             if (min == null && startDate <= max) return true;
//             if (max == null && startDate >= min) return true;
//             if (startDate <= max && startDate >= min) return true;
//             return false;
//         }
//     );

//     $('#datainicio').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
//     $('#datafinal').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
//     var table = $('#tabela').DataTable();

//     // Event listener to the two range filtering inputs to redraw on input
//     $('#datainicio, #datafinal').change(function () {
//         table.draw();
//     });
// });

		</script>




<script>
function valida()
{
if (form1.txtIndice.value == "")
{
alert("Campos obrigatórios faltando!");
form1.txtIndice.focus();
return false;
}
}
</script>

	</body>
	</html>
