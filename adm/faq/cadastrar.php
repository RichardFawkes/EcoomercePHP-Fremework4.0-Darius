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
        <h4 class="page-title">FAQ </h4>

      </div>
    </div>

    <!-- Formulário -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card-box">
          <form method="POST" action="insere.php" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Pergunta</label>
                <textarea placeholder="Pergunta" class="form-control" name="pergunta"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Resposta</label>
                <textarea placeholder="Resposta" class="form-control" name="resposta" id="resposta"></textarea>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <input type="submit" class="btn btn-success" value="Cadastrar"/>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Final da página -->
<?php
require_once($siteHD.'adm/rodape.php');
require_once($siteHD.'adm/js.php');
?>
<script src="<?php echo $site;?>adm/assets/plugins/tmce/tinymce.min.js"></script>

</script>
<script type="text/javascript">
$(document).ready(function(){
  tinymce.init({
    selector:'#resposta',
    language: 'pt_BR',
    menubar: false ,
    statusbar: false ,
    plugins: "textcolor link image fullscreen code lists paste",
    toolbar: "bold italic underline | image link | removeformat",
    images_upload_url: 'upload.php',
    auto_convert_smileys: true,
    images_upload_credentials: true,
    icons: 'material'      // baseURL/icons/material/icons.js
  });


});


</script>

</body>
</html>
