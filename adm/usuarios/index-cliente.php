<?php
require_once('../../inc/def.php');
libera_acesso(1);
require_once($siteHD."adm/cabecalho_adm.php");

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
			<form action="resultado.php" id="form1" name="form1" method="POST" >


			<i style="color:#009245;"class="fa fa-search"></i> <input  id="nomerazaoc" name="nomerazao" class="  btn btn-light inputis"type="text" style="width: 70%;"placeholder="Nome / razão Social">
<input  class="btn btn-light inputis" id="codtotvsc"  name="codtotvs" type="text"  style="width: 28%;" placeholder="código totvs" ><br>
<input  class="btn btn-light inputis" id="cpfc" name="cpf" type="text" style="width: 71%;" placeholder="cpf / cnpj">
<input  class="btn btn-light inputis" id="inscricaoestadualc"  name="inscricaoestadual" type="text" style="width: 28%;" placeholder="inscrição estadual"><br>
<input  class="btn btn-light inputis" id="emailc" name="email" type="text"style="width: 71%;"  placeholder="e-mail">
<input  class="btn btn-light inputis" id="telc" name="tel" type="text"  placeholder="telefone">
<input  class="btn btn-light inputis" id="contatoc"  name="contato" type="text" placeholder="contato"><br>
<input  class="btn btn-light inputis" id="enderecoc" name="endereco" type="text" style="width: 100%;" placeholder="Endereco"><br>
<input  class="btn btn-light inputis" id="bairroc" name="bairro" type="text" style="width: 100%;"placeholder="Bairro"><br>
<input  class="btn btn-light inputis" id="cepc" name="cep" type="text"style="width: 30%;" placeholder="CEP">
<input  class="btn btn-light inputis" id="cidadec" name="cidade" type="text" style="width: 50%;" placeholder="Cidade">
<input  class="btn btn-light inputis" id="ufc" name="uf" type="text" placeholder="UF">









</div>

<div class="row">
				<div class="col-lg-5">
					
				<label style="font-size:15px;"><h3>DADOS DE ENTREGA</h3></label>
        <a class="confirmsend" id="bt-copiar" >  <i class="fa fa-share-square-o" ></i> COPIAR DADOS DO CLIENTE</a>
					
				</div>
			</div>

<div class="card-box col-lg-12" style="border-radius: 20px;" > 
			
<i style="color:#009245;"class="fa fa-search"></i> <input  id="1nomerazao"name="1nomerazao" class="  btn btn-light inputis"type="text" style="width: 70%;"placeholder="Nome / razão Social">
<input  class="btn btn-light inputis" id="1codtotvs" name="1codtotvs" type="text"  style="width: 28%;" placeholder="código totvs" ><br>
<input  class="btn btn-light inputis" id="1cpf" name="1cpf" type="text" style="width: 71%;" placeholder="cpf / cnpj">
<input  class="btn btn-light inputis" id="1inscricaoestadual" name="1inscricaoestadual" type="text" style="width: 28%;" placeholder="inscrição estadual"><br>
<input  class="btn btn-light inputis" id="1email"name="1email" type="text"style="width: 71%;"  placeholder="e-mail">
<input  class="btn btn-light inputis" id="1tel"name="1tel" type="text"  placeholder="telefone">
<input  class="btn btn-light inputis" id="1contato" name="1contato" type="text" placeholder="contato"><br>
<input  class="btn btn-light inputis" id="1endereco" name="1endereco" type="text" style="width: 100%;" placeholder="Endereco"><br>
<input  class="btn btn-light inputis" id="1bairro" name="1bairro" type="text" style="width: 100%;"placeholder="Bairro"><br>
<input  class="btn btn-light inputis" id="1cep" name="1cep" type="text"style="width: 30%;" placeholder="CEP">
<input  class="btn btn-light inputis" id="1cidade" name="1cidade" type="text" style="width: 50%;" placeholder="Cidade">
<input  class="btn btn-light inputis" id="1uf" name="1uf" type="text" placeholder="UF">










</div>

<div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>DADOS DE PAGAMENTO</h3></label>
					
				</div>
			</div>
<div class="card-box" style="border-radius: 20px;" > 
			


<select style="width: 30%;" class="form-control" name="metodo" id="exampleFormControlSelect1">
      <option>FORMA DE PAGAMENTO</option>
      <option value="Eletronico">Eletronico</option>
      <option value="Faturado">Faturado</option>

    </select>
<input  class="form-control inputis"type="text" name="condipag" placeholder="Condicao de pagamento">
<input  class="form-control inputis"type="text"  name="trasporte"placeholder="Transporte">
<input  class="form-control inputis"type="text" naem="previentrega" placeholder="previsao de entrega">







</div>



<div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>DADOS DO PEDIDO</h3></label>
					
				</div>
			</div>
<div id="items" class="card-box" style="border-radius: 20px;"> 
			


<!-- INPUT1!-->

<div class="row">
  <div class="customer_records">
  <input id="textinput" name="produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt1" name="qtd" onfocus="calcular()"  type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input id="txt2"  name="unit" type="text" placeholder="R$ UNIT" style="width: 10%;"  class="btn btn-light inputis renda" onblur="calcular()"><input type="text" id="result"  name="total"  placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />
	
<!-- INPUT2!-->

  <input id="textinput" name="1produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="1tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt3" onfocus="calcular1()" name="1qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="1cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="1verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="1base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="1person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input name="1unit" id="txt4" onblur="calcular1()" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result1" name="1total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />
  

  <!-- INPUT3!-->

  <input id="textinput" name="2produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="2tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt5" name="2qtd" onfocus="calcular2()" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="2cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="2verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="2base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select>
	
	<select  name="2person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select>
	<input id="txt6" onblur="calcular2()" name="2unit" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result2" name="2total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />

<!-- INPUT4!-->

  <input id="textinput" name="3produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="3tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt7" onfocus="calcular3()" name="3qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="3cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="3verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="3base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="3person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input id="txt8" onblur="calcular3()" name="3unit" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result3" name="3total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />


<!-- INPUT5!-->

  <input id="textinput" name="4produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="4tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt9" onfocus="calcular4()" name="4qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="4cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="4verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="4base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="4person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input id="txt10" onblur="calcular4()" name="4unit" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result4" name="4total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />


<!-- INPUT6!-->

<input id="textinput" name="6produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="4tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt11" onfocus="calcular5()" name="6qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="6cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="6verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="6base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="6person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input id="txt12" onblur="calcular5()" name="6unit" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result6" name="6total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />

    <!-- <a class=" btn btn-success extra-fields-customer" >+</a> -->
    <a class="btn btn-success" onclick="Mudarestado('novaslinha')">+</a>

  </div>

  <div class="customer_records_dynamic"></div>
  

</div>



<div id="novaslinha" style="display:none">

<!-- INPUT7!-->

<div class="row">
  <div class="customer_records">
  <input id="textinput" name="7produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="7tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt13" name="7qtd" onfocus="calcular7()"  type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="7cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="7verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="7base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="7person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input id="txt14"  name="7unit" type="text" placeholder="R$ UNIT" style="width: 10%;"  class="btn btn-light inputis renda" onblur="calcular7()"><input type="text" id="result7"  name="7total"  placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />
	
<!-- INPUT8!-->

  <input id="textinput" name="8produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="8tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt15" onfocus="calcular8()" name="8qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="8cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="8verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="8base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="8person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input name="8unit" id="txt16" onblur="calcular8()" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result8" name="8total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />
  

  <!-- INPUT9!-->

  <input id="textinput" name="9produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="9tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt17" onfocus="calcular9()" name="9qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="9cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="9verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="9base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="9person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input name="9unit" id="txt18" onblur="calcular9()" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result9" name="9total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />
  
<!-- INPUT10!-->

  <input id="textinput" name="10produto" type="text" placeholder="PRODUTO" style="width: 10%;" class="btn btn-light inputis"><input id="textinput" name="10tamanho" type="text" placeholder="TAMANHO"style="width: 10%;" class="btn btn-light inputis"><input id="txt19" onfocus="calcular10()" name="10qtd" type="text" placeholder="QUANTIDADE" style="width: 10%;" class="btn btn-light inputis renda"><input id="textinput" name="10cortampa" type="text" placeholder="COR TAMPA" style="width: 10%;" class="btn btn-light inputis"><select  name="10verniz" style="width: 10%;" class="btn btn-light inputis">
      <option>Brilho</option>
      <option>Fosco</option>

	</select><select  name="10base" style="width: 10%;" class="btn btn-light inputis">
      <option>Esmalte</option>
      <option>Size</option>

	</select><select  name="10person" style="width: 10%;" class="btn btn-light inputis">
      <option>Impressão Digital</option>
      <option>Sleeve</option>

	</select><input id="txt20" onblur="calcular10()" name="10unit" type="text" placeholder="R$ UNIT" style="width: 10%;" class="btn btn-light inputis renda"><input id="result10" name="10total" type="text" placeholder="R$ TOTAL" style="width: 10%;" class="btn btn-light inputis" readonly />



  <div class="customer_records_dynamic"></div>
  

</div>
</div>

</div>
</div>

<div id="items" class="card-box" style="border-radius: 20px;"> 

<input  name="obs" type="text" placeholder="observação" style="width: 100%;" class="btn btn-light inputis renda">

</div>


<div class="row">
				<div class="col-sm-12">
					
				<label style="font-size:15px;"><h3>Total</h3></label>
					
				</div>
			</div>
<div id="items" class="card-box" style="border-radius: 20px;"> 

<label >QUANTIDADE TOTAL:</label><input  id="resultado" name="qtdtotal" type="text"  style="width: 30%;" class="form-control inputis">
<label >VALOR TOTAL:</label><input  id="resultadopreco" name="valortotal" type="text"  style="width: 30%;" class="form-control inputis">
<label >FRETE:</label><input  id="frete" name="frete" type="text"  style="width: 30%;" class="form-control inputis">
<label >VALOR + FRETE:</label><input  id="resultadototalfrete" name="resultadototal" type="text" style="width: 30%;" class="form-control inputis ">


</div>


<div class="container text-center">
<!-- Botão para acionar modal -->
<button type="button"  name="send" id="send" class="confirmsend" data-toggle="modal" data-target="#modalExemplo">
<i class="fa fa-plus-circle"></i> CADASTRAR


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
      <h3 style="font-weight:bold;">tem certeza que deseja cadastrar este pedido?</h3>
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






<script>



$(function calcular(){
            $('#txt1, #txt2').keyup(function(){
               var value1 = $('#txt1').val() ;
               var value2 = $('#txt2').val() ;
               $('#result').val(parseInt(value1 * value2));
               document.getElementById("txt1").value = value1;
               document.getElementById("txt2").value = value2;

            });
           
              

    
         });

         $(function calcular1(){
            $('#txt3, #txt4').keyup(function(){
               var value3 = $('#txt3').val() ;
               var value4 = $('#txt4').val() ;
               $('#result1').val(parseInt(value3 * value4));
               document.getElementById("txt3").value = value3;
               document.getElementById("txt4").value = value4;
            });
         });

         $(function calcular2(){
            $('#txt5, #txt6').keyup(function(){
               var value5 = $('#txt5').val() ;
               var value6 = $('#txt6').val() ;
               $('#result2').val(parseInt(value5 * value6));
               document.getElementById("txt5").value = value5;
               document.getElementById("txt6").value = value6;
            });

         });
         $(function calcular3(){
            $('#txt7, #txt8').keyup(function(){
               var value7 = $('#txt7').val() ;
               var value8 = $('#txt8').val() ;
               $('#result3').val(parseInt(value7 * value8));
               document.getElementById("txt7").value = value7;
               document.getElementById("txt8").value = value8;
            });
         });

         $(function calcular4(){
            $('#txt9, #txt10').keyup(function(){
               var value9 = $('#txt9').val() ;
               var value10 = $('#txt10').val() ;
               $('#result4').val(parseInt(value9 * value10));
               document.getElementById("txt9").value = value9;
               document.getElementById("txt10").value = value10;
            });
         });
         

         $(function calcular5(){
            $('#txt11, #txt12').keyup(function(){
               var value11 = $('#txt11').val() ;
               var value12 = $('#txt12').val() ;
               $('#result6').val(parseInt(value11 * value12));
               document.getElementById("txt11").value = value11;
               document.getElementById("txt12").value = value12;
            });
         });

         $(function calcular7(){
            $('#txt13, #txt14').keyup(function(){
               var value13 = $('#txt13').val() ;
               var value14 = $('#txt14').val() ;
               $('#result7').val(parseInt(value13 * value14));
               document.getElementById("txt13").value = value13;
               document.getElementById("txt14").value = value14;
            });
         });

         $(function calcular8(){
            $('#txt15, #txt16').keyup(function(){
               var value15 = $('#txt15').val() ;
               var value16 = $('#txt16').val() ;
               $('#result8').val(parseInt(value15 * value16));
               document.getElementById("txt15").value = value15;
               document.getElementById("txt16").value = value16;
            });
         });

         $(function calcular9(){
            $('#txt17, #txt18').keyup(function(){
               var value17 = $('#txt17').val() ;
               var value18 = $('#txt18').val() ;
               $('#result9').val(parseInt(value17 * value18));
               document.getElementById("txt17").value = value17;
               document.getElementById("txt18").value = value18;
            });
         });
         
         $(function calcular10(){
            $('#txt19, #txt20').keyup(function(){
               var value19 = $('#txt19').val() ;
               var value20 = $('#txt20').val() ;
               $('#result10').val(parseInt(value19 * value20));
               document.getElementById("txt19").value = value19;
               document.getElementById("txt20").value = value20;
            });
         });
         
</script>


 

<script>
jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }
  
    var soma1 = (jQuery('#txt1').val() == '' ? 0 : jQuery('#txt1').val());
    var soma2 = (jQuery('#txt3').val() == '' ? 0 : jQuery('#txt3').val());
    var soma3 = (jQuery('#txt5').val() == '' ? 0 : jQuery('#txt5').val());
    var soma4 = (jQuery('#txt7').val() == '' ? 0 : jQuery('#txt7').val());
    var soma5 = (jQuery('#txt9').val() == '' ? 0 : jQuery('#txt9').val());
    var soma6 = (jQuery('#txt11').val() == '' ? 0 : jQuery('#txt11').val());
    var soma7 = (jQuery('#txt13').val() == '' ? 0 : jQuery('#txt13').val());
    var soma8 = (jQuery('#txt15').val() == '' ? 0 : jQuery('#txt15').val());
    var soma9 = (jQuery('#txt17').val() == '' ? 0 : jQuery('#txt17').val());
    var soma10 = (jQuery('#txt19').val() == '' ? 0 : jQuery('#txt19').val());




  


    var result = (parseInt(soma1) + parseInt(soma2) + parseInt(soma3)+ parseInt(soma4)+parseInt(soma5) +parseInt(soma6)+parseInt(soma7)+parseInt(soma8)+parseInt(soma9)+parseInt(soma10));
    jQuery('#resultado').val(result);
    document.getElementById("resultado").value = result;

  });
});





function Mudarestado(el) {
  var display = document.getElementById(el).style.display;
  if (display == "none")
    document.getElementById(el).style.display = 'block';
  else
    document.getElementById(el).style.display = 'none';
}

</script>




<script>




jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }
  
    var soma1 = (jQuery('#result').val() == '' ? 0 : jQuery('#result').val());
    var soma2 = (jQuery('#result1').val() == '' ? 0 : jQuery('#result1').val());
    var soma3 = (jQuery('#result2').val() == '' ? 0 : jQuery('#result2').val());
    var soma4 = (jQuery('#result3').val() == '' ? 0 : jQuery('#result3').val());
    var soma5 = (jQuery('#result4').val() == '' ? 0 : jQuery('#result4').val());
    var soma6 = (jQuery('#result6').val() == '' ? 0 : jQuery('#result6').val());
    var soma7 = (jQuery('#result7').val() == '' ? 0 : jQuery('#result7').val());
    var soma8 = (jQuery('#result8').val() == '' ? 0 : jQuery('#result8').val());
    var soma9 = (jQuery('#result9').val() == '' ? 0 : jQuery('#result9').val());
    var soma10 = (jQuery('#result10').val() == '' ? 0 : jQuery('#result10').val());






    var result = (parseInt(soma1) + parseInt(soma2) + parseInt(soma3)+ parseInt(soma4)+parseInt(soma5) +parseInt(soma6)+parseInt(soma7)+parseInt(soma8)+parseInt(soma9)+parseInt(soma10));
    jQuery('#resultadopreco').val(result);

    document.getElementById("resultadopreco").value = result;


   

  });
});


</script>

<script>


$('#meuModal').on('shown.bs.modal', function () {
  $('#meuInput').trigger('focus')
})



$('#bt-copiar').on('click', function(){
  $('#1nomerazao').val($('#nomerazaoc').val());    
  $('#1codtotvs').val($('#codtotvsc').val());    
  $('#1cpf').val($('#cpfc').val());
  $('#1inscricaoestadual').val($('#inscricaoestadualc').val()); 
  $('#1email').val($('#emailc').val()); 
  $('#1tel').val($('#telc').val());   
  $('#1contato').val($('#contatoc').val());    
  $('#1endereco').val($('#enderecoc').val());   
  $('#1bairro').val($('#bairroc').val());  
  $('#1cep').val($('#cepc').val());  
  $('#1cidade').val($('#cidadec').val());    
  $('#1uf').val($('#ufc').val());
});


var formID = document.getElementById("form1");
var send = $("#send");

$(formID).submit(function(event){
  if (formID.checkValidity()) {
    send.attr('disabled', 'disabled');
  }
});

</script>



<script>
//bloqueia virgula no input
$('input').on("input", function(e) {
    $(this).val($(this).val().replace(/,/g, ""));
});

</script>

	</body>
	</html>
