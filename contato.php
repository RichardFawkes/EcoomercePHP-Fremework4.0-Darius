<?php
require_once('inc/def.php');
require_once('header.php');
?>

<script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>
<?php
require_once('menu.php');
?>


<div class="container main-container headerOffset">
  <div class="row">
    <div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li><a href="<?php echo $site; ?>">Home</a></li>
        <li class="active">Contato</li>
      </ul>
    </div>
  </div>
  <div class="row transitionfx">


    <div class="panel-body">
      <form action="<?php echo$site; ?>envio_contato" method="POST">
        <!-- <fieldset> -->

        <!-- Form Name -->
        <legend>Contato</legend>

        <div class="col-lg-6 col-md-6 col-sm-6">

          <div class="form-group">
            <label for="nome">Nome*</label>
            <input name="nome" id="nome" placeholder="Digite seu nome" class="form-control" type="text" required>
          </div>
          <div class="form-group">
            <label for="email">Email*</label>
            <input name="email" id="email" placeholder="Digite seu email" class="form-control" type="email" required>
          </div>
          <div class="form-group">
            <label for="telefone">Telefone</label>
            <input name="telefone" id="telefone" placeholder="Digite seu Telefone" class="form-control tel" type="text" required>
          </div>
          <div class="form-group">
            <label for="entrega">CEP da Entrega</label>
            <input name="local_entrega" id="entrega" placeholder="Digite o CEP da Entrega" class="form-control cep" type="text">
          </div>
          <div class="form-group">
            <label for="assunto">Assunto</label>
            <select name="assunto" id="assunto" class="form-control" required>
              <option disabled selected>Selecione um Assunto</option>
              <option value="Dúvidas">Dúvidas</option>
              <option value="Críticas">Críticas</option>
              <option value="Orçamento">Orçamento</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="form-group">
            <label for="produto">Produto</label>
            <select name="produto" id="produto" class="form-control">
              <option disabled selected>Selecione um Produto</option>
              <option value="Decortop">Decortop</option>
              <option value="Plocoff">Plocoff</option>
              <option value="Placa">Placa</option>
              <option value="Tampinha">Tampinha</option>
            </select>
          </div>
          <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input name="quantidade" id="quantidade" class="form-control" type="number" placeholder="Digite a Quantidade"/>
          </div>
          <div class="form-group">
            <label for="tamanho">Tamanho</label>
            <input name="tamanho" id="tamanho" class="form-control" type="text" placeholder="Digite um diâmetro e comprimento em cm. Ex.: 20x30CM"/>
          </div>
          <div class="form-group">
            <label>Tipo</label><br>
            <label><input name="tipo" class="form-control" type="radio" value="Lisa" />Lisa</label>
            <label><input name="tipo" class="form-control" type="radio" value="Personalizada" />Personalizada</label>
          </div>

          <div class="form-group">
            <label for="envazado">Produto a ser Envazado</label>
            <input name="envazado" id="envazado" class="form-control" type="text" placeholder="Qual produto você irá envazar?"/>
          </div>
          <!-- Textarea -->
          <div class="form-group">
            <label for="descricao">Mensagem</label>
            <textarea class="form-control" id="descricao" name="descricao" placeholder="Digite a Mensagem aqui" style="height: 60px;resize:none;" required></textarea>
          </div>

          <div class="g-recaptcha" data-sitekey="6LccCL0UAAAAAG5lC9Fd4cgiiVCBD02h30O7-DEz"></div>
          <br>
        </div>

        <div class="row">
          <div class="col-xs-12 text-center">
            <input type="submit" value="Enviar" class="btn btn-success" />
          </div>
        </div>
      </div>
    </form>




  </div>
</div> <!-- /main-container -->

<div class="gap"></div>

<?php
require_once('footer.php');
?>


<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $site; ?>assets/js/jquery/jquery-2.1.3.min.js"></script>
<!-- jquery-migrate only for product details -->
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script src="<?php echo $site; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- include jqueryCycle plugin -->
<script src="<?php echo $site; ?>assets/js/jquery.cycle2.min.js"></script>
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

<!-- include custom script for site  -->
<script src="<?php echo $site; ?>assets/js/script.js"></script>

<!-- Mask -->
<script src="<?php echo $site;?>assets/plugins/jquery-mask2/jquery.mask.min.js"></script>
<script>


$(document).ready(function () {

  // MASK
  var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
  };
  $('.tel').mask(SPMaskBehavior, spOptions);
  $('.cep').mask('00000-000', {reverse: true});

});
</script>
</body>
</html>
