<?php
require_once('../../inc/def.php');
//require_once('../../inc/API_Boleto.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");

$cor = array('#4bb777','#ff8acc', '#5b69bc', '#35b8e0', '#AAAA00','#808080','#188ae2'
,'#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0'
,'#f032e6', '#bcf60c', '#fabebe', '#008080', '#e6beff', '#9a6324', '#fffac8'
,'#800000', '#aaffc3', '#808000', '#ffd8b1', '#000075', '#10c469', '#ffffff'
,'#f3558d','#c069db','#6fcba0','#b90e2c','#521cb1','#61c21f','#deb6f6','#f98a43'
,'#3f17cf','#b2e746','#9b0325','#ddff45','#f876fe','#511f22','#09173b','#e79176'
,'#0d9626','#75ea88','#d0c27c','#420d7e','#ba9144');
$cores = implode("','", $cor);
$cores = "'".$cores."'";
$abc = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','y','z');

if(!isMobile()){
	$size = 150;
}else{
	$size = 300;
}


// Gráfico 1 - Acessos somente do site sem contar área adm
$sql = 'SELECT
		(
			SELECT COUNT(id) qtde
			FROM UsersTracking
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 15 DAY)
					AND DATE(dataHora) < DATE(NOW() - INTERVAL 7 DAY)
					AND url NOT LIKE "%/adm/%"
		) acessosSemanaPassada
		,
		(
			SELECT COUNT(id) qtde
			FROM UsersTracking
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 8 DAY)
			AND url NOT LIKE "%/adm/%"
		) acessosEssaSemana
		,
		(
			SELECT COUNT(id) qtde
			FROM UsersTracking
			WHERE url NOT LIKE "%/adm/%"
		) acessosTotal
		;';
$q = mysqli_query($link , $sql);
$r = mysqli_fetch_assoc($q);
$percentualAcessos = round((($r['acessosEssaSemana']*100)/$r['acessosSemanaPassada'])-100);
if($percentualAcessos > 0){
	$upDownAcessos = 'up';
	$corAcessos = 'success'; // Verde
}elseif($percentualAcessos < 0){
	$upDownAcessos = 'down';
	$corAcessos = 'danger'; // Vermelho
}else{
	$upDownAcessos = 'flat'; // Amarelo
	$corAcessos = 'warning';
}
$acessosGrafico2 = array(
		'titulo'=>'Page Views',
		'acessosSemanaPassada'=>$r['acessosSemanaPassada'],
		'acessosEssaSemana'=>$r['acessosEssaSemana'],
		'percentualAcessos'=>$percentualAcessos,
		'upDownAcessos'=>$upDownAcessos,
		'corAcessos'=>$corAcessos,
		'acessosTotal'=>$r['acessosTotal']
);

// FIM PRIMEIRO GRÁFICO ACESSOS
// Gráfico 2 - pedidos
$sql = 'SELECT
		(
			SELECT COUNT(id) qtde
			FROM Compras
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 15 DAY)
					AND DATE(dataHora) < DATE(NOW() - INTERVAL 7 DAY)
		) SemanaPassada
		,
		(
			SELECT COUNT(id) qtde
			FROM Compras
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 8 DAY)
		) EssaSemana
		,
		(
			SELECT COUNT(id) qtde
			FROM Compras
		) Total
		;';
$q = mysqli_query($link , $sql);
$r = mysqli_fetch_assoc($q);
if($r['SemanaPassada']==0 || $r['EssaSemana']==0){
	$percentual = 0;
}else{
	$percentual = round((($r['EssaSemana']*100)/$r['SemanaPassada'])-100);
}

if($percentual > 0){
	$upDown = 'up';
	$color = 'success'; // Verde
}elseif($percentual < 0){
	$upDown = 'down';
	$color = 'danger'; // Vermelho
}else{
	$upDown = 'flat'; // Amarelo
	$color = 'warning';
}
$comprasGrafico = array(
		'titulo'=>'Pedidos',
		'SemanaPassada'=>$r['SemanaPassada'],
		'EssaSemana'=>$r['EssaSemana'],
		'percentual'=>$percentual,
		'upDown'=>$upDown,
		'cor'=>$color,
		'Total'=>$r['Total']
);

// FIM 2 GRÁFICO Compras
// Gráfico 3 - Cadastros
$sql = 'SELECT
		(
			SELECT COUNT(id) qtde
			FROM Users
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 15 DAY)
					AND DATE(dataHora) < DATE(NOW() - INTERVAL 7 DAY)
					AND dataHora IS NOT NULL
		) SemanaPassada
		,
		(
			SELECT COUNT(id) qtde
			FROM Users
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 8 DAY)
			AND dataHora IS NOT NULL
		) EssaSemana
		,
		(
			SELECT COUNT(id) qtde
			FROM Users
			WHERE dataHora IS NOT NULL
		) Total
		;';
$q = mysqli_query($link , $sql);
$r = mysqli_fetch_assoc($q);
if($r['SemanaPassada']==0 || $r['EssaSemana']==0){
	$percentual = 0;
}else{
	$percentual = round((($r['EssaSemana']*100)/$r['SemanaPassada'])-100);
}

if($percentual > 0){
	$upDown = 'up';
	$color = 'success'; // Verde
}elseif($percentual < 0){
	$upDown = 'down';
	$color = 'danger'; // Vermelho
}else{
	$upDown = 'flat'; // Amarelo
	$color = 'warning';
}
$cadastroGrafico = array(
		'titulo'=>'Novos Cadastros',
		'SemanaPassada'=>$r['SemanaPassada'],
		'EssaSemana'=>$r['EssaSemana'],
		'percentual'=>$percentual,
		'upDown'=>$upDown,
		'cor'=>$color,
		'Total'=>$r['Total']
);

// FIM 3 GRÁFICO Cadastros
// Gráfico 4 - Newsletters
$sql = 'SELECT
		(
			SELECT COUNT(id) qtde
			FROM Newsletter
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 15 DAY)
					AND DATE(dataHora) < DATE(NOW() - INTERVAL 7 DAY)
					AND dataHora IS NOT NULL
		) SemanaPassada
		,
		(
			SELECT COUNT(id) qtde
			FROM Newsletter
			WHERE DATE(dataHora) > DATE(NOW() - INTERVAL 8 DAY)
			AND dataHora IS NOT NULL
		) EssaSemana
		,
		(
			SELECT COUNT(id) qtde
			FROM Newsletter
			WHERE dataHora IS NOT NULL
		) Total
		;';
$q = mysqli_query($link , $sql);
$r = mysqli_fetch_assoc($q);
if($r['SemanaPassada']==0 || $r['EssaSemana']==0){
	$percentual = 0;
}else{
	$percentual = round((($r['EssaSemana']*100)/$r['SemanaPassada'])-100);
}

if($percentual > 0){
	$upDown = 'up';
	$color = 'success'; // Verde
}elseif($percentual < 0){
	$upDown = 'down';
	$color = 'danger'; // Vermelho
}else{
	$upDown = 'flat'; // Amarelo
	$color = 'warning';
}
$newsGrafico = array(
		'titulo'=>'Assinaturas Newsletters',
		'SemanaPassada'=>$r['SemanaPassada'],
		'EssaSemana'=>$r['EssaSemana'],
		'percentual'=>$percentual,
		'upDown'=>$upDown,
		'cor'=>$color,
		'Total'=>$r['Total']
);

// FIM 4 GRÁFICO Newsletters

// Gráfico Linhas Vendas
$sql = 'SELECT ud.datas, formata_data(ud.datas) dataF ,IF(SUM(cxp.valor) IS NULL,0,SUM(cxp.valor)) tot
FROM ultimos7dias ud
LEFT JOIN Compras c ON DATE(c.dataHora) = DATE(ud.datas)
LEFT JOIN Compras_X_Produtos cxp ON cxp.idCompra  = c.id
GROUP BY ud.datas;';
$q = mysqli_query($link , $sql);
$values1 = array();
$labels1 = array();
$contaCor=0;
$color = $cor[$contaCor];
$values1[0] = array(
	'data'=>array(),
	// 'label'=>array(),
	'borderColor'=>$color,
	'backgroundColor'=>hex2rgba($color,0.9)
);

while($r = mysqli_fetch_array($q)){
	// gera o array para exbir como json no gráfico, pega uma cor aleatória
	$labels1[] = $r['dataF'];
	array_push($values1[0]['data'], $r['tot']);
	// array_push($values1[0]['label'], $r['dataF']);

}
// FIM Gráfico Pie Categorias Mais Compradas
// Gráfico 5 - Vendas Total
$sql = 'SELECT
		(
			SELECT SUM((cp.valor*cp.qtde)) tot
			FROM Compras c
			JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
			WHERE c.pago=1
			AND DATE(dataHora) > DATE(NOW() - INTERVAL 15 DAY)
			AND DATE(dataHora) < DATE(NOW() - INTERVAL 7 DAY)
		) SemanaPassada
		,
		(
			SELECT SUM((cp.valor*cp.qtde)) tot
			FROM Compras c
			JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
			WHERE c.pago=1
			AND DATE(c.dataHora) > DATE(NOW() - INTERVAL 8 DAY)
		) EssaSemana
		,
		(
			SELECT SUM((cp.valor*cp.qtde)) tot
			FROM Compras c
			JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
			WHERE c.pago=1
		) Total
		;';
$q = mysqli_query($link , $sql);
$r = mysqli_fetch_assoc($q);
if($r['SemanaPassada']==0 || $r['EssaSemana']==0){
	$percentual = 0;
}else{
	$percentual = round((($r['EssaSemana']*100)/$r['SemanaPassada'])-100);
}

if($percentual > 0){
	$upDown = 'up';
	$color = 'success'; // Verde
}elseif($percentual < 0){
	$upDown = 'down';
	$color = 'danger'; // Vermelho
}else{
	$upDown = 'flat'; // Amarelo
	$color = 'warning';
}
$vendasGrafico = array(
		'titulo'=>'Vendas Total',
		'SemanaPassada'=>$r['SemanaPassada'],
		'EssaSemana'=>$r['EssaSemana'],
		'percentual'=>$percentual,
		'upDown'=>$upDown,
		'cor'=>$color,
		'Total'=>$r['Total']
);

// FIM 4 GRÁFICO Newsletters
?>

<div class="wrapper">
	<div class="container">
		<!-- hotfix for title on mobile -->
		<br class="hidden-md hidden-lg" />
		<br class="hidden-md hidden-lg" />
		<!-- Titulo -->
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Dashboard <?php //echo session_cache_expire();?></h4>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-3 col-md-6">
					<div class="card-box">
							<h4 class="header-title"><?php echo $acessosGrafico2['titulo'];?></h4>
							<div class="widget-box-2">
									<div class="widget-detail-2">
											<span class="badge badge-<?php echo $acessosGrafico2['corAcessos'];?> pull-left m-t-20"><?php echo $acessosGrafico2['percentualAcessos'];?>% <i
															class="zmdi zmdi-trending-<?php echo $acessosGrafico2['upDownAcessos'];?>"></i> </span>
											<div class="table-responsive" style="padding-left:15px;">
											 <table align="right" class="table">
													 <tr>
															 <td align="left" width="200">Semana passada</td>
																 <td align="right"><?php echo number_format($acessosGrafico2['acessosSemanaPassada'],0,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Nesta semana</td>
																 <td align="right"><?php echo number_format($acessosGrafico2['acessosEssaSemana'],0,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Total</td>
																 <td align="right"><?php echo number_format($acessosGrafico2['acessosTotal'],0,',','.'); ?></td>
														 </tr>
												 </table>
											</div>
									</div>
							</div>
					</div>
			</div><!-- end grafico 1 -->
			<div class="col-lg-3 col-md-6">
					<div class="card-box">
							<h4 class="header-title"><?php echo $comprasGrafico['titulo'];?></h4>
							<div class="widget-box-2">
									<div class="widget-detail-2">
											<span class="badge badge-<?php echo $comprasGrafico['cor'];?> pull-left m-t-20"><?php echo $comprasGrafico['percentual'];?>% <i
															class="zmdi zmdi-trending-<?php echo $comprasGrafico['upDown'];?>"></i> </span>
											<div class="table-responsive" style="padding-left:15px;">
											 <table align="right" class="table">
													 <tr>
															 <td align="left" width="200">Semana passada</td>
																 <td align="right"><?php echo number_format($comprasGrafico['SemanaPassada'],0,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Nesta semana</td>
																 <td align="right"><?php echo number_format($comprasGrafico['EssaSemana'],0,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Total</td>
																 <td align="right"><?php echo number_format($comprasGrafico['Total'],0,',','.'); ?></td>
														 </tr>
												 </table>
											</div>
									</div>
							</div>
					</div>
			</div><!-- end grafico 2-->
			<div class="col-lg-3 col-md-6">
					<div class="card-box">
							<h4 class="header-title"><?php echo $cadastroGrafico['titulo'];?></h4>
							<div class="widget-box-2">
									<div class="widget-detail-2">
											<span class="badge badge-<?php echo $cadastroGrafico['cor'];?> pull-left m-t-20"><?php echo $cadastroGrafico['percentual'];?>% <i
															class="zmdi zmdi-trending-<?php echo $cadastroGrafico['upDown'];?>"></i> </span>
											<div class="table-responsive" style="padding-left:15px;">
											 <table align="right" class="table">
													 <tr>
															 <td align="left" width="200">Semana passada</td>
																 <td align="right"><?php echo number_format($cadastroGrafico['SemanaPassada'],0,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Nesta semana</td>
																 <td align="right"><?php echo number_format($cadastroGrafico['EssaSemana'],0,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Total</td>
																 <td align="right"><?php echo number_format($cadastroGrafico['Total'],0,',','.'); ?></td>
														 </tr>
												 </table>
											</div>
									</div>
							</div>
					</div>
			</div><!-- end grafico 3-->
			<div class="col-lg-3 col-md-6">
					<div class="card-box">
							<h4 class="header-title"><?php echo $newsGrafico['titulo'];?></h4>
							<div class="widget-box-2">
									<div class="widget-detail-2">
											<span class="badge badge-<?php echo $newsGrafico['cor'];?> pull-left m-t-20"><?php echo $newsGrafico['percentual'];?>% <i
															class="zmdi zmdi-trending-<?php echo $newsGrafico['upDown'];?>"></i> </span>
											<div class="table-responsive" style="padding-left:15px;">
											 <table align="right" class="table">
													 <tr>
															 <td align="left" width="200">Semana passada</td>
																 <td align="right"><?php echo number_format($newsGrafico['SemanaPassada'],2,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Nesta semana</td>
																 <td align="right"><?php echo number_format($newsGrafico['EssaSemana'],2,',','.'); ?></td>
														 </tr>
													 <tr>
															 <td align="left">Total</td>
																 <td align="right"><?php echo number_format($newsGrafico['Total'],2,',','.'); ?></td>
														 </tr>
												 </table>
											</div>
									</div>
							</div>
					</div>
			</div><!-- end grafico 3-->


		</div> <!-- end row -->
		<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="card-box ">
						<h4 class="header-title m-t-0">Vendas Semana</h4>
						<canvas id="grafico1" height="70" style="height:50px;"></canvas>
						<!-- <canvas id="grafico1" height="<?php echo $size; ?>" style="height:<?php echo $size; ?>px;"></canvas> -->
						<ul class="list-inline chart-detail-list m-b-0" style="text-align:center;">
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
						<div class="card-box">
								<h4 class="header-title"><?php echo $vendasGrafico['titulo'];?></h4>
								<div class="widget-box-2" style="display:list-item; list-style:none;">
										<div class="widget-detail-2">
												<span class="badge badge-<?php echo $vendasGrafico['cor'];?> pull-left m-t-20"><?php echo $vendasGrafico['percentual'];?>% <i
																class="zmdi zmdi-trending-<?php echo $vendasGrafico['upDown'];?>"></i> </span>
												<div class="table-responsive" style="padding-left:15px;">
												 <table align="right" class="table">
														 <tr>
																 <td align="left" width="200">Semana passada</td>
																	 <td align="right">R$ <?php echo number_format($vendasGrafico['SemanaPassada'],2,',','.'); ?></td>
															 </tr>
														 <tr>
																 <td align="left">Nesta semana</td>
																	 <td align="right">R$ <?php echo number_format($vendasGrafico['EssaSemana'],2,',','.'); ?></td>
															 </tr>
														 <tr>
																 <td align="left">Total</td>
																	 <td align="right">R$ <?php echo number_format($vendasGrafico['Total'],2,',','.'); ?></td>
															 </tr>
													 </table>
												</div>
										</div>
								</div>
						</div>
				</div><!-- end grafico 3-->
		</div> <!-- end row -->

		<div class="row">
			<div class="col-lg-6 col-xs-6">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Últimos Pedidos <i class="fa fa-archive"></i></h4>

					<div class="inbox-widget table-responsive" style="height: 380px;">
						<table class="table">
							<thead>
								<tr>
									<th>Data/Hora Compra</th>
									<th>Cliente</th>
									<th>Pago</th>
									<th>Enviado</th>
									<th>Entregue</th>
									<th>Total</th>
									<th>+Informações</th>
								</tr>
								<thead>
									<tbody>
										<?php
										$sqlUltimosPedidos = 'SELECT
											c.id,
											formata_data_hora(c.dataHora) dataHora,
											u.nome,
											IF(c.pago=1,"Sim","Não") pago,
											IF(c.enviado=1,"Sim","Não") enviado,
											IF(c.entregue=1,"Sim","Não") entregue,
											(SELECT SUM(valor * qtde ) FROM Compras_X_Produtos cxp WHERE cxp.idCompra=c.id) total, tc.preco_frete
										FROM Compras c
										JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes AND tc.selecionado = 1
										JOIN Users u ON u.id = c.idUser
										ORDER BY c.dataHora DESC
										LIMIT 8;';
										$q = mysqli_query($link, $sqlUltimosPedidos);
										while($r = mysqli_fetch_assoc($q)){
											echo '<tr class="inbox-item">';
											echo '<td>'.$r['dataHora'].'</td>';
											echo '<td>'.$r['nome'].'</td>';
											echo '<td>'.$r['pago'].'</td>';
											echo '<td>'.$r['enviado'].'</td>';
											echo '<td>'.$r['entregue'].'</td>';
											echo '<td>'.formata_real($r['preco_frete'] + $r['total']).'</td>';
											echo '<td><a href="'.$site.'adm/pedidos/pedido.php?id='.$r['id'].'" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>';
											echo '</tr>';
										}
										?>
									</tbody>
								</table>

							</div>
						</div>
					</div>

					<div class="col-lg-6 col-xs-6">
						<div class="card-box">
							<h4 class="header-title m-t-0 m-b-30">A Enviar <i class="fa fa-check"></i></h4>

							<div class="inbox-widget table-responsive" style="height: 380px;">
								<table class="table">
									<thead>
										<tr>
											<th>Data/Hora Compra</th>
											<th>Cliente</th>
											<th>Enviado</th>
											<th>Total</th>
											<th>+Informações</th>
										</tr>
										<thead>
											<tbody>
												<?php
												$sqlUltimosPedidos = 'SELECT
													c.id,
													u.nome,
													formata_data_hora(c.dataHora) dataHora,
													IF(c.enviado=1,"Sim","Não") enviado,
													(SELECT SUM(valor*qtde) FROM Compras_X_Produtos cxp WHERE cxp.idCompra=c.id) total, tc.preco_frete
												FROM Compras c
												JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes AND tc.selecionado = 1 AND c.pago = 1
												JOIN Users u ON u.id = c.idUser
												WHERE c.enviado = 0
												AND c.entregue = 0
												ORDER BY c.dataHora DESC
												LIMIT 8;';
												$q = mysqli_query($link, $sqlUltimosPedidos);
												while($r = mysqli_fetch_assoc($q)){
													echo '<tr class="inbox-item">';
													echo '<td>'.$r['dataHora'].'</td>';
													echo '<td>'.$r['nome'].'</td>';
													echo '<td>'.$r['enviado'].'</td>';
													echo '<td>'.formata_real($r['preco_frete'] + $r['total']).'</td>';
													echo '<td><a href="'.$site.'adm/pedidos/pedido.php?id='.$r['id'].'" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>';
													echo '</tr>';
												}
												?>
											</tbody>
										</table>

									</div>
								</div>
							</div>
		</div> <!-- end row -->



		</div> <!-- end row -->

	</div><!-- Final wrapper -->
</div><!-- Final container -->

<!-- Final da página -->

<!-- jQuery  -->
<?php
require_once($siteHD.'adm/rodape.php');
require_once($siteHD.'adm/js.php');
?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {



});

</script>
<!-- Graficos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>

// INIT
// Grafico 1
var ctx1 = $("#grafico1");
var ctx1 = document.getElementById("grafico1");
var ctx1 = document.getElementById("grafico1").getContext("2d");
var grafico1 = new Chart(ctx1, {
	type: 'line',
	data: {
		labels: <?php echo json_encode($labels1); ?>,
		datasets: <?php echo json_encode($values1); ?>
	},
	options: {
		legend: {
			display: false
		},
		tooltips: {
        callbacks: {
            label: function(tooltipItem, data) {
                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                label += (Math.round(tooltipItem.yLabel * 100) / 100).toFixed(2);
                return 'R$ '+label;
            }
        }
    }
	}
});


</script>
