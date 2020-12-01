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
<button onclick="goBack();" style=" background:#10c469; height:30px; width:100px; font-size:17px; text-align: center;" class="badge badge-success badge-lg"><i class="fa fa-arrow-circle-left"></i>VOLTAR</button>

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
         


    

         <div class="card-box">

         <label for="cars">Seleciona o Produto:</label>
<?php 
$sql = 'SELECT id,titulo FROM Produtos';
$q = mysqli_query($link,$sql);

?>
<form method="POST "action="copiatabela.php">
<select name="idprodutocopia" id="idprodutocopia">
  <?php
  while($r = mysqli_fetch_assoc($q)){
  echo'
  <option value="'.$r['id'].'">"'.$r['titulo'].'"</option>';
  }

?>
</select>
<input type="hidden" placeholder="ID PRODUTO" class="form-control" name="idproduct" required value='<?php echo $idproduct ?>'>


<button type="submit">COPIAR</button>

</form>
        <h3  style="font-weight: bold;" class="text-center" id="classModalLabel">
        Tabela de Preco > <?php echo $row['titulo'];?>
            </h3>
      </div>

        <table id="classTable" class="table table-bordered">
          <thead>
          </thead>
          <tbody>
          </div>
          
<form method="POST" action="insereqtd.php" enctype="multipart/form-data">


             <input type="hidden" placeholder="ID PRODUTO" class="form-control" name="idproduct" required value='<?php echo $idproduct ?>'  ?>
         
       

 <div id="table" class="table-editable">

   <table  class="table table-dark table-responsive-md table-striped text-center card-box">
     <thead>
       <tr>
         <th class="text-center">QUANTIDADE</th>
         <th class="text-center">PRECO QTD</th>
         <th class="text-center">ACAO</th> 
       </tr>
     </thead>
     <tbody>
       <tr>
       
         <td> <input type="text" placeholder="QUANTIDADE" class="form-control" name="qtdep" value="" ></td>
         <td><input type="text" placeholder="PRECO UNITARIO QTD" class="form-control money" name="valorUnitario" value=""></td>
         
         <td>
<input type="submit" class="btn btn-success" value="Cadastrar"/>         
         </td>
       </tr>
       <!-- This is our clonable table line -->
       
       <?php foreach($res3 as $repete){
       

         echo '
         <tr>
         <td class="pt-3-half" style="font-weight: bold;" contenteditable="true">'. $repete['qtde'] .'</td>

         <td class="pt-3-half" style="font-weight: bold;" contenteditable="true">'. $repete['valorUnitario'] .'</td>
      
         <td>
         </form>
 
 
  <form action="deletarpreco.php" method="POST">

    <button name="delete" type="submit" class="btn btn-danger  btn-block">REMOVER </button>
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




     
         
            <div class="row">
              <div class="form-group col-lg-10">
       

            
              </div>
            </div>
        
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
function goBack() {
  window.history.back();
}
</script>

<script>

$('#meuModal').on('shown.bs.modal', function () {
  $('#meuInput').trigger('focus')
})
</script>

<script>


   $('#classModal').modal('show');



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
