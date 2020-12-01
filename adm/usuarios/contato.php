<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");

?>

<div class="wrapper">
  <div class="container">
    <!-- Titulo -->
    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Informações do Contato</h4>
      </div>
    </div>
    <?php
      $upd = 'UPDATE Contatos SET visualizado=1 WHERE id='.$_GET['id'];
      mysqli_query($link,$upd);

      $sql = "SELECT id, nome, email, telefone, assunto, formata_data_hora(dataHora) dataHora, visualizado, mensagem,local_entrega, produto, quantidade, envazado, tipo, tamanho FROM Contatos WHERE id=".$_GET['id'];
      $res = mysqli_query($link,$sql);
      $r = mysqli_fetch_array($res);
      ?>
    <!-- Formulário -->
    <div class="row">
      <div class="card-box">

          <div class="row">
            <div class="form-group col-md-4">
              <label>Nome</label>
              <input name="name" type="text" class="form-control" value="<?php echo $r['nome']; ?>" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Email</label>
              <input name="email" type="text" class="form-control" value="<?php echo $r['email']; ?>" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Telefone</label>
              <input name="telefone" type="text" class="form-control" value="<?php echo $r['telefone']; ?>" readonly>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-4">
              <label>Assunto</label>
              <input name="local" type="text" class="form-control" value="<?php echo $r['assunto']; ?>" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Local de Entrega</label>
              <input name="date_create" type="text" class="form-control" value="<?php echo $r['local_entrega']; ?>" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Data do Contato</label>
              <input name="date_create" type="text" class="form-control" value="<?php echo $r['dataHora']; ?>" readonly>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label>Produto</label>
              <input name="produto" type="text" class="form-control" value="<?php echo $r['produto']; ?>" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Produto a Envazar</label>
              <input name="produto" type="text" class="form-control" value="<?php echo $r['envazado']; ?>" readonly>
            </div>
            <div class="form-group col-md-2">
              <label>Quantidade</label>
              <input name="produto" type="text" class="form-control" value="<?php echo $r['quantidade']; ?>" readonly>
            </div>
            <div class="form-group col-md-2">
              <label>Tipo</label>
              <input name="tipo" type="text" class="form-control" value="<?php echo $r['tipo']; ?>" readonly>
            </div>

          </div>
          <div class="row">
            <div class="form-group col-md-12">
            <textarea readonly class="form-control" rows="10"><?php echo $r['mensagem']; ?></textarea>
            </div>
          </div>


      </div>
    </div>


  </div> <!-- container -->
</div> <!-- wrapper -->

<!-- Final da página -->
<?php
require_once($siteHD.'adm/rodape.php');
require_once($siteHD.'adm/js.php');
?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
