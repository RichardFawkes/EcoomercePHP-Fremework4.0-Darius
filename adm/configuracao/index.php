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
        <h4 class="page-title">Configurações</h4>
      </div>
    </div>
    <?php

      $sql = "SELECT * FROM Configuracao";
      $res = mysqli_query($link,$sql);

      ?>
    <!-- Formulário -->
    <div class="row">
      <div class="card-box">
        <form action="atualiza" method="POST">
        <?php
        while($r = mysqli_fetch_array($res)){
          ?>
          <div class="row">

            <div class="form-group col-md-12">
              <label><?php echo $r['tipo']; ?></label>
              <input name="<?php echo $r['chave']; ?>" type="text" class="form-control" value="<?php echo $r['valor']; ?>" >
            </div>
          </div>
        <?php } ?>
          <div class="row">
            <input type="submit" value="Salvar" class="btn btn-success">
          </div>
        </form>

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
