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
<a href="<?php echo $rot?>produtos/index.php" style=" background:#10c469; height:30px; width:100px; font-size:17px; text-align: center;" class="badge badge-success badge-lg"><i class="fa fa-arrow-circle-left"></i>VOLTAR</a>

  <div class="container">
    <!-- hotfix for title on mobile -->
    <br class="hidden-md hidden-lg" />
    <br class="hidden-md hidden-lg" />

    <!-- Titulo -->
    
    </div>
    <?php
      $sql = 'SELECT * FROM Produtos WHERE id = '.$_GET['id'].';';
      $res = mysqli_query($link, $sql);
      $row = mysqli_fetch_array($res);

      $sql = 'SELECT * FROM Produtos WHERE id = '.$_GET['id'].';';
      $res = mysqli_query($link, $sql);
      $row = mysqli_fetch_array($res);


      //este codigo esta no insereqtd.php

  //  $sql2 = 'INSERT INTO PrecosQuantidades (`idProduto`, `qtde`, `valorUnitario`)
  //     VALUES ('.$_POST['id'].','.$_POST['qtdep'].','.$_POST['valorUnitario'].');';
  //     $res2 = mysqli_query($link, $sql2);
  //      $row2 = mysqli_fetch_array($res2);
    
      $idproduct = $_GET['id'];

      $sql4= 'SELECT * From PrecosQuantidades WHERE idProduto='.$_GET['id'].' ORDER BY qtde ASC;';

      $res3 = mysqli_query($link, $sql4);
      $row3 = mysqli_fetch_array($res3);
  


      $sql5 = 'DELETE * From PrecosQuantidades WHERE '.$_GET['id'].' AND id='.$row3['id'].' ;';
      $delete = mysqli_query($link, $sql5);



    
   
      
    ?>              
         
    

    

     <div id="classModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
        <h4 class="modal-title" id="classModalLabel">
        Tabela de Preco > <?php echo $row['titulo'];?>
            </h4>
      </div>
      <div class="modal-body">
        <table id="classTable" class="table table-bordered">
          <thead>
          </thead>
          <tbody>
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">


             <input type="hidden" placeholder="ID PRODUTO" class="form-control" name="idproduct" required value='<?php echo $idproduct ?>'  ?>
         
       

 <div id="table" class="table-editable">

   <table class="table table-bordered table-responsive-md table-striped text-center">
     <thead>
       <tr>
         <th class="text-center">QTD</th>
         <th class="text-center">PRECO QTD</th>
         <th class="text-center">REMOVER</th> 
       </tr>
     </thead>
     <tbody>
       <tr>
         <td> <input type="text" placeholder="QUANTIDADE" class="form-control" name="qtdep" value="" ></td>
         <td><input type="text" placeholder="PRECO UNITARIO QTD" class="form-control money" name="valorUnitario" value=""></td>
         
         <td>
<input type="submit"  id="btn_submit" class="btn btn-success" value="Cadastrar"/>         
         </td>
       </tr>
       <!-- This is our clonable table line -->
       
       <?php foreach($res3 as $repete){
       

         echo '
         <tr id="resultado">
         <td class="pt-3-half" contenteditable="true">'. $repete['qtde'] .'</td>

         <td class="pt-3-half" contenteditable="true">'. $repete['valorUnitario'] .'</td>
      
         <td>
         </form>
 
 
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger btn-lg btn-block">REMOVER </button>
    <input type="hidden" placeholder="" class="form-control" name="id" value='.$repete['id'].'></td>
    </form>


</td>';
}
?>
</form>


       
       <!-- This is our clonable table line -->
       <tr class="hide">
        
       </tr>
     </tbody>
   </table>
 </div>
</div>
</div>
<!-- Editable table -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>




          <form method="POST" action="alterar.php" enctype="multipart/form-data">
          <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="card-box">

 
          
            <h4>Informações</h4>
            <div class="row">
              <div class="form-group  col-md-4">
                <label>Título*</label>
                <input type="text" placeholder="Título do Produto" class="form-control" name="titulo" required value="<?php echo $row['titulo'];?>" />
              </div>
              <div class="form-group col-md-4">
                <label>URL Amigável <span title="Somente o que deseja que aparecer na URL" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label>
                <input type="text" placeholder="URL Amigável " class="form-control" name="link" required value="<?php echo $row['url'];?>" />
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
              <div class="form-group col-md-1 custom-control custom-radio">
                <label>Aparecer na Index*</label>
                <?php
                  if($row['especifico']==1){
                    $sim = '';
                    $nao = 'checked';
                  }else{
                    $sim = 'checked';
                    $nao = '';
                  }
                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="especifico" id="inlineRadio7" value="0" <?php echo $sim; ?>/>
                  <label class="form-check-label label label-success" for="inlineRadio1">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="especifico" id="inlineRadio8" value="1" <?php echo $nao; ?>/>
                  <label class="form-check-label label label-default" for="inlineRadio2">Não</label>
                </div>
              </div>
              <div class="form-group col-md-2 custom-control custom-radio">
                <label>DESIGN ONLINE*</label>
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
              <div class="form-group col-md-4 ">
        
              <a class="btn btn-success btn-lg " href="tabela.php?id=<?php echo $_GET['id']; ?>" >
<i class="fa fa-th-list" ></i> TABELA PREÇOS
</a><br>
<div class="form-group col-md-3">
                <label>RANGE MAX* </label>
                <input type="text" placeholder="" class="form-control " name="max" value="<?php echo $row['max'];?>" />
              </div>
              <div class="form-group col-md-3">
                <label>RANGE MIN* </label>
                <input type="text" placeholder="" class="form-control " name="rangeqtde" value="<?php echo $row['rangeqtde'];?>" />
              </div>
                <!-- <label>Preço Atual* <span title="Valor a ser cobrado do cliente" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></label> -->
                
              </div>

              <div class="form-group col-md-4">
                <!-- <label>Preço Antigo <span title="Este valor aparecerá riscado e mostrata a TAG de Promoção" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span> </label> -->
               
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
                <input type="number" placeholder="Quantidade" class="form-control" name="quantidade" value="<?php echo $row['quantidade'];?>"  required/>
              </div>
            </div>
              <div class="form-group col-md-12">
                <label>Descrição do produto</label>
                <textarea placeholder="Coloque aqui mais informações do cliente" class="form-control" name="descricao" id="txtarea"/><?php echo $row['descricao'];?></textarea>
              </div>

              <div class="form-group col-md-12">
                <label>Descrição do produto 2</label>
                <textarea placeholder="Coloque aqui mais informações do cliente" class="form-control" name="descricaou" id="txtareas"/><?php echo $row['descricaou'];?></textarea>
              </div>

           
            <br>
            <h4>Medidas Caixa<span title="Preenchimento Obrigatório para o calculo do frete (Em Metros para medidas e para peso em Kilograma)" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></h4>
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
                <label>Quantidade por Caixa:* </label>
                <input type="hid" placeholder="Quantidade por caixa:" class="form-control" name="qtdcaixa" value="<?php echo $row['qtdcaixa'];?>" />
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
            <h4>Tamanho Produto<span title="Em Metros para medidas" data-toggle="tooltip"><i class="fa fa-info-circle"></i></span></h4>
            <div class="row">
              
              <div class="form-group col-md-3">
                <label>Largura em Centimetro *</label>
                <input type="text" placeholder="Largura em cm" class="form-control cm" name="largura_rotulo" value="<?php echo $row['largura_rotulo'];?>" required/>
              </div>
              <div class="form-group col-md-3">
                <label>Altura em Centimetro * </label>
                <input type="text" placeholder="Altura em cm" class="form-control cm" name="altura_rotulo" value="<?php echo $row['altura_rotulo'];?>" required/>
              </div>
              <div class="form-group col-md-3">
                <label>Volume em ML</label>
                <input type="text" placeholder="Volume em ML" class="form-control " name="volume_ml" value="<?php echo $row['volume_ml'];?>" />
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="form-group col-lg-10">
       

              </div>
              <div class="form-group col-md-4"style="background: whitesmoke; border:solid 2px; border-radius:30px;">
              <h4 style="font-weight: bold;">Grupo de Produtos <i class="fa fa-th-large"></i></h4>
                <?php
                  $sqlC = 'SELECT c.id, c.categoria, c.ativo, IF(cxp.id IS NOT NULL, 1,0) checked
                  FROM Categorias c
                  LEFT JOIN Categorias_X_Produtos cxp ON cxp.idCategoria = c.id AND cxp.idProduto = '.$_GET['id'].'
                  WHERE idTipo=1
                  ORDER BY categoria ASC';
                  $resC = mysqli_query($link, $sqlC);
                  while ($rowC = mysqli_fetch_array($resC)) {
                      if ($rowC['ativo']==1) {
                          $ativo = " <span class='text-success'>(Ativo)</span>";
                      } else {
                          $ativo = " <span class='text-danger'>(Desativado)</span>";
                      }
                      if ($rowC['checked']==1) {
                          $checked = "checked";
                      } else {
                          $checked = "";
                      }
                      echo '<div class="custom-control custom-checkbox">';
                      echo '<input type="checkbox" class="custom-control-input" id="customCheck'.$rowC['id'].'" value="'.$rowC['id'].'" name="c[]" '.$checked.'>';
                      echo '<label class="custom-control-label" for="customCheck'.$rowC['id'].'"> &nbsp;'.$rowC['categoria'].$ativo.'</label>';
                      echo '</div>';
                  }
                ?>

              </div>
              <div class="form-group col-md-4"style="background: whitesmoke; border:solid 2px; border-radius:30px;">
              <h4 style="font-weight: bold;">Temas <i class="fa fa-pencil"></i></i></h4>
                <?php
                  $sqlCs = 'SELECT c.id, c.categoria, c.ativo, IF(cxp.idTema IS NOT NULL, 1,0) checked
                  FROM Temas c
                  LEFT JOIN Categorias_X_Produtos cxp ON cxp.idTema = c.id AND cxp.idProduto = '.$_GET['id'].'
                  WHERE idTipo=1
                  ORDER BY categoria ASC';
                  $resCs = mysqli_query($link, $sqlCs);
                  while ($rowCs = mysqli_fetch_array($resCs)) {
                      if ($rowCs['ativo']==1) {
                          $ativo = " <span class='text-success'>(Ativo)</span>";
                      } else {
                          $ativo = " <span class='text-danger'>(Desativado)</span>";
                      }
                      if ($rowCs['checked']==1) {
                          $checked = "checked";
                      } else {
                          $checked = "";
                      }
                      echo '<div class="custom-control custom-checkbox">';
                      echo '<input type="checkbox" class="custom-control-input" id="customChecks'.$rowCs['id'].'" value="'.$rowCs['id'].'" name="lp[]" '.$checked.'>';
                      echo '<label class="custom-control-label" for="customChecks'.$rowCs['id'].'"> &nbsp;'.$rowCs['categoria'].$ativo.'</label>';
                      echo '</div>';
                  }
                ?>

              </div>
              
              <div class="form-group col-md-4"style="background: whitesmoke; border:solid 2px; border-radius:20px;">
                <h4 style="font-weight: bold;">Tipos <i class="fa fa-tasks"></i></h4>
                <?php
                  $sqlCs = 'SELECT c.id, c.categoria, c.ativo, IF(cxp.id IS NOT NULL, 1,0) checked
                  FROM Tipos_ c
                  LEFT JOIN Categorias_X_Produtos cxp ON cxp.idTipos = c.id AND cxp.idProduto = '.$_GET['id'].'
                  WHERE idTipo=1
                  ORDER BY categoria ASC';
                  $resCs = mysqli_query($link, $sqlCs);
                  while ($rowCs = mysqli_fetch_array($resCs)) {
                      if ($rowCs['ativo']==1) {
                          $ativo = " <span class='text-success'>(Ativo)</span>";
                      } else {
                          $ativo = " <span class='text-danger'>(Desativado)</span>";
                      }
                      if ($rowCs['checked']==1) {
                          $checked = "checked";
                      } else {
                          $checked = "";
                      }
                      echo '<div class="custom-control custom-checkbox">';
                      echo '<input type="checkbox" class="custom-control-input" id="customCheckz'.$rowCs['id'].'" value="'.$rowCs['id'].'" name="lps[]" '.$checked.'>';
                      echo '<label class="custom-control-label" for="customCheckz'.$rowCs['id'].'"> &nbsp;'.$rowCs['categoria'].$ativo.'</label>';
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
                <input type="submit" class="btn btn-success btn-lg" value="Salvar Mudança"/>
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
  new nicEditor({buttonList : ['bold','italic','underline','link','unlink']}).panelInstance('txtareas');

});
</script>


<script>

$(function () {
    $('#btn_submit').click(function () {
        grava();
    });
    $.post("grava.php", {},
    function (resp) {
        $('#resultado').html(resp);
    });    
});

function grava() {
    $.post("grava.php", {
        text: $("#text").val()
    },
    function (resp) {
        $('#resultado').html(resp);
    });
}

</script>

<script>

$('#meuModal').on('shown.bs.modal', function () {
  $('#meuInput').trigger('focus')
})
</script>

<script>

<script type="text/javascript">
           $(window).unload(function () {
            parent.Fechar();
        });
        function Fechar() {
        $.ajax({
            type: 'POST',
            url: 'insereqtd.php',
            data: {
                "Id": '@Model.Id'
            },
            success: function (Html) {
                $("#resultado").html(Html);
            }
        });

    }

    $("#Formulario").submit(function(){
    $(this).ajaxSubmit({    
            beforeSubmit: function(){$("#btn_submit").attr("disabled", "true");},    
            success: function(){    
                if(!$.browser.msie){    
                    parent.fechar();
                }    
            }    
        });    
    
        if($.browser.msie){    
            $("#resultado").ajaxStop(function(){    
                window.opener.fechar();    
                window.close();    
            });    
           }

        return false; // No fim da função submit
     });
});
</script>

<script>

</script>


</script>

<script type="text/javascript">

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();

  $('.money').mask('000,000,000,000,000.00', {reverse: true});
  $('.sizes').mask('00.000', {reverse: true});
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






<script>

const $tableID = $('#table');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTr = `
<tr class="hide">
  <td class="pt-3-half" contenteditable="true">Example</td>
  <td class="pt-3-half" contenteditable="true">Example</td>
  <td class="pt-3-half" contenteditable="true">Example</td>
  <td class="pt-3-half" contenteditable="true">Example</td>
  <td class="pt-3-half" contenteditable="true">Example</td>
  <td class="pt-3-half">
    <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
    <span class="table-down"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
  </td>
  <td>
    <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Remove</button></span>
  </td>
</tr>`;

 $('.table-add').on('click', 'i', () => {

   const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');

   if ($tableID.find('tbody tr').length === 0) {

     $('tbody').append(newTr);
   }

   $tableID.find('table').append($clone);
 });

 $tableID.on('click', '.table-remove', function () {

   $(this).parents('tr').detach();
 });

 $tableID.on('click', '.table-up', function () {

   const $row = $(this).parents('tr');

   if ($row.index() === 1) {
     return;
   }

   $row.prev().before($row.get(0));
 });

 $tableID.on('click', '.table-down', function () {

   const $row = $(this).parents('tr');
   $row.next().after($row.get(0));
 });

 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });


 

</script>



</body>
</html>
