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
        <h4 class="page-title">Pedido: #<?php echo $_GET['id'];?></h4>
      </div>
    </div>
    <?php
      $sqlC = 'SELECT *
        FROM Compras c
        WHERE c.id = '.$_GET['id'].';';
      $resC = mysqli_query($link, $sqlC);
      $rowC = mysqli_fetch_array($resC);


      $sqlU = 'SELECT u.nome, u.email, u.cpf, u.cnpj, u.inscricao_estadual,
       formata_data_hora(u.dataHora) dataHora
      FROM Users u 
      WHERE u.id='.$rowC['idUser'].';';
      $resU = mysqli_query($link, $sqlU);
      $rowU = mysqli_fetch_array($resU);

      $sqlEnd = 'SELECT  *
      FROM Users_X_Enderecos u
      JOIN CidadesIBGE c ON c.id = u.idCidade
      JOIN Estados e ON e.id = u.idEstado
      WHERE u.id='.$rowC['idUsers_X_Enderecos'].';';
      $resEnd = mysqli_query($link, $sqlEnd);
      $rowEnd = mysqli_fetch_array($resEnd);

    ?>
    <!-- Formulário -->
    <div class="row">
      <div class="card-box">
        <h5>Informações Usuário</h5>
        <div class="row">
          <div class="col-md-4">
            <label>Nome Completo:</label> <?php echo $rowEnd['nome']; ?> <?php echo $rowEnd['sobrenome']; ?>
          </div>
          <div class="col-md-4">
            <label>Email:</label> <?php echo $rowU['email']; ?>
          </div>
          <div class="col-md-4">
            <label>Data/Hora Cadastro:</label> <?php echo $rowU['dataHora']; ?>
          </div>

        </div>
        <br>
        <h5>Informações Entrega</h5>
        <div class="row">
          <?php if (!is_null($rowEnd['cpf'])) { ?>
          <div class="col-md-4">
            <label>CPF:</label> <?php echo $rowEnd['cpf']; ?>
          </div>
          <?php } ?>
            <?php if (!is_null($rowEnd['cnpj'])) { ?>
            <div class="col-md-4">
              <label>CNPJ:</label> <?php echo $rowEnd['cnpj']; ?>
            </div>
            <div class="col-md-4">
              <label>Inscrição Estadual:</label> <?php echo $rowEnd['inscricao_estadual']; ?>
            </div>
            <div class="col-md-4">
              <label>Nome Empresa:</label> <?php echo $rowEnd['empresa']; ?>
            </div>
          <?php } ?>
          <div class="col-md-4">
            <label>Telefone:</label> <?php echo $rowEnd['telefone']; ?>
          </div>
          <div class="col-md-4">
            <label>CEP:</label> <?php echo $rowEnd['cep']; ?>
          </div>

          <div class="col-md-4">
            <label>Endereço:</label> <?php echo $rowEnd['logradouro']; ?>, <?php echo $rowEnd['numero']; if ($rowEnd['complemento']!='') {
        echo ' - '.$rowEnd['complemento'];
    }?>
          </div>
          <div class="col-md-4">
            <label>Bairro:</label> <?php echo $rowEnd['bairro']; ?>
          </div>
          <div class="col-md-4">
            <label>Cidade:</label> <?php echo $rowEnd['cidade']; ?>
          </div>
          <div class="col-md-4">
            <label>Estado:</label> <?php echo $rowEnd['estado']; ?>
          </div>
        </div>
      </div>
      </div>
        
      <div class="row">
        <div class="col-sm-12">
          <h4 class="page-title">Transporte</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="card-box">
          <?php
          $sqlFrete = 'SELECT *
          FROM Transportadoras_Cotacoes tc
          JOIN Transportadoras t ON t.id = tc.idTransportadora
          WHERE tc.id='.$rowC['idTransportadoras_Cotacoes'];
          $resFrete = mysqli_query($link, $sqlFrete);
          $rowFrete = mysqli_fetch_array($resFrete);

          ?>
        
          
       <?php
       
       if ($rowFrete['transportadora'] == '') {
           echo '<div class="row">
             <div class="col-md-6">
               <label><i class="fa fa-building fa-2x"></i> RETIRAR NA LOJA</label><span class="span01">
               Rua Robert Bosch, 469 - Parque Industrial Tomas Edson - São Paulo - SP</span> </label> <br>
             </div>
             <div class="col-md-6">
               <label>Tipo:</label>  RETIRAR
             </div>
             <div class="col-md-6">
               <label>Prazo de Entrega:</label> 2 Dias
             </div>
             <div class="col-md-6">
               <label>Valor do Frete:</label> GRATIS
             </div>
           </div>
         ';
       } else {
           echo ' <div class="row">
                 <div class="col-md-6">
                   <label>Transportadora:</label>  '.$rowFrete['transportadora'].'
                 </div>
                 <div class="col-md-6">
                   <label>Tipo:</label> '.$rowFrete['servico'].'
                 </div>
                 <div class="col-md-6">
                   <label>Prazo de Entrega:</label> '. $rowFrete['prazo_entrega'].' dias
                 </div>
                 <div class="col-md-6">
                   <label>Valor do Frete:</label> '.formata_real($rowFrete['preco_frete']).'
                 </div>
               </div>
             ';
       }
 ?>
 </div>
<?php

$sqli = 'SELECT * FROM Cupons WHERE cupomName = "'.$rowC['idCupom'].'"';
$sqc = mysqli_query($link, $sqli);
$rowresult = mysqli_fetch_assoc($sqc);

if ($rowresult['fretegratis'] == 1) {
    $fretecupom = 'Sim';
} else {
    $fretecupom = 'Não';
}

?>

      <div class="row">
        <div class="col-sm-12">
          <h4 class="page-title">Cupom desconto </h4>
            <div class="card-box">
            <div class="row">
            <div class="col-md-6">
                <label> CUPOM UTILIZADO:</label>   <label class="btn btn-info"><i class="fa fa-ticket"></i> <?php echo $rowC['idCupom']?></label>
                 </div>
                 <div class="col-md-6">
                   <label>Frete Gratis:</label> <label class="btn btn-warning"><i class="fa fa-ticket"></i> <?php echo $fretecupom?></label>
                 </div>



                 </div>
  </div>
  <div class="row">
  <div class="col-sm-12">
  <h4 class="page-title">Link Pagamento</h4>

  <div class="card-box">

<input id="seuTxt"   class="btn btn-info" value="<?php echo $site?>pagamentocliente?id=<?php echo $_GET['id']?>" />
<input type="button" class="btn btn-success" id="linkpag" value="COPIAR LINK" />
<br>
link de pagamento direto para cliente

</form>


<div>
<div class="alert alert-success fade out" id="bsalert">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Link Copiado!</strong>
</div>

                 </div>
                 </div>


              
</div>
        </div>
      </div>
      <h4 class="page-title">Pagamento</h4>

      <div class="row">
        <div class="card-box table-responsive">
<?php
    $sqlVT = 'SELECT SUM(cp.valor * qtde) total , tc.preco_frete, c.parcelas
FROM Compras c
JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
JOIN Transportadoras_Cotacoes tc ON tc.id = c.idTransportadoras_Cotacoes AND tc.selecionado = 1
WHERE c.id = '.$_GET['id'].';';
    $qVT = mysqli_query($link, $sqlVT);
    $rVT = mysqli_fetch_assoc($qVT);
    

    $sqlVTs = 'SELECT SUM(cp.valor * qtde) total, c.parcelas,cp.valor
FROM Compras c
JOIN Compras_X_Produtos cp ON cp.idCompra = c.id
WHERE c.id = '.$_GET['id'].';';
    $qVTs = mysqli_query($link, $sqlVTs);
      $rVTs = mysqli_fetch_assoc($qVTs);

          $sqlPag = 'SELECT *,c.pago,formata_data_hora(cxi.dataHora) dataHora
          FROM Compras_X_Invoices cxi
          JOIN Compras c ON cxi.idCompra = c.id
          WHERE cxi.idCompra='.$_GET['id'].';';
          $resPag = mysqli_query($link, $sqlPag);
          
          ?>
        <table id="tabelapgto" class="table table-striped">
          <thead>
            <th>#ID Transação</th>
            <th>Data/Hora</th>
            <th>Método</th>
	    <th>Informação</th>
	    <th>Frete</th>
	    <th>Vl. Produtos</th>
	    <th>Total</th>
	    <th>Parcelas</th>
            <th>Status</th>
            <th>Acao</th>

          </thead>
          <!-- Botão para acionar modal -->

<!-- Modal -->
<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">AVISO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
      
        </button>
      </div>
      <div class="modal-body">
      Deseja realmente cancelar este pedido?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <a class="btn btn-danger" href="alterap.php?id=<?php echo $_GET['id'];?> ">CANCELAR</a>
      </div>
    </div>
  </div>
</div>
          <tbody>
            <?php
            
            while ($rowPag = mysqli_fetch_array($resPag)) {
                if ($rowPag['pago']== 1) {
                    $status = "<span style='color:green;'><i class='fa fa-check-circle'></i> Aprovado</span>";
                    $transactionID = $rowPag['transactionID'];
                } elseif ($rowPag['pago']== 3) {
                    $status = "<span style='color:red;'><i class='fa fa-times-circle'></i> CANCELADO</span>";
                    $transactionID = $rowPag['transactionID'];
                } elseif (!is_null($rowPag['dataPgto'])) {
                    $status = '<span style="color:green;">Aprovado</span>';
                    $transactionID = $rowPag['transactionID'];
                } else {
                    $status = '<span style="color:red;"><i class="fa fa-times-circle"></i> Não aprovado</span>';
                    $transactionID = '';
                    $cc = '';
                }
                if ($rowPag['processorName']== 'REDE') {
                    $cc = "<i class='fa fa-credit-card'></i> " .$rowPag['creditCardScheme']." (**** **** **** ".$rowPag['creditCardLast4'].") ";
                } else {
                    $cc = "</i><a href='".$rowPag['boletoUrl']."' target='_blank' class='btn btn-info'><i class='fa fa-barcode'></i> Ver Boleto</a>";
                }

                echo '<tr style=" font-weight: bold;">';
                echo '<td>'.$transactionID.'</td>';
                echo '<td>'.$rowPag['dataHora'].'</td>';
                echo '<td>'.$rowPag['processorName'].'</td>';
                echo '<td>'.$cc.'</td>';
                if ($rVT['preco_frete'] == '') {
                    echo '<td>GRATIS</td>';
                    echo '<td>'.formata_real($rVTs['valor']).'</td>';
                    echo '<td>'.formata_real($rVTs['total'] + $rVT['total']).'</td>';
                    echo '<td>'.$rVT['parcelas'].'</td>';
                } else {
                    echo '<td>'.formata_real($rVT['preco_frete']).'</td>';
                    echo '<td>'.formata_real($rVT['total']).'</td>';
                    echo '<td>'.formata_real($rVT['preco_frete'] + $rVT['total']).'</td>';
                    echo '<td>'.$rVTs['parcelas'].'</td>';
                }
                echo '<td>'.$status.'</td>';
                echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ExemploModalCentralizado">
              CANCELAR
            </button></td>';
                echo '</tr>';
            }
          ?>

          </tbody>
          </table>
        </div>
      </div>



    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Produtos</h4>
      </div>
    </div>
    <?php
    $sqlPed = 'SELECT *, cxp.idProjeto idarte
    FROM Compras_X_Produtos cxp
    JOIN Produtos p ON p.id = cxp.idProduto
    JOIN Cores c ON c.id = cxp.idCorTampa
    WHERE cxp.idCompra='.$_GET['id'].';';
    $resPed = mysqli_query($link, $sqlPed);
    
    
  

    $sqlproje = 'SELECT idProjeto FROM Compras_X_Produtos WHERE idCompra = "'.$_GET['id'].'"
    
    ';

    $resproj = mysqli_query($link, $sqlproje);
    $rowproje  = mysqli_fetch_array($resproj);


    $id = $rowproje['idProjeto'];

    
     ?>
    <div class="row">
      <div class="card-box table-responsive">
      <table id="tabelaprod" class="table table-striped">
        <thead>
          <th>#</th>
          <th width="50">Imagem</th>
          <th width="50">Projeto</th>
          <th>PDF</th>
          <th>Produto</th>
          <th>Cor Tampa</th>
          <th>Quantidade</th>
          <th>Valor Un.</th>
          <th>Valor Total</th>
          <th>Prazo Producao</th>

        </thead>
        <tbody>
          <?php
          
          if ($rowproje['idProjeto']!= null) {
              while ($rowPed = mysqli_fetch_array($resPed)) {
                  echo '<tr>';
                  echo '<td>'.$rowPed['idProduto'].'</td>';
                  echo '<td><img src="'.$site.'images/product/mini/'.$rowPed['img'].'" class="img-thumbnail" width="50"/></td>';
                  echo '<td><img src="'.$editorview.''.$rowPed['idarte'].'" class="img-thumbnail" width="100"/></td>';
                  echo '<td><a class="btn btn-success" href="'.$editorpdf. $rowPed['idarte'].'"><i class="fa fa-download"></i> DOWNLOAD</a></td>';
                  echo '<td><a href="'.$site.'produto/'.$rowPed['url'].'" target="_blank">'.$rowPed['titulo'].'</a></td>';

                  echo '<td>'.$rowPed['cor'].'</td>';
                  echo '<td>'.$rowPed['qtde'].'</td>';
                  echo '<td>'.formata_real($rowPed['valor']).'</td>';
                  echo '<td>'.formata_real($rowPed['valor']*$rowPed['qtde']).'</td>';
                  echo '<td>'.$rowPed['prazo_producao'].' Dias</td>';
                  echo '</tr>';

              }
          }
           if ($rowproje['idProjeto']==null) {
               while ($rowPed = mysqli_fetch_array($resPed)) {
                   echo '<tr>';
                   echo '<td>'.$rowPed['idProduto'].'</td>';
                   echo '<td><img src="'.$site.'images/product/mini/'.$rowPed['img'].'" class="img-thumbnail" width="50"/></td>';
                   echo '<td>N/D</td>';
                   echo '<td>N/D</td>';
                   echo '<td><a href="'.$site.'produto/'.$rowPed['url'].'" target="_blank">'.$rowPed['titulo'].'</a></td>';

                   echo '<td>'.$rowPed['cor'].'</td>';
                   echo '<td>'.$rowPed['qtde'].'</td>';
                   echo '<td>'.formata_real($rowPed['valor']).'</td>';
                   echo '<td>'.formata_real($rowPed['valor']*$rowPed['qtde']).'</td>';
                   echo '<td>'.$rowPed['prazo_producao'].' Dias</td>';

                   echo '</tr>';

               }
           }
          ?>
        </tbody>
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
		<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>

		<script type="text/javascript">
		  $(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();

				$('.money').mask('000.000.000.000.000,00', {reverse: true});
  			$('.money2').mask("#.##0,00", {reverse: true});


		    $('#tabelapgto').DataTable();

		    $('#tabelaprod').DataTable();

		  });


      $('#linkpag').click(function(){
        //Visto que o 'copy' copia o texto que estiver selecionado, talvez você queira colocar seu valor em um txt escondido
    $('#seuTxt').select();
    try {
            var ok = document.execCommand('copy');
        } catch (e) {
        alert(e)
    }
});
function toggleAlert(){
    $(".alert").toggleClass('in out'); 
    return false; // Keep close.bs.alert event from removing from DOM
}


$("#linkpag").on("click", toggleAlert);
$('#bsalert').on('close.bs.alert', toggleAlert)
		</script>

	</body>
	</html>
