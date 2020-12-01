<?php
	require_once('inc/def.php');
  libera_acessoSite(1,2,3,4,5);
	require_once('header.php');
?>

<?php
	require_once('menu.php');
?>


<div class="container main-container headerOffset">
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
	    <li><a href="<?php echo $site;?>">Home</a></li>
<?php /*                <li><a href="account.html">My Account</a></li> */ ?>
                <li class="active"> Meus Endereços</li>
            </ul>
        </div>
    </div>



    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1 class="section-title-inner"><span><i class="fa fa-map-marker"></i> Meus Endereços </span></h1>

            <div class="row userInfo">

                <div class="col-lg-12">
                    <h2 class="block-title-2"> Seus endereços estão listados abaixo. </h2>

                    <p> Atualize suas informações, sempre que houver alguma alteração.</p>
                </div>

                <div class="w100 clearfix ">

                  <?php
                    $sql = 'SELECT *, uxe.id idEndereco
                    FROM Users_X_Enderecos uxe
                    JOIN CidadesIBGE c ON c.id = uxe.idCidade
                    JOIN Estados e ON e.id = uxe.idEstado
                    WHERE uxe.idUser='.$_SESSION['idUser'].'
                    AND uxe.ativo=1;';
                  	$q = mysqli_query($link , $sql);
                  	while($row = mysqli_fetch_assoc($q)){
                  ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 end<?php echo $row['idEndereco'];?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong><?php echo $row['titulo']?>
                                  <?php if($row['tipo_pessoa']=="PJ"){ ?>
                                  (<?php echo $row['cnpj']; ?>)
                                <?php }else{?>
                                  (<?php echo $row['cpf']; ?>)
                                  <?php }?>
                                </strong></h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <li><span class="address-name"> <strong><?php echo $row['nome']." ".$row['sobrenome']; ?></strong></span></li>
                                    <li><span class="address-line1"> <?php echo $row['logradouro'].', '.$row['numero']; ?> </span></li>
                                    <li><span class="address-line2"> <?php echo ucwords(mb_strtolower($row['cidade']))?>, <?php echo $row['estado']; ?> </span></li>
                                    <li><span> <strong>Telefone</strong> : <?php echo $row['telefone'];?> </span></li>
                                </ul>
                            </div>
                            <div class="panel-footer panel-footer-address">
                              <a href="endereco.php?id=<?php echo $row['idEndereco']?>" class="btn btn-sm btn-success"> <i class="fa fa-edit"> </i> Editar </a>
                              <a class="btn btn-sm btn-danger delete" id="<?php echo $row['idEndereco']?>" data-msg="<?php echo $row['titulo']?>"> <i class="fa fa-minus-circle"></i> Apagar </a>
                            </div>
                        </div>
                    </div>
                  <?php } ?>




                </div>
                <!--/.w100-->

                <div class="col-lg-12 clearfix">
                    <a class="btn btn-primary" href="<?php $site?>endereco"><i class="fa fa-plus-circle"></i> Novo Endereço</a>
                </div>

                <div class="col-lg-12 clearfix">
                    <ul class="pager">
                        <li class="previous pull-right"><a href="./"> <i class="fa fa-home"></i> Ir para Loja </a></li>

                    </ul>
                </div>

            </div>
            <!--/row end-->
        </div>

        <div class="col-lg-3 col-md-3 col-sm-5"></div>

    </div>
    <!--/row-->

    <div style="clear:both"></div>
</div>
<!-- /.main-container -->

<div class="gap"></div>

<?php
  require_once($siteHD.'footer.php');
?>

<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery/jquery-2.1.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- include  parallax plugin -->
<script type="text/javascript" src="assets/js/jquery.parallax-1.1.js"></script>

<!-- optionally include helper plugins -->
<script type="text/javascript" src="assets/js/helper-plugins/jquery.mousewheel.min.js"></script>

<!-- include mCustomScrollbar plugin //Custom Scrollbar  -->

<script type="text/javascript" src="assets/js/jquery.mCustomScrollbar.js"></script>

<!-- include icheck plugin // customized checkboxes and radio buttons   -->
<script type="text/javascript" src="assets/plugins/icheck-1.x/icheck.min.js"></script>

<!-- include grid.js // for equal Div height  -->
<script src="assets/plugins/jquery-match-height-master/dist/jquery.matchHeight-min.js"></script>
<script src="assets/js/grids.js"></script>

<!-- include carousel slider plugin  -->
<script src="assets/js/owl.carousel.min.js"></script>

<!-- jQuery select2 // custom select   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<!-- include touchspin.js // touch friendly input spinner component   -->
<script src="assets/js/bootstrap.touchspin.js"></script>

<!-- include custom script for site  -->
<script src="assets/js/script.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // Apagar
    $(".delete").click(function (event) {
       event.preventDefault();
       var id = this.id;
       var clickedID = 'id=' + id;
       var msg =  $(this).attr("data-msg");
      if(confirm("Certeza em apagar definitivamente este Endereço '"+msg+"'?")){
        jQuery.ajax({
            type: "GET", // HTTP method POST or GET
            url: "delete_endereco.php", //Where to make Ajax calls
            dataType: "text", // Data type, HTML, json etc.
            data: {id:id}, //Form variables
            success: function (response) {
                alert(response);
                $(".end"+id).fadeOut(300, function(){ $(this).remove();});
            }
        });
      }
   });


 });

</script>
</body>
</html>
