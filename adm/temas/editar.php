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
  width: 15%;
  max-width: 15%;
}
@media only screen and (min-width: 375px) {
  .thumb-image{
    width: 50%;
    max-width: 50%;
  }
}
</style>
<?php
$sql = 'SELECT * FROM Temas WHERE id ='.$_GET['id'];
$q = mysqli_query($link, $sql);
$row = mysqli_fetch_array($q);

?>
<div class="wrapper">
  <div class="container">
    <!-- hotfix for title on mobile -->
    <br class="hidden-md hidden-lg" />
    <br class="hidden-md hidden-lg" />
    <!-- Titulo -->
    <div class="row">
      <div class="col-sm-12">
        <h4 class="page-title">Categorias </h4>

      </div>
    </div>

    <!-- Formulário -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card-box">
          <form method="POST" action="alterar.php" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Título do Tema</label>
                <textarea placeholder="Título do tema" class="form-control" name="titulo" /><?php echo $row['categoria']?></textarea>
              </div>

            </div>
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Descrição</label>
                <textarea placeholder="Breve descrição" class="form-control" name="descricao" /><?php echo $row['descricao']?></textarea>
              </div>

            </div>
              <div class="row">
              <div class="form-group col-md-12">
                <label>URL Amigável</label>
                <input type="text" placeholder="URL Amigável" class="form-control" name="link" value="<?php echo $row['urlLink']?>"/>
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
                <?php
                if ($row['img']!="") {
                    echo "<img src='".$site."/images/temas/".$row['img']."' class='thumb-image' id='photo'/>";
                }
                ?>
                <output id="filesInfo"></output><br/>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input type="submit" class="btn btn-success" value="Alterar"/>
                <input type="hidden" value="<?php echo $row['id']; ?>" name="id" />
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
    $("#photo").hide().fadeOut("slow");
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
