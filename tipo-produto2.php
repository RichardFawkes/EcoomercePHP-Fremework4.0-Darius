<?php
	require_once('inc/def.php');
	require_once($siteHD.'header.php');
	require_once($siteHD.'menu.php');
	error_reporting(0);

?>



<?php 

$sql= 'SELECT * FROM Categorias_X_Produtos cp
LEFT JOIN Tipos_ t ON t.id = cp.idTipos
 WHERE idProduto = "'.$_GET['p'].'  AND t.categoria IS NOT NULL"
';
$q = mysqli_query($link,$sql);



?>

<div>
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?php echo $site; ?>">Home</a></li>
                <li>Tipos   </li>
                <li class="active"><?php echo $gp['categoria']; ?></li>
                
            </ul>
        </>
      
    </div>
</div>
    <!-- Main component call to action -->
	<div>
    <div class="morePost row featuredPostContainer style2">
	<div class="col-lg-12 text-center">
			<br>
			<div class="texto" style=" position: absolute;
    top: 30px; left:500px
">
    <h1>ESCOLHA O QUE VOCÊ QUER FAZER<h1>

	</div>
        </div>
        </div>
    </div>
     <style>
		 .breadcrumb {
    border: 0px solid #DDDDDD;
    background: none;
}
	 .linkprintnow {
  background-color: #3f000b;
  color: white;
  padding: 7px 2px;
  text-align: center;
  text-decoration: none;
  display:block;
  font-weight: bold;
}

a.linkprintnow:hover {

  background-color: #120f0e;
}
.itemgrupo {
    width: 229px;
    left: 193px;
}


.descricaogp {
    background: #e0e0e0ad;
    height: 10px;
    position: absolute;
    left: 614px;
    width: 401px;
    top: 167px;
    height: 342px;
    /* backface-visibility: hidden; */
}
.descricaogp2 {
    background: #e0e0e0ad;
    height: 10px;
    position: absolute;
	left: 53px;
	
    width: 401px;
    top: 167px;
    height: 250px;
    /* backface-visibility: hidden; */
}


.titulotamanho {
    background: #4ec67f;
    height: 8px;
    position: absolute;
    left: 614px;
    /* color: white; */
    width: 401px;
    top: 167px;
    height: 40px;
    /* backface-visibility: hidden; */
}

.btngp:hover {
  background-color: #316d49;
}


h1, h2, h3, h4, h5, h6 {
    font-weight: bold;
    margin: 0;
    padding-bottom: 15px;
}
	</style>

<div>


</div>

	
   <br>
   <div>
       
       <br>
            <br>
            <br>
            <br>

       <?php 
     	while($r = mysqli_fetch_assoc($q)){
            if(!is_null($r['']) && $r[''] > 0){
                $preco_antigo = '<span class="old-price">R$'.$r['preco_antigo'].'</span>';
                $promocao = '<span class="discount">Promoção</span>';
            }else{
                
                $promocao = '';
            }

            if($r['lancamento'] == 1){
                $lancamento = '<span  style="background-color: #3f000b;"class="new-product"> Lançamento</span>';
            }else{
                $lancamento = '';
            }

            if(isset($r['tamanho'])){
                $tamanhos = '<span class="size">XL / XXL / S </span>';
            }else{
                $tamanhos = '';
            }
            $sqluser = 'SELECT COUNT(*)total,nome FROM Users WHERE id='.$_SESSION['idUser'].' AND nome IS NOT NULL';
            $suser = mysqli_query($link,$sqluser);
            $rp = mysqli_fetch_array($suser);

            $sql2 = 'SELECT * FROM Produtos p
            LEFT JOIN PrecosQuantidades pq ON pq.idProduto = p.id
            LEFT JOIN Categorias_X_Produtos cp ON cp.idProduto = p.id
            WHERE cp.idCategoria = '.$r['id'].' AND pq.valorUnitario IS NOT NULL ORDER BY pq.valorUnitario ASC LIMIT 1';
            $qp = mysqli_query($link, $sql2);

            $rd = mysqli_fetch_assoc($qp);


            
            echo '
       
           
            <div class="itemgrupo col-lg-3 col-md-3 col-sm-4 col-xs-6">
                <div class="product">
                
                    <div class="image">
                        
                        <a href="'.$site.''.$r['categoria'].'-produto?i='.$r['id'].'"><img src="'.$site.'images/tipos/'.$r['img'].'" alt="img" class="img-responsive lozad"></a>

                        <div class="promotion">
                            '.$lancamento.'
                            '.$promocao.'
                        </div>
                    </div>
                    <div class="description">
                    <div class="titulogrupoproduto"style="font-weight: bold; text-transform: uppercase;"> '.$r['categoria'].'</div>  
                        <a href="'.$site.'configurar-produto?i='.$r['id'].'"> <p> </p></a>
                        '.$tamanhos.'
                    </div>
                    <div class="price">
                        '.$preco_antigo.'</a>
                    </div>
                </div>

                
        
                    <form action="'.$site.'insere_produto_no_carrinho" method="post">
                    <input type="hidden" value="'.$r['id'].'" name="idProduto">
                
                    ';if( $rp['total'] == 1 ){ 
                        echo '<div class="action-control">  </a><br><br>	
                        
                    <a class="linkprintnow"   href="'.$editor.''.$r['id'].'&tpsc=1&token='.json_decode($tokeuser).'&cru='.$site.'api/criar-order.php%3Fepi%3D'.$r['id'].'" ><i class="fa fa-pencil-square-o"></i>CUSTOMIZAR LATA</a>';
                
                    }
                        else {
                        
                        echo '<div class="action-control"> </a>	


                        ';
                    }
                    echo'
                    </div>
                </form>
                </div>
            </div>';
        }

       ?>
       

<!-- <form  method="GET" action="tipo-produto.php" id="tamanhoproduto">
    <br>
    <br>
    <br>

    <?php 
    
    // while($p = mysqli_fetch_array($q)){
    //     echo '&nbsp;&nbsp;&nbsp;&nbsp;<input id="p" name="p" value="'.$p['idProduto'].'"type="radio"  style="font-size:15px;">'.$p['largura_rotulo'].'&nbsp;x&nbsp;'.$p['altura_rotulo'].'&nbsp;|&nbsp; '.$p['volume_ml'].' ml<br>';

    // }
        ?></form>
</div> -->

<!-- 
<h1 class="text-center" style=" color:#9a9a9a"><?php echo $gp['categoria'];?></h1>
<p style="margin: 12px 6px 10px;">&nbsp;&nbsp;&nbsp;<?php echo $gp['descricao'];?></p> -->
</div>



<!-- <div class="btngp text-center" >

</div> -->





<?php
	require_once($siteHD.'footer.php');
 ?>

<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery/jquery-1.10.1.min.js"></script>
<script src="<?php echo $site; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
const el = document.querySelector('img');
const observer = lozad(el);
observer.observe();
</script>
<script src="<?php echo $site; ?>assets/js/idangerous.swiper-2.1.min.js"></script>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        pagination: '.box-pagination',
        keyboardControl: true,
        paginationClickable: true,
        slidesPerView: 'auto',
        autoResize: true,
        resizeReInit: true,
    })

    $('.prevControl').on('click', function (e) {
        e.preventDefault()
        mySwiper.swipePrev()
    })
    $('.nextControl').on('click', function (e) {
        e.preventDefault()
        mySwiper.swipeNext()
    })
</script>

<!-- include jqueryCycle plugin -->
<script src="<?php echo $site; ?>assets/js/jquery.cycle2.min.js"></script>
<!-- <script src="<?php echo $site; ?>assets/js/jquery.cycle2.js"></script> -->

<!-- include easing plugin -->
<script src="<?php echo $site; ?>assets/js/jquery.easing.1.3.js"></script>

<!-- include  parallax plugin -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery.parallax-1.1.js"></script>

<!-- optionally include helper plugins -->
<script type="text/javascript" src="<?php echo $site; ?>assets/js/helper-plugins/jquery.mousewheel.min.js"></script>

<!-- include mCustomScrollbar plugin //Custom Scrollbar  -->

<script type="text/javascript" src="<?php echo $site; ?>assets/js/jquery.mCustomScrollbar.js"></script>

<!-- include icheck plugin // customized checkboxes and radio buttons   -->
<script type="text/javascript" src="<?php echo $site; ?>assets/plugins/icheck-1.x/icheck.min.js"></script>

<!-- include grid.js // for equal Div height  -->
<script src="<?php echo $site; ?>assets/plugins/jquery-match-height-master/dist/jquery.matchHeight-min.js"></script>
<script src="<?php echo $site; ?>assets/js/grids.js"></script>

<!-- include carousel slider plugin  -->
<script src="<?php echo $site; ?>assets/js/owl.carousel.min.js"></script>

<!-- jQuery select2 // custom select   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="<?php echo $site; ?>assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for only homepage  -->
<script src="<?php echo $site; ?>assets/js/home.js"></script>

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>
</body>
</html>
