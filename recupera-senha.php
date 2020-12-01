<?php
require_once('inc/def.php');

require_once('header.php');
require_once('menu.php');

 ?>

 <div class="container main-container headerOffset">
     <div class="row">
         <div class="breadcrumbDiv col-lg-12">
             <ul class="breadcrumb">
 	              <li><a href="<?php echo $site;?>">Home</a></li>
                <li class="active"> Recuperar Senha</li>
             </ul>
         </div>
     </div>



     <div class="row">

         <div class="col-lg-12 col-md-12 col-sm-12">
             <h1 class="section-title-inner"><span><i class="glyphicon glyphicon-lock"></i> Recuperar Senha </span></h1>

             <!-- <div class="row userInfo"> -->

                 <div class="col-lg-12">
                     <h2 class="block-title-2"> Digite sua nova senha. </h2>
                     <p> Para sua segurança não passe para ninguém esta nova senha.</p>
                     <span id="result" class="text-danger"></span>
                 </div>

                   <?php
                   $sql = 'SELECT id,dataHora, DATE_ADD(dataHora, INTERVAL 1 DAY) umdiadepois, idUser FROM RecuperaSenha WHERE URL_recuperacao="'.$_GET['parrs'].'" AND ativo=1 ORDER BY id DESC LIMIT 1';
                   $res = mysqli_query($link,$sql);
                   $cont = mysqli_num_rows($res);
                   if($cont==0){
                     ir($site,'Você já recuperou a senha. Se não lembrar por favor tente novamente recuperar a senha.');
                     exit;
                   }else{
                     $row = mysqli_fetch_array($res);
                     if($row['dataHora']>$row['umdiadepois']){
                       ir($site,'Link Expirado por favor tente recuperar a senha novamente.');
                       exit;
                     }else{
                       ?>
                       <form action="atualiza_senha.php" method="POST">
                         <div class="row">
                         <div class="form-group col-xs-12" id="password">
                           <label>Nova senha</label>
                           <input type="password" name="password" class="form-control" placeholder="Senha"/>
                         </div>
                         </div>
                         <div class="row">
                         <div class="form-group  col-xs-12" id="repassword">
                           <label>Confirmação da senha</label>
                           <input type="password" name="repassword" class="form-control" placeholder="Confirmação da Senha"/>
                         </div>
                         </div>
                         <div class="row">
                         <div class="col-lg-12 clearfix">
                             <input type="hidden" value="<?php echo $row['idUser']?>" name="idUser">
                             <input type="hidden" value="<?php echo $row['id']?>" name="id">
                             <input type="submit" class="btn btn-primary" id="btn" value="Atualizar Senha">
                         </div>
                     </div>
                       </form>
                       <?php
                     }
                   }
                   ?>


                 <div class="col-lg-12 clearfix">
                     <ul class="pager">
                         <li class="previous pull-right"><a href="./"> <i class="fa fa-home"></i> Ir para Loja </a></li>

                     </ul>
                 </div>

             </div>
             <!--/row end-->
         <!-- </div> -->

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
<script>
$('input').blur(function() {
    var pass = $('input[name=password]').val();
    var repass = $('input[name=repassword]').val();
    if(($('input[name=password]').val().length == 0) || ($('input[name=repassword]').val().length == 0)){
        $('#password').addClass('has-error');
        $('#btn').addClass('disabled');
        $('#btn').attr('disabled',true);
        $('#result').html('Senhas não podem ser vazias');
    }
    else if (pass != repass) {
        $('#password').addClass('has-error');
        $('#repassword').addClass('has-error');
        $('#btn').addClass('disabled');
        $('#btn').attr('disabled',true);
        $('#result').html('Senhas precisam ser exatamente iguais');
    }
    else {
        $('#password').removeClass().addClass('has-success');
        $('#repassword').removeClass().addClass('has-success');
        $('#btn').removeClass('disabled');
        $('#btn').attr('disabled',false);
        $('#result').html('');
    }
});
</script>
 </body>
 </html>
