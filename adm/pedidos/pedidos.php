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
						<th>Total</th>
						<th>Metodo</th>
						<th>Pago</th>
						<th>Produção</th>
						<th>Enviado</th>
						<th>Entregue</th>
						<th>Funções</th>
					</thead>
					<tbody>
						<?php

                            $sql = 'SELECT uxe.nome, uxe.sobrenome, c.id, formata_data(c.dataHora) dataHora, cq.processorName,
							c.pago, c.enviado, c.entregue, c.statusProducao,
							CONCAT(ci.cidade,"/",e.sigla) cidade,
							(SELECT preco_frete FROM Transportadoras_Cotacoes WHERE id= c.idTransportadoras_Cotacoes) custo_frete,
							(SELECT SUM(valor * qtde) FROM Compras_X_Produtos WHERE idCompra=c.id) valor
						   FROM Compras c
						   JOIN Users u ON u.id = c.idUser
							JOIN Compras_X_Invoices cq ON cq.idCompra = c.id
						   LEFT JOIN Users_X_Enderecos uxe ON uxe.id = c.idUsers_X_Enderecos
						   LEFT JOIN CidadesIBGE ci ON ci.id = uxe.idCidade
						   LEFT JOIN Estados e ON e.id = ci.idEstado
						   group by c.id
						   ORDER BY c.dataHora DESC
						   
								;';
                            $res = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($res)) {
                                if ($row['pago']==0) {
                                    // $status1 = "Não Pago";
                                    $status1 = '<button id="pay_'.$row['id'].'" class="btn btn-warning pay" disabled><i class="fa fa-remove"></i></button>';
                                } else {
                                    $status1 = '<button id="pay_'.$row['id'].'" class="btn btn-success pay" disabled><i class="fa fa-check"></i><span class="hide">Pago</span></button>';
                                    // $status1 = "Pago";
                                }
                                if ($row['statusProducao']==0) {
                                    // $status2 = "Não Produzido";
                                    $status2 = '<button id="spr_'.$row['id'].'" class="btn btn-warning spr" disabled><i class="fa fa-remove"></i></button>';
                                } else {
                                    // $status2 = "Produzido";
                                    $status2 = '<button id="spr_'.$row['id'].'" class="btn btn-success spr" disabled><i class="fa fa-check"></i><span class="hide">Produzido</span></button>';
                                }
                                if ($row['enviado']==0) {
                                    // $status3 = "Não Enviado";
                                    $status3 = '<button id="sen_'.$row['id'].'" class="btn btn-warning sen" disabled><i class="fa fa-remove"></i></button>';
                                } else {
                                    // $status3 = "Enviado";
                                    $status3 = '<button id="sen_'.$row['id'].'" class="btn btn-success sen" disabled><i class="fa fa-check"></i><span class="hide">Enviado</span></button>';
                                }
                                if ($row['entregue']==0) {
                                    // $status4 = "Não Entregue";
                                    $status4 = '<button id="ent_'.$row['id'].'" class="btn btn-warning ent" disabled><i class="fa fa-remove"></i></button>';
                                } else {
                                    // $status4 = "Entregue";
                                    $status4 = '<button id="ent_'.$row['id'].'" class="btn btn-success ent" disabled><i class="fa fa-check"></i><span class="hide">Entregue</span></button>';
                                }
                                if ($row['pago']==3) {
                                    // $status1 = "Não Pago";
                                    $status1 = '<button id="pay_'.$row['id'].'" class="btn btn-danger pay" disabled><i class="fa fa-reply"></i></button>';
                                } else {
                                }
                                $totals = ($row['valor']+$row['custo_frete']);

                                echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['nome']."&nbsp;".$row['sobrenome']."</td>";
                                echo "<td>".$row['cidade']."</td>";
                                echo "<td>".$row['dataHora']."</td>";
                                echo "<td class>".formata_real($row['custo_frete'])."</td>";
                                echo "<td class>".formata_real($row['valor'])."</td>";
                                echo "<td>".formata_real($totals)."</td>";
                                if ($row['processorName']== 'REDE') {
                                    echo "<td ><i class='fa fa-credit-card-alt'></i>Cartão de Crédito</td>";
                                } else {
                                    echo "<td ><i class='fa fa-barcode'></i>Boleto bancário</td>";
                                }
                                echo "<td>".$status1."</td>";
                                echo "<td>".$status2."</td>";
                                echo "<td>".$status3."</td>";
                                echo "<td>".$status4."</td>";
                                echo "<td>";
                                echo "<a class='btn btn-primary' title='Pedido' data-toggle='tooltip' href='pedido?id=".$row['id']."'><i class='fa fa-search'></i></a> ";
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
    				null,
    				{ "orderable": false },
    				{ "orderable": false },
    				{ "orderable": false },
    				{ "orderable": false },
					
						{ "orderable": false }
  				]
    		});




		  });

		</script>

	</body>
	</html>
