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
  width: 100%;
  max-width: 100%;
}
@media only screen and (min-width: 375px) {
  .thumb-image{
    width: 100%;
    max-width: 100%;
  }
}

.delBtn {
  cursor: pointer;
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
        <h4 class="page-title">Produtos </h4>

      </div>
    </div>
    <?php
      $sql = 'SELECT * FROM Produtos WHERE id = '.$_GET['id'].';';
      $res = mysqli_query($link, $sql);
      $row = mysqli_fetch_array($res);
    ?>
    <!-- Formulário -->
    <div class="row">
      <div class="col-xs-12">
        <div class="card-box">
          <form method="POST" action="add.php" enctype="multipart/form-data">
            <h4>Informações</h4>
            <div class="row">
              <div class="form-group  col-md-4">
                <label>Título*</label>
                <input type="text" placeholder="Título do Produto" class="form-control" name="titulo" required value="<?php echo $row['titulo'];?>" />
              </div>
              <div class="form-group col-md-4">
                <label>URL Amigável <span title="Somente o que deseja que aparecer na URL" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
                <input type="text" placeholder="URL Amigável " class="form-control" name="link" required value="" />
              </div>
              <div class="form-group col-md-1">
                <label>SKU</label>
                <input type="text" placeholder="SKU" class="form-control" name="sku" value="<?php echo $row['sku'];?>" />
              </div>
              <div class="form-group col-md-1 custom-control custom-radio">
                <label>Lançamento*</label>
                <?php
                  if($row['lancamento']==1){
                    $sim = 'checked';
                    $nao = '';
                  }else{
                    $sim = '';
                    $nao = 'checked';
                  }
                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="lancamento" id="inlineRadio1" value="1" <?php echo $sim; ?>/>
                  <label class="form-check-label label label-success" for="inlineRadio1">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="lancamento" id="inlineRadio2" value="0" <?php echo $nao; ?>/>
                  <label class="form-check-label label label-default" for="inlineRadio2">Não</label>
                </div>
              </div>
              <div class="form-group col-md-2 custom-control custom-radio">
                <label>Mostrar 3D*</label>
                <?php
                  if($row['mostra_3d']==1){
                    $sim = 'checked';
                    $nao = '';
                  }else{
                    $sim = '';
                    $nao = 'checked';
                  }
                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="mostra_3d" id="inlineRadio3" value="1" <?php echo $sim; ?>/>
                  <label class="form-check-label label label-success" for="inlineRadio3">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="mostra_3d" id="inlineRadio4" value="0" <?php echo $nao; ?>/>
                  <label class="form-check-label label label-danger" for="inlineRadio4">Não</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label>Preço Atual* <span title="Valor a ser cobrado do cliente" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
                <input type="text" placeholder="Valor em Real" class="form-control money" name="preco" required value="<?php echo $row['preco'];?>" />
              </div>
              <div class="form-group col-md-4">
                <label>Preço Antigo <span title="Este valor aparecerá riscado e mostrata a TAG de Promoção" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span> </label>
                <input type="text" placeholder="Valor em Real" class="form-control money" name="preco_antigo" value="<?php echo $row['preco_antigo'];?>" />
              </div>
              <div class="form-group col-md-1 custom-control custom-radio">
                <label>Controle Estoque*</label>
                <?php
                  if($row['estoque']==1){
                    $sim = 'checked';
                    $nao = '';
                  }else{
                    $sim = '';
                    $nao = 'checked';
                  }
                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="estoque" id="inlineRadio5" value="1" <?php echo $sim; ?>/>
                  <label class="form-check-label label label-success" for="inlineRadio3">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="estoque" id="inlineRadio6" value="0" <?php echo $nao; ?>/>
                  <label class="form-check-label label label-danger" for="inlineRadio4">Não</label>
                </div>
              </div>
              <div class="form-group col-md-2">
                <label>Quantidade</label>
                <input type="number" placeholder="Quantidade" class="form-control" name="qtde" value="<?php echo $row['quantidade'];?>" />
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <label>Descrição do produto</label>
                <textarea placeholder="Coloque aqui mais informações do cliente" class="form-control" name="descricao" id="txtarea"><?php echo $row['descricao'];?></textarea>
              </div>
            </div>
            <br/>
            <h4>Medidas <span title="Preenchimento Obrigatório para o calculo do frete (Em Metros para medidas e para peso em Kilograma)" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></h4>
            <div class="row">
              <div class="form-group col-md-3">
                <label>Altura* </label>
                <input type="text" placeholder="Altura em Metros (0.000)" class="form-control size" name="altura" value="<?php echo $row['altura'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Largura* </label>
                <input type="text" placeholder="Largura em Metros (0.000)" class="form-control size" name="largura" value="<?php echo $row['largura'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Comprimento* </label>
                <input type="text" placeholder="Comprimento em Metros (0.000)" class="form-control size" name="comprimento" value="<?php echo $row['comprimento'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Diâmetro* </label>
                <input type="text" placeholder="Diâmetro em Metros (0.000)" class="form-control size" name="diametro" value="<?php echo $row['diametro'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Profundidade* </label>
                <input type="text" placeholder="Comprimento em Metros (0.000)" class="form-control size" name="profundidade" value="<?php echo $row['profundidade'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Peso* </label>
                <input type="text" placeholder="Peso em Kilogramas (0.000)" class="form-control weight" name="peso" required value="<?php echo $row['peso'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Dias para Produção* </label>
                <input type="number" placeholder="Dias" class="form-control day" name="dias_producao" required maxlength="3" min="1" max="999" value="<?php echo $row['prazo_producao']?>"/>
              </div>
            </div>
            <h4>Medias dos Rótulos <span title="Em Metros para medidas" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></h4>
            <div class="row">
              <div class="form-group col-md-3">
                <label>Altura para o arquivo importado </label>
                <input type="text" placeholder="Altura em Metros" class="form-control size" name="altura_rotulo" value="<?php echo $row['altura_rotulo'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>Largura para o arquivo importado </label>
                <input type="text" placeholder="Largura em Metros" class="form-control size" name="largura_rotulo" value="<?php echo $row['largura_rotulo'];?>" />
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="form-group col-md-4">
                <h4>Linhas Próprias </h4>
                <?php
                  $sqlLP = 'SELECT c.id, c.categoria, c.ativo, IF(cxp.id IS NOT NULL, 1,0) checked
                  FROM Categorias c
                  LEFT JOIN Categorias_X_Produtos cxp ON cxp.idCategoria = c.id AND cxp.idProduto = '.$_GET['id'].'
                  WHERE idTipo=2;';
                  $resLP = mysqli_query($link,$sqlLP);
                  while($rowLP = mysqli_fetch_array($resLP)){
                    if($rowLP['ativo']==1){
                      $ativo = " <span class='text-success'>(Ativo)</span>";
                    }else{
                      $ativo = " <span class='text-danger'>(Desativado)</span>";
                    }
                    if($rowLP['checked']==1){
                      $checked = "checked";
                    }else{
                      $checked = "";
                    }
                    echo '<div class="custom-control custom-checkbox">';
                    echo '<input type="checkbox" class="custom-control-input" id="customCheck'.$rowLP['id'].'" value="'.$rowLP['id'].'" name="lp[]" '.$checked.'>';
                    echo '<label class="custom-control-label" for="customCheck'.$rowLP['id'].'"> &nbsp;'.$rowLP['categoria'].$ativo.'</label>';
                    echo '</div>';
                  }
                ?>

              </div>
              <div class="form-group col-md-4">
                <h4>Categorias </h4>
                <?php
                  $sqlC = 'SELECT c.id, c.categoria, c.ativo, IF(cxp.id IS NOT NULL, 1,0) checked
                  FROM Categorias c
                  LEFT JOIN Categorias_X_Produtos cxp ON cxp.idCategoria = c.id AND cxp.idProduto = '.$_GET['id'].'
                  WHERE idTipo=1;';
                  $resC = mysqli_query($link,$sqlC);
                  while($rowC = mysqli_fetch_array($resC)){
                    if($rowC['ativo']==1){
                      $ativo = " <span class='text-success'>(Ativo)</span>";
                    }else{
                      $ativo = " <span class='text-danger'>(Desativado)</span>";
                    }
                    if($rowC['checked']==1){
                      $checked = "checked";
                    }else{
                      $checked = "";
                    }
                    echo '<div class="custom-control custom-checkbox">';
                    echo '<input type="checkbox" class="custom-control-input" id="customCheck'.$rowC['id'].'" value="'.$rowC['id'].'" name="c[]" '.$checked.'>';
                    echo '<label class="custom-control-label" for="customCheck'.$rowC['id'].'"> &nbsp;'.$rowC['categoria'].$ativo.'</label>';
                    echo '</div>';
                  }
                ?>

              </div>
            </div>
            <br/>
            <h4>Imagens <span title="Imagens com proporções quadradas ficam melhor no site"  data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></h4>
            <div class="row">
            <div class="form-group col-md-3">
              <label>Imagem Principal <span title="Aceita somente .JPG,.JPEG,.PNG" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span> </label>
              <?php if($row['img']!=""){ ?>
                <a href='#' class='delBtn' data-id='<?php echo $row['id']; ?>' data-img='1'><i class='fa fa-trash'></i>Remover </a>
              <?php } ?>
              <input type="file" accept="image/*" name="file[]" id="filesToUpload1" />
              <div class="col-xs-12 col-md-12">
                <?php
                if($row['img']!=""){
                  echo "<div id='thumbnail-wrapper1'>";
                  echo "<img src='".$site."/images/product/mini/".$row['img']."' class='thumb-image' id='photo1'/>";
                  echo "</div>";
                }
                ?>
                <output id="filesInfo1"></output><br/>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label>Imagem 2 <span title="Aceita somente .JPG,.JPEG,.PNG" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
              <?php if($row['img2']!=""){ ?>
              <a href='#' class='delBtn' data-id='<?php echo $row['id']; ?>' data-img='2'><i class='fa fa-trash'></i> Remover</a>
              <?php } ?>
              <input type="file" accept="image/*" name="file[]" id="filesToUpload2" />
              <div class="col-xs-12 col-md-12">
                <?php
                if($row['img2']!=""){
                  echo "<div id='thumbnail-wrapper2'>";
                  echo "<img src='".$site."/images/product/mini/".$row['img2']."' class='thumb-image' id='photo2'/>";
                  echo "</div>";
                }
                ?>
                <output id="filesInfo2"></output><br/>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label>Imagem 3 <span title="Aceita somente .JPG,.JPEG,.PNG" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
              <?php if($row['img3']!=""){ ?>
               <a href='#' class='delBtn' data-id='<?php echo $row['id']; ?>' data-img='3'><i class='fa fa-trash'></i> Remover</a>
               <?php } ?>
              <input type="file" accept="image/*" name="file[]" id="filesToUpload3" />
              <div class="col-xs-12 col-md-12">
                <?php
                if($row['img3']!=""){
                  echo "<div id='thumbnail-wrapper3'>";
                  echo "<img src='".$site."/images/product/mini/".$row['img3']."' class='thumb-image' id='photo3'/>";
                  echo "</div>";
                }
                ?>
                <output id="filesInfo3"></output><br/>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label>Imagem 4 <span title="Aceita somente .JPG,.JPEG,.PNG" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
              <?php if($row['img4']!=""){ ?>
              <a href='#' class='delBtn' data-id='<?php echo $row['id']; ?>' data-img='4'><i class='fa fa-trash'></i> Remover</a>
              <?php } ?>
              <input type="file" accept="image/*" name="file[]" id="filesToUpload4" />
              <div class="col-xs-12 col-md-12">
                <?php
                if($row['img4']!=""){
                  echo "<div id='thumbnail-wrapper4'>";
                  echo "<img src='".$site."/images/product/mini/".$row['img4']."' class='thumb-image' id='photo4'/>";
                  echo "</div>";
                }
                ?>
                <output id="filesInfo4"></output><br/>
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" value="<?php echo $_GET['id'];?>" name="id" />
                <input type="submit" class="btn btn-success" value="ADICIONAR"/>
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
<script src="<?php echo $site;?>adm/assets/plugins/nicedit/nicedit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
  new nicEditor({buttonList : ['bold','italic','underline','link','unlink']}).panelInstance('txtarea');
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();

  $('.money').mask('000,000,000,000,000.00', {reverse: true});
  $('.size').mask('0.000', {reverse: true});
  $('.weight').mask('0.000', {reverse: true});
  $('.day').mask('000', {reverse: true});

  // Apagar Imagens
  // $("#tabela").on('click','.delBtn', function(event) {
  $(".delBtn").click(function (event) {
    event.preventDefault();

    var img = $(this).data("img");
    var id = $(this).data("id");
    var aAtual = $(this).closest('a');

    if(confirm("Certeza em apagar definitivamente esta Imagem?")){
      jQuery.ajax({
          type: "GET", // HTTP method POST or GET
          url: "deletar-imagem.php", //Where to make Ajax calls
          dataType: "json", // Data type, HTML, json etc.
          data: { img: img, id:id }, //Form variables
          success: function (response) {
            alert(response.info);
            $("#thumbnail-wrapper"+img).fadeOut(300, function(){ $(this).remove();});
            aAtual.remove();
          }
      });
    }
 });

  // jquery Preview
  $("#filesToUpload1").on('change', function () {
    $("#thumbnail-wrapper1").hide().fadeOut("slow");
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#filesInfo1");
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

  $("#filesToUpload2").on('change', function () {
    $("#thumbnail-wrapper2").hide().fadeOut("slow");
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#filesInfo2");
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

  $("#filesToUpload3").on('change', function () {
    $("#thumbnail-wrapper3").hide().fadeOut("slow");
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#filesInfo3");
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

  $("#filesToUpload4").on('change', function () {
    $("#thumbnail-wrapper4").hide().fadeOut("slow");
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#filesInfo4");
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