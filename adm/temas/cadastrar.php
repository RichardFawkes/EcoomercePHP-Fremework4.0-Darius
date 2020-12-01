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
  width: 10%;
  max-width: 10%;
}
@media only screen and (min-width: 375px) {
  .thumb-image{
    width: 50%;
    max-width: 50%;
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
        <h4 class="page-title">Cadastrar Novo Tema </h4>

      </div>
    </div>

    <!-- Formulário -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card-box">
          <form method="POST" action="insere.php" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Título</label>
                <textarea placeholder="Título do Tema" class="form-control" name="titulo"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Descrição</label>
                <textarea placeholder="Breve descrição" class="form-control" name="descricao"></textarea>
              </div>
            </div>
              <div class="row">
              <div class="form-group col-md-12">
                <label>Link</label>
                <input type="text" placeholder="Link para direcionar após o click" class="form-control" name="link"/>
              </div>
            </div>
            <div class="row">
            <div class="form-group col-md-12">
              <label>Imagem <span class="text-muted">*Aceita somente .JPG,.JPEG,.PNG | Tamanho Ideal 600x400 px.</span></label>
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
