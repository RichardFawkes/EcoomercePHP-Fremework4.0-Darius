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
@media only screen and (min-width: 375px) {
  .thumb-image{
    width: 100%;
    max-width: 100%;
  }
}
</style>

<div class="wrapper">
  <div class="container">
    <!-- hotfix for title on mobile -->
    <br class="hidden-md hidden-lg" />
    <br class="hidden-md hidden-lg" />
    <!-- Titulo -->
    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Banners </h4>

      </div>
    </div>

    <!-- Formulário -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card-box">
          <form method="POST" action="insere.php" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group  col-md-4">
                <label>Título</label>
                <input type="text" placeholder="Usado somente para controle interno" maxlength="70" class="form-control" name="titulo"/>
              </div>
              <div class="form-group col-md-4">
                <label>Link</label>
                <input type="text" placeholder="Link para direcionar após o click" class="form-control" name="link"/>
              </div>
              <div class="form-group  col-md-4">
                <label>Modo de Abertura do Link</label>
                <select class="form-control" name="mode">
                  <option value="_blank">Nova janela</option>
                  <option value="_self">Mesma Janela</option>
                </select>
              </div>
            </div>
            <div class="row">
            <div class="form-group col-md-12">
              <label>Imagem <span class="text-muted">*Aceita somente .JPG,.JPEG,.PNG</span></label>
              <input type="file" accept="image/*" name="file" id="filesToUpload" />
            </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <output id="filesInfo"></output><br/>
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
<script type="text/javascript">
$(document).ready(function(){
  // jquery Preview
  $("#filesToUpload").on('change', function () {
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#filesInfo");
      image_holder.empty();
      var reader = new FileReader();
      reader.onload = function (e) {
        $("<img />", {
          "src": e.target.result,
          "class": "thumb-image",
          "onload": "$(this).fadeIn('slow');"
        }).hide().appendTo(image_holder).fadeIn("slow");
      }
      image_holder.show();
      reader.readAsDataURL($(this)[0].files[0]);
    } else{
      alert("Este navegador não suporta FileReader.");
    }
  });

});

</script>

</body>
</html>
