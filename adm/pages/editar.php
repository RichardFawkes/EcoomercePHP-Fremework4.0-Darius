<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");
?>

<?php
$sql = 'SELECT * FROM Pages WHERE id ='.$_GET['id'];
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
        <h4 class="page-title">Política de Devolução </h4>

      </div>
    </div>

    <!-- Formulário -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card-box">
          <form method="POST" action="alterar.php" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Título</label>
                <input placeholder="Título" class="form-control" name="titulo" value="<?php echo $row['titulo']?>" />
              </div>

            </div>
            <div class="row">
              <div class="form-group  col-md-12">
                <label>Texto</label>
                <textarea placeholder="Texto" class="form-control" name="texto" id="texto"/><?php echo $row['texto']?></textarea>
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
<script src="<?php echo $site;?>adm/assets/plugins/tmce/tinymce.min.js"></script>

</script>
<script type="text/javascript">
$(document).ready(function(){
  tinymce.init({
    selector:'#texto',
    language: 'pt_BR',
    menubar: false ,
    statusbar: false ,
    plugins: "textcolor link image fullscreen code lists paste",
    toolbar: "bold italic underline | link | removeformat",
    // images_upload_url: 'upload.php',
    auto_convert_smileys: true,
    // images_upload_credentials: true
  });


});


</script>

</body>
</html>
