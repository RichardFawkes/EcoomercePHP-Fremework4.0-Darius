

<?php
  require_once('inc/def.php');
  include('api/login.php');
error_reporting(0);


  $sql = 'SELECT id , titulo , img , img2 , img3 , img4 , SPLIT_STRING(descricao,"<br><br>",1) descricaoFB, descricao , preco , preco_antigo , sku, mostra_3d , mostra_cor_da_tampa,quantidade, estoque
  FROM Produtos WHERE id = "'.$_GET['i'].'";';
  $q = mysqli_query($link, $sql);
  $r = mysqli_fetch_assoc($q);

  if (is_null($r['preco_antigo'])) {
      $precoAntigo = '';
  } else {
      $precoAntigo = '<span class="price-standard">R$'.$r['preco_antigo'].'</span>';
  }

  $idProduto = $r['id'];
  $customHeader = 1;
    require_once('header.php');
    


    $sql4= 'SELECT * From PrecosQuantidades WHERE idProduto='.$r['id'].'
    ORDER BY valorUnitario DESC 
    ;';

    $res3 = mysqli_query($link, $sql4);

$rv = mysqli_fetch_assoc($res3);


$sql3 = 'SELECT categoria FROM Temas WHERE id = "'.$_GET['c'].'"';
$qp = mysqli_query($link, $sql3);
$rz = mysqli_fetch_assoc($qp);

?>



    <!-- styles needed by smoothproducts.js for product zoom  -->
    <link rel="stylesheet" href="<?php echo $site; ?>assets/plugins/smoothproducts-master/css/smoothproducts.css">
    <link href="<?php echo $site; ?>assets/plugins/rating/bootstrap-rating.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $site;?>3D/uploads/css/jquery.fileupload.css">
    <?php
  require_once('menu.php');

?>

<!-- Main component call to action -->
<br>
<br>
<br>
<br>
<br>
<br>
<div>
    <div class="morePost row featuredPostContainer style2">
	<div class="col-lg-12 text-center">
			
		
	</div>
        </div>
        </div>
    </div>
 
<style>

.carousel-wrap {
  margin: 90px auto;
  padding: 0 5%;
  width: 80%;
  position: relative;
}

/* fix blank or flashing items on carousel */
.owl-carousel .item {
  position: relative;
  z-index: 100; 
  -webkit-backface-visibility: hidden; 
}

/* end fix */


table {
  border-collapse: collapse;
  width: 50%;
}
.texto {
  position: relative;
  display: inline-block;
  color: #4ec67f;
  font-size: 1rem;
  margin: 8px;
  margin-left: 50px;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #4bb777;
  color: white;
}
 #qtd{
  text-align: left;
  padding: 8px;
}


#qtd {
  background-color: #4bb777;
  color: white;
}


</style>





        <style>

     
	 .linkprintnow {
  background-color: #4bb777;
  color: white;
  padding: 7px 2px;
  text-align: center;
  text-decoration: none;
  display:block;
  font-weight: bold;
}

	
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 30px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
  border-radius: 20px;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
  
}
::-webkit-scrollbar
{
    width: 0px;
}
::-webkit-scrollbar-track-piece
{
    background-color: transparent;
    -webkit-border-radius: 6px;
}

@media (min-width: 1000px)
{
.qtd{
    position: relative;
    border-width:2px;
    width: 10px;
    height: 100px;
    left:210px;
    top:-130px;
    
    float: left;
}
}

@media (min-width: 979px){
.recommendeds {
    border-top: solid 0px #ddd;
    margin-top: 18px;
    padding-top: 40px;
    margin-left: 0px;
}
}
.owl-nav{
    font-size: 45px;
    position: absolute;
    left: 487px;
    top: 332px;
    color: #4ec67f;

}
.owl-next{
 
 position: absolute;
 left: 400px;
 top: -235px;
 color: #4ec67f;
}


.owl-prev{
 
 position: absolute;
right: 600px;
 top: -235px;
 color: #4ec67f;
}


</style>
<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
        <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li>Tipos</li>
                <li class=""><?php echo $pd['largura_rotulo'].'x'.$pd['altura_rotulo']; ?></li>
                <li class="">Tema</li>
                <li class="active"><?php echo $rz['categoria'] ;?></li>

            </ul>
        </div>
    </div>
    <div class="row transitionfx">
	<div class=" col-lg-12 text-center ">
    <h1 class="texto" ><label style=" text-transform:uppercase; font-size:23px;"><?php echo $rz['categoria'] ;?></label><h1>

	</div>



<div class="carousel-wrap">
  <div class="owl-carousel">
    
<?php




// PEGA MEDIDAS E GRUPO
$sqlt = 'SELECT  p.url,cp.idProduto ,cp.idCategoria,p.largura_rotulo,p.altura_rotulo FROM Categorias_X_Produtos cp
JOIN Produtos p ON p.id = cp.idProduto
WHERE idProduto = "'.$_GET['i'].'"
AND cp.idCategoria IS NOT NULL 
';
$qi = mysqli_query($link,$sqlt);
$pd = mysqli_fetch_assoc($qi);


// PEGA OS PRODUTOS DO GRUPO E DA MEDIDA
$sql='SELECT * FROM Categorias_X_Produtos cz 
JOIN Produtos p ON p.id = cz.idProduto
WHERE cz.idProduto IN (SELECT cz.idProduto FROM Categorias_X_Produtos cz WHERE cz.idProduto IN (SELECT cp.idProduto
FROM Categorias_X_Produtos cp
JOIN Produtos p ON p.id = cp.idProduto
WHERE idCategoria = '.$pd['idCategoria'].'
AND largura_rotulo = '.$pd['largura_rotulo'].' AND altura_rotulo = '.$pd['altura_rotulo'].')
AND cz.idTipos = '.$_GET['g'].'
)
AND cz.idTema = '.$_GET['c'].'';

$q = mysqli_query($link,$sql);


    while ($r = mysqli_fetch_assoc($q)) {
        

        if ($rp['total'] >= 1) {
        echo '
        <div  class="item">
        <div class="product"><a class="product-image" href="'.$editor.''.$r['id'].'&tpsc=1&cru='.$site.'api%2Fcriar-order%3Fepi%3D'.$_GET['i'].'%26url%3D'.$r['url'].'"> <img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img"> </a>
        <div class="description">
        <h4><a  href="'.$editor.''.$r['id'].'&tpsc=1&cru='.$site.'api%2Fcriar-order%3Fepi%3D'.$_GET['i'].'%26url%3D'.$r['url'].'">'.$r['titulo'].'</a></h4>
</div>
        
        </div>
        </div>


';
            
    }else{

        echo '
        <div  class="item">
            <div class="product"><a class="product-image" href="'.$site.'login-editor?id='.$r['id'].'"> <img src="'.$site.'images/product/mini/'.$r['img'].'" alt="img"> </a>
            <div class="description">
            <h4 style="color:black"> <a  href="'.$site.'login-editor?id='.$r['id'].'">'.$r['titulo'].'</a></h4>
</div>
            
            </div>
            </div>
            ';

    }
     }
     
     
     
?>


            <!--/.item-->
        </div>
        </div>
            </div>
        <!--/.recommended-->
        

    </div>
    <div style="clear:both"></div>
</div>


<!-- /main-container -->

<div class="gap"></div>
<?php
    require_once('footer.php');
?>

<!-- Modal 3D start -->
<div class="modal  fade" id="modal-3d" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center">MEUS ARQUIVOS </h3>
            </div>
            <div class="modal-body">

                <h3 class="reviewtitle uppercase">Arquivos:</h3>

                <form>
                    <div class="form-group">
<iframe src="<?php echo $site; ?>3D/uploads/index.php?urlLink=<?php echo $_GET['urlProduto'];?>"></iframe>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Modal 3d -->

<?php /*
<!-- Modal review start -->
<div class="modal  fade" id="modal-review" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h3 class="modal-title-site text-center">PRODUCT REVIEW </h3>
            </div>
            <div class="modal-body">

                <h3 class="reviewtitle uppercase">You're reviewing: Lorem ipsum dolor sit amet</h3>

                <form>
                    <div class="form-group">
                        <label>
                            How do you rate this product? </label> <br>

                        <div class="rating-here">
                            <input type="hidden" class="rating-tooltip-manual" data-filled="fa fa-star fa-2x"
                                   data-empty="fa fa-star-o fa-2x" data-fractions="3"/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rtext">Name</label>
                        <input type="text" class="form-control" id="rtext" placeholder="Your name" required>
                    </div>

                    <div class="form-group ">
                        <label>Review</label>
                        <textarea class="form-control" rows="3" placeholder="Your Review" required></textarea>

                    </div>


                    <button type="submit" class="btn btn-success">Submit Review</button>
                </form>


            </div>

        </div>
        <!-- /.modal-content -->

    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.Modal review -->
*/ ?>

<!-- Le javascript
================================================== -->


<script>

$('.owl-carousel').owlCarousel({
  loop: true,
  margin: 10,
  nav: true,
  navText: [
    "<i style="color: #4ec67f;" class='fa fa-caret-left'></i>",
    "<i style="color: #4ec67f;" class='fa fa-caret-right'></i>"
  ],
  autoplay: true,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 3
      
    }
  }
})
</script>
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $site; ?>assets/js/jquery/jquery-2.1.3.min.js"></script>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- include grid.js // for equal Div height  -->
<script src="<?php echo $site; ?>assets/plugins/jquery-match-height-master/dist/jquery.matchHeight-min.js"></script>
<script src="<?php echo $site; ?>assets/js/grids.js"></script>

<!-- include carousel slider plugin  -->
<link rel="stylesheet" href="ow/owl.carousel.min.css">
<link rel="stylesheet" href="ow/owl.theme.default.min.css">
<script src="jquery.min.js"></script>
<script src="ow/owl.carousel.min.js"></script>

<!-- include smoothproducts // product zoom plugin  -->






<script>

$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
})

</script>




<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="<?php echo $site; ?>assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>


<script src="<?php echo $site; ?>assets/plugins/rating/bootstrap-rating.min.js"></script>
<script>
    $(function () {

        $('.rating-tooltip-manual').rating({
            extendSymbol: function () {
                var title;
                $(this).tooltip({
                    container: 'body',
                    placement: 'bottom',
                    trigger: 'manual',
                    title: function () {
                        return title;
                    }
                });
                $(this).on('rating.rateenter', function (e, rate) {
                    title = rate;
                    $(this).tooltip('show');
                })
                    .on('rating.rateleave', function () {
                        $(this).tooltip('hide');
                    });
            }
        });

    });
</script>

<?php
//FUNCAO CADASTRA O CLIENTE NO PRINT NOW
session_start();

$idUser = $_SESSION['idUser'];
 
$sql = 'SELECT nome, email, id FROM Users WHERE id = '.$idUser;

$q = mysqli_query($link, $sql);
$r = mysqli_fetch_array($q);



$nome = $r['nome'];
$email = $r['email'];
$id    =$r['id'];

// echo '<br>'.$nome.'<br>';

// echo '<br>'.$email.'<br>';

// echo '<br>' .$id. '<br>';



$token = '9F3D85FD4F090049BB298E479056BB67';
$key = 'E8024D21A2B9A5785CEFB28AAA538E820EF50DAA2D0A1582AA5CBE545E8A4E64';
$url = 'https://api.printnow.com/api/v1/pipo/user/create';

// $id = $_GET['productid'





//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST
$data = array(
    'username' => $nome,
    'password' => 'lojadalata',
    'email' => $email,
    'first_name' => $nome,
    'last_name' => $id,
    'storefront_id'=> '1'
);
$payload = json_encode($data);
//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic ' . base64_encode($token . ':' . $key),
    'Content-Type:application/json'));

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$result = curl_exec($ch);
//    echo ($result);
exit;
//close cURL resource
curl_close($ch);

  

?>






</body>
</html>
