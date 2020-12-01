<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");


$sqlinfo= 'SELECT  * ,pd.nomerazao nomerazaoe,pd.codtotvs codtotvse,pd.cpf cpfe,pd.inscricaoes inscriese,pd.email emaile,pd.tel tele, pd.endereco enderecoe,pd.bairro bairroe, pd.cep cepe,pd.cidade cidadee FROM Pedidos_Manual p
JOIN Pedidos_Manual_Dados_Entrega pd ON pd.idCompra = p.idCompra
WHERE p.idCompra = "'.$_GET['id'].'" AND pd.endereco IS NOT NULL group by pd.endereco DESC
';


$sqlinfo1 = 'SELECT  * FROM Pedidos_Manual 
WHERE idCompra = "'.$_GET['id'].'"';
$qt = mysqli_query($link,$sqlinfo1);
$rv = mysqli_fetch_assoc($qt);



$qz = mysqli_query($link,$sqlinfo);

$r = mysqli_fetch_assoc($qz);


$sql= 'SELECT  * ,pd.nomerazao nomerazaoe,pd.codtotvs codtotvse,pd.cpf cpfe,pd.inscricaoes inscriese,pd.email emaile,pd.tel tele, pd.endereco enderecoe,pd.bairro bairroe, pd.cep cepe,pd.cidade cidadee FROM Pedidos_Manual  p
JOIN Pedidos_Manual_Dados_Entrega pd ON pd.idCompra = p.idCompra
WHERE p.idCompra = "'.$_GET['id'].'"

GROUP by produto


';


$qs = mysqli_query($link,$sql);

$rp = mysqli_fetch_assoc($qs);



$sqlpag= 'SELECT   pg.metodo,pg.condicaopag,pg.previsaoentrega,pg.trasporte 
FROM  Pedidos_Manual_Dados_Pagamento  pg
WHERE pg.idCompra = "'.$_GET['id'].'"

';


$qp = mysqli_query($link,$sqlpag);

$pg = mysqli_fetch_assoc($qp);



$sqlpedido= 'SELECT  * FROM Pedidos_Manual  p
WHERE p.idCompra = "'.$_GET['id'].'"




';


$p = mysqli_query($link,$sqlpedido);
?>	
 



 <style>
	 .inputis{
	
    font-size: 1rem;
    height: 35px;
    border-bottom: 1px solid lightgrey;
    border-top: none;
    border-right: none;
    border-left: none;
    transition: box-shadow 0.4s linear;
	margin-top: 1em;
	text-align: left; 

	font-size:12px;

text-transform: uppercase;
	 }

	 .confirmsend {
  display:block;
  margin:15px auto 0;
  transition:all .15s ease-in-out;
  cursor:pointer;
  color:#fff;
  background: #00b462;
  border:none;
  font-size:18px;
  padding:8px 24px;
  border-radius:20px;
  box-shadow: 0 6px 20px -8px #000;
}
.confirmsend:hover {  
  box-shadow: 0 3px 10px -5px #000;
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
					
				<label style="font-size:15px;"><h3>DADOS CLIENTE</h3></label>
					
				</div>
			</div>

			<!-- Formulário -->

			<div class="card-box col-lg-12" style="border-radius: 20px;" > 
			<form action="edita-pedido.php" id="form1" name="form1" method="POST" >

            <input type="hidden" value="<?php echo $_GET['id']; ?>" name="idPedido"  type="text" >

			<i style="color:#009245;"class="fa fa-search"></i> <input    value="<?php echo $rv['nomecliente']; ?>" id="nomerazaoc" name="nomerazao" class="  btn btn-light inputis"type="text" style="width: 70%;"placeholder="Nome / razão Social">
<input   value="<?php echo $rv['codtotvs']; ?>"  class="btn btn-light inputis" id="codtotvsc"  name="codtotvs" type="text"  style="width: 28%;" placeholder="código totvs" ><br>
<input   value="<?php echo $rv['cpf']; ?>" class="btn btn-light inputis" id="cpfc" name="cpf" type="text" style="width: 71%;" placeholder="cpf / cnpj">
<input   value="<?php echo $rv['inscriese']; ?>" class="btn btn-light inputis" id="inscricaoestadualc"  name="inscricaoestadual" type="text" style="width: 28%;" placeholder="inscrição estadual"><br>
<input  value="<?php echo $rv['email']; ?>"  class="btn btn-light inputis" id="emailc" name="email" type="text"style="width: 71%;"  placeholder="e-mail">
<input  value="<?php echo $rv['tel']; ?>"  class="btn btn-light inputis" id="telc" name="tel" type="text"  placeholder="telefone">
<input   value="<?php echo $rv['contato']; ?>" class="btn btn-light inputis" id="contatoc"  name="contato" type="text" placeholder="contato"><br>
<input   value="<?php echo $rv['endereco']; ?>" class="btn btn-light inputis" id="enderecoc" name="endereco" type="text" style="width: 100%;" placeholder="Endereco"><br>
<input  value="<?php echo $rv['bairro']; ?>" class="btn btn-light inputis" id="bairroc" name="bairro" type="text" style="width: 100%;"placeholder="Bairro"><br>
<input    value="<?php echo $rv['cep']; ?>" class="btn btn-light inputis" id="cepc" name="cep" type="text"style="width: 30%;" placeholder="CEP">
<input   value="<?php echo $rv['cidade']; ?>" class="btn btn-light inputis" id="cidadec" name="cidade" type="text" style="width: 50%;" placeholder="Cidade">
<input    value="<?php echo $rv['uf']; ?>" class="btn btn-light inputis" id="ufc" name="uf" type="text" placeholder="UF">









</div>

		<!-- Titulo -->
        <div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>DADOS ENTREGA</h3></label>
					
				</div>
			</div>

				

<div class="card-box col-lg-12" style="border-radius: 20px;" > 
			
<i style="color:#009245;"class="fa fa-search"></i> <input    value="<?php echo $r['nomerazaoe']; ?>" id="nomerazaoc" name="1nomerazao" class="  btn btn-light inputis"type="text" style="width: 70%;"placeholder="Nome / razão Social">
<input    value="<?php echo $r['codtotvse']; ?>"  class="btn btn-light inputis" id="codtotvsc"  name="1codtotvs" type="text"  style="width: 28%;" placeholder="código totvs" ><br>
<input    value="<?php echo $r['cpfe']; ?>" class="btn btn-light inputis" id="cpfc" name="1cpf" type="text" style="width: 71%;" placeholder="cpf / cnpj">
<input    value="<?php echo $r['inscriesee']; ?>" class="btn btn-light inputis" id="inscricaoestadualc"  name="1inscricaoestadual" type="text" style="width: 28%;" placeholder="inscrição estadual"><br>
<input   value="<?php echo $r['emaile']; ?>"  class="btn btn-light inputis" id="emailc" name="1email" type="text"style="width: 71%;"  placeholder="e-mail">
<input   value="<?php echo $r['tele']; ?>"  class="btn btn-light inputis" id="telc" name="1tel" type="text"  placeholder="telefone">
<input    value="<?php echo $r['contatoe']; ?>" class="btn btn-light inputis" id="contatoc"  name="1contato" type="text" placeholder="contato"><br>
<input    value="<?php echo $r['enderecoe']; ?>" class="btn btn-light inputis" id="enderecoc" name="1endereco" type="text" style="width: 100%;" placeholder="Endereco"><br>
<input   value="<?php echo $r['bairroe']; ?>" class="btn btn-light inputis" id="bairroc" name="1bairro" type="text" style="width: 100%;"placeholder="Bairro"><br>
<input    value="<?php echo $r['cepe']; ?>" class="btn btn-light inputis" id="cepc" name="1cep" type="text"style="width: 30%;" placeholder="CEP">
<input   value="<?php echo $r['cidadee']; ?>" class="btn btn-light inputis" id="cidadec" name="1cidade" type="text" style="width: 50%;" placeholder="Cidade">
<input    value="<?php echo $r['ufe']; ?>" class="btn btn-light inputis" id="ufc" name="1uf" type="text" placeholder="UF">











</div>

<div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>DADOS DE PAGAMENTO</h3></label>
					
				</div>
			</div>
<div class="card-box" style="border-radius: 20px;" > 
			



      <input     value="<?php echo $pg['metodo']; ?>" class="form-control inputis"type="text" name="metodo" placeholder="METODO">

<input     value="<?php echo $pg['condicaopag']; ?>" class="form-control inputis"type="text" name="condipag" placeholder="Condicao de pagamento">
<input     value="<?php echo $pg['trasporte']; ?>" class="form-control inputis"type="text"  name="trasporte"placeholder="Transporte">
<input     value="<?php echo $pg['previsaoentrega']; ?>" class="form-control inputis"type="text" naem="previentrega" placeholder="previsao de entrega">







</div>



<div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>DADOS DO PEDIDO</h3></label>
					
				</div>
			</div>
<div id="items" class="card-box" style="border-radius: 20px;"> 
			


<!-- INPUT1!-->
<?php 

while($u = mysqli_fetch_assoc($p)){
echo'
<div class="row">
  <div class="customer_records">
  <input     value="' .$u['produto'].'"  id="textinput" name="produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input   value="' .$u['tamanho'].'" id="textinput" name="tamanho" type="text" placeholder="TAMANHO" style="width: 10%;" class="btn btn-light inputis"><input   value="' .$u['qtd'].'" id="txt1" name="qtd" onfocus="calcular()"  type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input   value="' .$u['cortampa'].'" id="textinput" name="cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><input   value="' .$u['verniz'].'" id="textinput" name="cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis">
      
  <input   value="' .$u['base'].'" id="textinput" name="base" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis">
      
  <input   value="' .$u['person'].'" id="textinput" name="person" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis">

  <input    value="' .$u['unit'].'" id="txt2"  name="unit" type="text" placeholder="R$ UNIT" style="width: 10%;"  class="btn btn-light inputis renda" onblur="calcular()"><input    value="' .$u['total'].'" type="text" id="result"  name="total"  placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />
	

    </div>

  <div class="customer_records_dynamic"></div>
  

</div>';
}
?>

</div>
<div id="items" class="card-box" style="border-radius: 20px;"> 

<input   value="<?php echo $r['obs']; ?>"  name="obs" type="text" placeholder="observação" style="width: 100%;" class="btn btn-light inputis renda">

</div>


<div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>Total</h3></label>
					
				</div>
			</div>
<div id="items" class="card-box" style="border-radius: 20px;"> 

<label >QUANTIDADE TOTAL:</label><input    value="<?php echo $r['qtdtotal']; ?>"  id="resultado" name="qtdtotal" type="text"  style="width: 30%;" class="form-control inputis">
<label >FRETE:</label><input   value="<?php echo $r['frete']; ?>" id="frete" name="frete" type="text"  style="width: 30%;" class="form-control inputis">
<label >VALOR + FRETE:</label><input    value="<?php echo $r['resultadototal']; ?>" id="resultadototalfrete" name="resultadototal" type="text" style="width: 30%;" class="form-control inputis ">


</div>


<div class="container text-center">
<!-- Botão para acionar modal -->
<button type="button"  name="send" id="send" class="confirmsend" form="form1" data-toggle="modal" data-target="#modalExemplo">
<i class="fa fa-check"></i> CADASTRAR

</button>



   <!-- Modal -->
<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Atenção!</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h3 style="font-weight:bold;">tem certeza que deseja alterar este pedido?</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Nao</button>
        <button onclick="passaValor()" class="btn btn-success">Sim</button>
      </div>
    </div>
  </div>
</div>
</div>


</div>
  <br>

</div>

  </form>



		<!-- Final da página -->
		<?php
        require_once($siteHD.'adm/rodape.php');
        require_once($siteHD.'adm/js.php');
        ?>









	</body>
	</html>
