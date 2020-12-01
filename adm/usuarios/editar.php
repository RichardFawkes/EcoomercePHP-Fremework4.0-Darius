<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");

?>


<style>

output {
  padding-top: 15px;
}
.thumb-image{
  width: 50%;
  max-width: 50%;
}

</style>
<div class="wrapper">
  <div class="container">
    <!-- Titulo -->
    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Informações Usuário</h4>
      </div>
    </div>
    <?php
      $sql = "SELECT u.nome, u.email, formata_data_hora(u.dataHora) dataHora
      FROM Users u
      WHERE u.id=".$_GET['id'];
      $res = mysqli_query($link, $sql);
      $r = mysqli_fetch_array($res);
    ?>
    <!-- Formulário -->
    <div class="row">
      <div class="card-box">

          <div class="row">
            <div class="form-group col-md-4">
              <label>Nome</label>
              <input name="name" type="text" class="form-control" value="<?php echo $r['nome']; ?>" disabled>
            </div>
            <div class="form-group col-md-4">
              <label>Email</label>
              <input name="email" type="text" class="form-control" value="<?php echo $r['email']; ?>" disabled>
            </div>
            <div class="form-group col-md-4">
              <label>Data/Hora Cadastro</label>
              <input  type="text" class="form-control" value="<?php echo $r['dataHora']; ?>" disabled>
            </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Endereços/Tipo</h4>
      </div>
    </div>

    <div class="row">
      <div class="card-box table-responsive">
        <table id="tabela" class="table table-striped">
          <thead>
              <th>Título</th>
              <th>Tipo Pessoa</th>
              <th>Nome (Doc.)</th>
              <th>Endereço</th>
              <th>Cidade/UF</th>
              <th>CEP</th>
              <th>Telefone</th>
              <th>Email</th>
              <th>Status</th>
          </thead>
          <?php
            $sql2 = 'SELECT uxe.id, c.cidade, e.sigla, CONCAT(uxe.nome," ",uxe.sobrenome, " (",uxe.cpf,")") nome,
            uxe.email, CONCAT(uxe.empresa," (", uxe.cnpj,")") empresa, uxe.inscricao_estadual, uxe.telefone,
            uxe.cep, uxe.logradouro, uxe.numero, uxe.complemento, uxe.bairro, uxe.titulo, uxe.tipo_pessoa, uxe.ativo
            FROM Users_X_Enderecos uxe
            JOIN CidadesIBGE c ON c.id = uxe.idCidade
            JOIN Estados e ON e.id = uxe.idEstado
            WHERE uxe.idUser = '.$_GET['id'];
            $res2 = mysqli_query($link,$sql2);
            while($r2 = mysqli_fetch_array($res2)){
              echo '<tr>';
              echo '<td>'.$r2['titulo'].'</td>';
              echo '<td>'.$r2['tipo_pessoa'].'</td>';
              if($r2['tipo_pessoa']=='PJ'){
                echo '<td>'.ucwords(mb_strtolower($r2['empresa'])).'</td>';
              }else{
                echo '<td>'.ucwords(mb_strtolower($r2['nome'])).'</td>';
              }

              echo '<td>'.$r2['logradouro'].', '.$r2['numero'].' - '.$r2['bairro'].' | '.$r2['complemento'].'</td>';
              echo '<td>'.ucwords(mb_strtolower($r2['cidade'])).'/'.$r2['sigla'].'</td>';
              echo '<td>'.$r2['cep'].'</td>';
              echo '<td>'.$r2['telefone'].'</td>';
              echo '<td>'.$r2['email'].'</td>';
              if($r2['ativo']==1){
                echo '<td>Ativo</td>';
              }else{
                echo '<td>Desativado</td>';
              }
              echo '</tr>';
            }

          ?>
        </table>
      </div>
    </div>


    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Compras Realizadas</h4>
      </div>
    </div>

    <div class="row">
      <div class="card-box table-responsive">
        <table id="tabela2" class="table table-striped">
          <thead>
              <th>#</th>
              <th>Data/Hora</th>
              <th>Endereço</th>
              <th>Preço Frete</th>
              <th>Qtde. Produtos</th>
              <th>Total</th>
  						<th>Pago</th>
  						<th>Produção</th>
  						<th>Enviado</th>
  						<th>Entregue</th>
              <th>Total Compra</th>
          </thead>
          <?php
            $sql2 = 'SELECT c.id, uxe.titulo, formata_data_hora(c.dataHora) dataHora, t.preco_frete,
            SUM(cxp.qtde) qtdeTot, SUM(cxp.valor*cxp.qtde) total,(SUM(cxp.valor*cxp.qtde)+t.preco_frete) totalCompra, c.pago, c.enviado, c.entregue, c.statusProducao
            FROM Compras c
            JOIN Users_X_Enderecos uxe ON uxe.id = c.idUsers_X_Enderecos
            JOIN Transportadoras_Cotacoes t ON t.id = c.idTransportadoras_Cotacoes AND t.selecionado=1
            JOIN Compras_X_Produtos cxp ON cxp.idCompra = c.id
            WHERE c.idUser = '.$_GET['id'].'
            GROUP BY c.id
            ';
            $res2 = mysqli_query($link,$sql2);
            while($r2 = mysqli_fetch_array($res2)){
              if($r2['pago']==0){
                // $status1 = "Não Pago";
                $status1 = '<button id="pay_'.$r2['id'].'" class="btn btn-warning pay" disabled><i class="fa fa-remove"></i></button>';
              }else{
                $status1 = '<button id="pay_'.$r2['id'].'" class="btn btn-success pay" disabled><i class="fa fa-check"></i></button>';
                // $status1 = "Pago";
              }
              if($r2['statusProducao']==0){
                // $status2 = "Não Produzido";
                $status2 = '<button id="spr_'.$r2['id'].'" class="btn btn-warning spr" disabled><i class="fa fa-remove"></i></button>';
              }else{
                // $status2 = "Produzido";
                $status2 = '<button id="spr_'.$r2['id'].'" class="btn btn-success spr" disabled><i class="fa fa-check"></i></button>';
              }
              if($r2['enviado']==0){
                // $status3 = "Não Enviado";
                $status3 = '<button id="sen_'.$r2['id'].'" class="btn btn-warning sen" disabled><i class="fa fa-remove"></i></button>';
              }else{
                // $status3 = "Enviado";
                $status3 = '<button id="sen_'.$r2['id'].'" class="btn btn-success sen" disabled><i class="fa fa-check"></i></button>';
              }
              if($r2['entregue']==0){
                // $status4 = "Não Entregue";
                $status4 = '<button id="ent_'.$r2['id'].'" class="btn btn-warning ent" disabled><i class="fa fa-remove"></i></button>';
              }else{
                // $status4 = "Entregue";
                $status4 = '<button id="ent_'.$r2['id'].'" class="btn btn-success ent" disabled><i class="fa fa-check"></i></button>';
              }

              echo '<tr>';
              echo '<td><a href="'.$site.'adm/pedidos/pedido.php?id='.$r2['id'].'" class="btn btn-default">'.$r2['id'].'</a></td>';
              echo '<td>'.$r2['dataHora'].'</td>';
              echo '<td>'.$r2['titulo'].'</td>';
              echo '<td class="money">'.$r2['preco_frete'].'</td>';
              echo '<td>'.$r2['qtdeTot'].'</td>';
              echo '<td class="money">'.$r2['total'].'</td>';
              echo "<td>".$status1."</td>";
              echo "<td>".$status2."</td>";
              echo "<td>".$status3."</td>";
              echo "<td>".$status4."</td>";
              echo '<td class="money">'.$r2['totalCompra'].'</td>';
              echo '</tr>';
            }

          ?>
        </table>
      </div>
    </div>

  </div> <!-- container -->
</div> <!-- wrapper -->

<!-- Final da página -->
<?php
require_once($siteHD.'adm/rodape.php');
require_once($siteHD.'adm/js.php');
?>



<script>

$('.money').mask('000.000.000.000.000,00', {reverse: true});
$('.money2').mask("#.##0,00", {reverse: true});
$('#tabela').DataTable();
$('#tabela2').DataTable();

</script>
</body>
</html>
