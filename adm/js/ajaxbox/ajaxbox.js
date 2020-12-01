/* Verificamos qual tipo de navegador o usuário está utilizando. */
moz    = !(document.all);
result = true;


/* Função para pegar, mais rapidamente o elemento selecionado, pelo ID*/
function pega(b){	
	return document.getElementById(b);
	
}
/* Função para pegar, mais rapidamente o elemento selecionado, pela tag NAME*/
function objName(elemento){
	return document.getElementsByName(elemento);
}
/* Retirando espaços vazios de uma string */
function trim(txt){
	var retirar = ' ';
	var retorno = '';
	
	for(i=0;i<txt.length;i++){
		if(retirar.indexOf(txt.substr(i,1)) == -1){
			retorno += txt.substr(i,1);
		}
	}
	return retorno;
}

/* 

Ao termos um texto de retorno de um ajax, não podemos dar um innerHTML caso tenha tag's script
que estas serão perdidas ao fazer o innerHTML, então assim poderemos dar por exemplo, um 'alert'
em um innerHTML

*/
function tagScript(texto){
    var ini = 0;

    while (ini!=-1){
        ini = texto.indexOf('<script', ini);

        if (ini >=0){

            ini = texto.indexOf('>', ini) + 1;
            var fim = texto.indexOf('</script>', ini);
            codigo = texto.substring(ini,fim);

            eval(codigo);
        }
    }
}
/* 

Para evitar cache nos navegadores, principalmente no IE, geraremos um numero randomico sempre que
fizermos uma requisição JAJAX a uma URL, sempre que requistitar uma pagina com um numero randomico
diferente do anterior, o navegar ira entender como um novo endereço, e não guardará em 'cache' nossa
página. O cache pode se tornar bom para velocidade, porém pode ser frustante na hora do desenvolvimento
ou atualização de conteudo.

*/
function numero_rnd(quanto_rnd){

	return Math.floor(Math.random()*quanto_rnd)
}

/* Deixando apenas numeros em uma variavel */
function somente_numero(numero){
	var validos   = "0123456789";
	var numero_ok = '';
	
	for(i=0;i<numero.length;i++){
		if(validos.indexOf(numero.substr(i,1)) != -1){
			numero_ok += numero.substr(i,1);
		}
	}
	return numero_ok;
}

/* Deixando apenas letras em uma variavel */
function somente_letras(letra){
	var validos  = "_abcdefghijklmnopkrstuvxzywçáéíóú";
	var letra_ok = '';
	
	for(i=0;i<letra.length;i++){
		if(validos.indexOf(letra.substr(i,1)) != -1){
			letra_ok += letra.substr(i,1);
		}
	}
	return letra_ok;
}

/* Função para criar um elemento antes do campo que for dado focus  */
function cria_elemento_antes(elTxt, el, objId){
	
		var objSibling = pega(objId);
		texto          = document.createTextNode(elTxt);
		objElement     = document.createElement(el);
		objElement.setAttribute('id','erro_'+objId);
		objElement.appendChild(texto);
		objSibling.parentNode.insertBefore(objElement, objSibling);	
	
}

/* Função para criar um elemento após o campo que for dado focus  */
function cria_elemento_depois(elTxt, el, objId){
	
		var objSibling = pega(objId);
		texto          = document.createTextNode(elTxt);
		objElement     = document.createElement(el);
		objElement.setAttribute('id','erro_'+objId);
		objElement.appendChild(texto);
		objSibling.parentNode.insertBefore(objElement, objSibling.nextSibling);	
	
}
/* Criando a estância de request */	
try{
    xmlhttp = new XMLHttpRequest();
}catch(ee){
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp = false;
        }
    }
}	
	/* 
	Sequencia verificadora tomada em cada campo do formulario
	
	classNormal    --> 0 | Classe utilizada quando não houver nada de errado com o campo.

	classRequerido --> 1 | Classe utilizada quando um campo for requerido ou tiver uma regra de preenchimento
	classDemo      --> 2 | Classe definida para resgatar determinados campos que será enviados no submit
	requerido      --> 3 | Requerido = campo requerido, se setado false, não será requerido o preenchimento
	mensagem       --> 4 | Menssagem dada ao usuário, caso o campo seja de preenchimento obrigatório
	box_mini       --> 5 | Quantidade minima de caracteres em um campo ex: box_mini = 5
	box_max        --> 6 | Quantidade maxima de caracteres em um campo ex: box_max = 20
	mascara        --> 7 | Mascara de entrada para algum campo. EX: data
	valida         --> 8 | Tipo de validação para algum campo EX: cpf
	
	*/	
var AjaxBox = function(objDiv, elMethod, varArquivo, objForm, Class, classRequerido, classNormal, verErro, valorUrl, parametros, varArquivoXLS){
	
	
	/* Definições de variaveis de uso */
	this.objDiv         = objDiv;
	this.elMethod       = elMethod;  
	this.varArquivo     = varArquivo;
	this.verErro        = verErro;
	this.Class          = Class;
	this.objForm        = objForm;
	this.valorUrl       = valorUrl;
	
	this.classRequerido = classRequerido;
	this.classNormal    = classNormal;
	this.parametros 	= parametros;
	
	this.varArquivoXLS = varArquivoXLS;
	
	


/* verificar E-mail digitados errado */
this.badMail = function( Email, campoId ){
	
	var Email = Email.split('@')
	
	var arrMail = new Array(	
		/* verificar E-mail digitados errado */
		
		/* hotmail.com */
		{'hotmail.com.br' : 'hotmail.com'},
		{'hotmai.com.br'  : 'hotmail.com'},
		{'hotmeiu.com.br' : 'hotmail.com'},
		{'rotmeiu.com.br' : 'hotmail.com'},		
		{'hotmai.com'     : 'hotmail.com'},
		{'hotmeiu.com'    : 'hotmail.com'},
		{'rotmeiu.com'    : 'hotmail.com'},
		{'rotmail.com'    : 'hotmail.com'},

		/* terra.com.br */
		{'terra.con.br'  : 'terra.com.br'},
		{'terra.con'     : 'terra.com.br'},
		{'terra.com'     : 'terra.com.br'},

		/* gmail.com */
		{'gmail.com.br'  : 'gmail.com'},
		{'gmail.con.br'  : 'gmail.com'},
		{'gmail.con'     : 'gmail.com'},
		{'gnail.com.br'  : 'gmail.com'},
		{'gnail.com'     : 'gmail.com'},
		{'gimail.com.br' : 'gmail.com'},
		{'gimail.com'    : 'gmail.com'},
		{'gemail.com.br' : 'gmail.com'},	
		{'gemail.com'    : 'gmail.com'}
	
	);
	
	
	for( mail in arrMail ){
		
		if ( typeof(arrMail[mail][Email[1]]) != 'undefined' ){
			
			if( confirm("Você digitou ' "+ Email[1] +
						" ' \n quando o correto parece ser ' "+arrMail[mail][Email[1]]+
						" ' ! \n você deseja corrigir? ") )
			{
				
			pega(campoId).value = Email[0] +'@'+ arrMail[mail][Email[1]];
			pega(campoId).focus()
			
			}
			
			return false;
		}
		
	}
	
}
/* verificar E-mail digitados errado */


/* validando os campos */
this.valida = function(tipo, campo, form){
		
		/*
		Partindo do principio que o mundo é perfeito,
		As pessoas digitam seus dados corretamente.
		*/
		result = true;		
		/* valida CPF */
		switch ( tipo ){ 
		
		/* validando um campo do tipo CPF */
		case 'cpf':
		
			var soma;
			var resto;
			var i;
			
			var cpf = somente_numero(pega(campo).value);
		
			if ( cpf.length != 11  ||  cpf == "11111111111" ||  cpf == "22222222222" ||  cpf == "33333333333" ||  cpf == "44444444444" 
				||  cpf == "55555555555" ||  cpf == "66666666666" ||  cpf == "77777777777" ||  cpf == "88888888888" 
				||  cpf == "99999999999"){
			
			 
			 pega(campo).focus()
			 
			 result = false;
			 alert('Digite seu CPF corretamente.');

			
			}

			soma = 0;			
			for ( i = 1; i <= 9; i++ ) {
			
			 soma += Math.floor(cpf.charAt(i-1)) * (11 - i);			
			}
			
			resto = 11 - (soma - (Math.floor(soma / 11) * 11));
			if ( (resto == 10) || (resto == 11) ) {			
			 resto = 0;
			
			}
			
			if ( resto != Math.floor(cpf.charAt(9)) ) {			
			 pega(campo).focus()
			 
			 
			 result = false;			 
			 alert('Verifique o CPF digitado, ele parece estar incorreto.');

			 
			}
			
			soma = 0;
			
			for (i = 1; i<=10; i++) {			
			 	soma += cpf.charAt(i-1) * (12 - i);
			
			}
			
			resto = 11 - (soma - (Math.floor(soma / 11) * 11));
			
			if ( (resto == 10) || (resto == 11) ) {			
			 	resto = 0;
				
			}
			
			if (resto != Math.floor(cpf.charAt(10)) ) {			
			
			 pega(campo).focus()
			 
			 result = false	;		 
			 alert('Verifique o CPF digitado, ele parece estar incorreto.');

			}
			
		
		break;
		/* valida CPF */	
	
		/* valida cnpj */
		case 'cnpj':
		
			var i;
			var s  = somente_numero(pega(campo).value);
			var c  = s.substr(0,12);			
			var dv = s.substr(12,2);			
			var d1 = 0;
			
						
			for (i = 0; i < 12; i++){
			
			d1 += c.charAt(11-i)*(2+(i % 8));
			
			}
			
			if (d1 == 0){
				
				pega(campo).focus()
				
				result = false; 
				alert('Verifique o CNPJ digitado, ele parece estar incorreto.')
			}
			
			d1 = 11 - (d1 % 11);

			if (d1 > 9) d1 = 0;

			if (dv.charAt(0) != d1){
			
			result = false;
			
			}

			d1 *= 2;

			for ( i = 0; i < 12; i++ ){
			
				d1 += c.charAt(11-i)*(2+((i+1) % 8));
			
			}
						
			d1 = 11 - (d1 % 11);	
			if (d1 > 9) d1 = 0;
		
			if (dv.charAt(1) != d1){
			
			pega(campo).focus()
			
			result = false; 
			alert('Verifique o CNPJ digitado, ele parece estar incorreto.');
			
			}
			
		break;
		/* valida cnpj */
		
		
		/* valida email */
		case 'email':
		
			if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(pega(campo).value))) 
				{
									
					pega(campo).focus()
					
					result = false;
					alert("Verifique o e-mail digitado, ele parece estar incorreto.")
			}		
		
		break;
		/* valida email */
		
		
		/* valida cep */
		case 'cep':
		
			var arr_cep = pega(campo).value.split('-')

			if ( arr_cep[0].length != 5 || arr_cep[1].length != 3 ){
				
					pega(campo).focus()
					
					result = false;					
					alert("Verifique o CEP digitado, ele parece estar incorreto.")
				
			}		
		
		break;
		/* valida cep */
		 
		
		/* valida ip */
		case 'ip':
		
			  if (!(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/.test(pega(campo).value))){
					pega(campo).focus()
					
					result = false;
					alert("Verifique o IP digitado, ele parece estar incorreto.")
			  }		
		
		break;
		/* valida ip */		
		
		
		/* valida url com www */
		case 'www':
		
			  if (!(/^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([\w]+)(.[\w]+){1,2}$/.test(pega(campo).value))){
					pega(campo).focus()
					
					result = false;
					alert("Verifique a URL digitada, ele parece estar incorreta.")
			  }		
		
		break;
		/* valida url com www */		
		
		default:
			/* nada = padrão! */
		break;
			
		}
}
/* validando os campos */

/* colocando mascara de entrada nos campos */
this.formata = function(elId){

	form       = this.objForm;
	formulario = eval('document.'+form);

		this.obj      = pega(elId).className.split(' ,');
		this.objId    = pega(elId).id;	
		this.el       = pega(elId).elId;
	

				if ( this.obj[7] == "cpf" ){
							/*
							000.000.000-00
							*/
							pri = eval("document."+this.objForm+"."+this.objId+".value.substring(0,4)");
							seg = eval("document."+this.objForm+"."+this.objId+".value.substring(4,8)");
							ter = eval("document."+this.objForm+"."+this.objId+".value.substring(8,12)");
							qua = eval("document."+this.objForm+"."+this.objId+".value.substring(12,14)");
										
							pega(this.objId).value = somente_numero(pri)+'.'+somente_numero(seg)+'.'+somente_numero(ter)+'-'+somente_numero(qua);			

				}
				
				if ( this.obj[7] == "cnpj" ){
							/*
							00.000.000/0000-00
							*/
							pri = eval("document."+this.objForm+"."+this.objId+".value.substring(0,3)");
							seg = eval("document."+this.objForm+"."+this.objId+".value.substring(3,7)");
							ter = eval("document."+this.objForm+"."+this.objId+".value.substring(7,11)");
							qua = eval("document."+this.objForm+"."+this.objId+".value.substring(11,16)");
							qui = eval("document."+this.objForm+"."+this.objId+".value.substring(16,18)");
										
							pega(this.objId).value = somente_numero(pri)+'.'+somente_numero(seg)+'.'+somente_numero(ter)+'/'+somente_numero(qua)+'-'+somente_numero(qui);			
				}
				
				if ( this.obj[7] == "telefone" ){
							/*
							(000) - 000.000-00
							*/
							pri = eval("document."+this.objForm+"."+this.objId+".value.substring(0,8)");
							seg = eval("document."+this.objForm+"."+this.objId+".value.substring(8,12)");
							ter = eval("document."+this.objForm+"."+this.objId+".value.substring(12,16)");
							qua = eval("document."+this.objForm+"."+this.objId+".value.substring(16,19)");
										
							pega(this.objId).value = '('+somente_numero(pri)+') - '+somente_numero(seg)+'.'+somente_numero(ter)+'-'+somente_numero(qua);		
				}
				
				if ( this.obj[7] == "cep" ){
							/*
							00000-000
							*/
							pri = eval("document."+this.objForm+"."+this.objId+".value.substring(0,6)");
							seg = eval("document."+this.objForm+"."+this.objId+".value.substring(6,9)");
										
							pega(this.objId).value = somente_numero(pri)+'-'+somente_numero(seg);			
				}
				
				if ( this.obj[7] == "data" ){
							/*
							00/00/0000
							*/
							pri = eval("document."+this.objForm+"."+this.objId+".value.substring(0,3)");
							seg = eval("document."+this.objForm+"."+this.objId+".value.substring(3,6)");
							ter = eval("document."+this.objForm+"."+this.objId+".value.substring(6,10)");
										
							pega(this.objId).value = somente_numero(pri)+'/'+somente_numero(seg)+'/'+somente_numero(ter);
							
							
				}
				
				if ( this.obj[7] == "numero" ){
							
							pri = eval("document."+this.objForm+"."+this.objId+".value");
							pega(this.objId).value = somente_numero(pri)
					
				}

				if ( this.obj[7] == "letra" ){
							
							pri = eval("document."+this.objForm+"."+this.objId+".value");
							pega(this.objId).value = somente_letras(pri)
					
				}

				if ( this.obj[7] == "moeda" ){

							/*
							1.000.000.000.000,00
							*/
							len = 20
							cur = pega(elId)
							n   = '0123456789';
							d   = pega(elId).value;
							l   = d.length;
							r   = '';
							
							if ( l > 0 ){
							z = d.substr(0,l);
							s = '';
							a = 0;
							
							for ( i=0; i < l; i++ ){
								
								c = d.charAt(i);
								
								if ( n.indexOf(c) > a ){
									a  = -1;
									s += c;
								};
								
							};
							
							l = s.length;
							t = len - 1;
							
							if ( l > t ){
								l = t;
								s = s.substr(0,t);
							};
							if ( l > 2 ){
								r = s.substr(0,l-2)+','+s.substr(l-2,2);
								
							}else{
								
								if ( l == 2 ){
									r='0,'+s;
									
								}else{
									
									if ( l == 1 ){
										
										r = '0,0'+s;
									};
								};
							};
							if ( r == '' ){
								r = '0,00';
								
							}else{
								l=r.length;
								
								if (l > 6){
									
									j  = l%3;
									w  = r.substr(0,j);
									wa = r.substr(j,l-j-6);
									wb = r.substr(l-6,6);
									
									if ( j > 0 ){
										w+='.';
									};
									
									k = (l-j)/3-2;
									
									for ( i=0; i < k; i++ ){
										w += wa.substr(i*3,3)+'.';
									};
									r = w + wb;
									
								};
							};
							};
							if ( pega(elId).value.length == len || pega(elId).value.length > len ){
								
								pega(elId).value = pega(elId).value.substring(0 ,len);
								
								return false;
								
							}else{
								
									if ( r.length <= len ){
										cur.value = r;
										
		
									}else{
										
										cur.value = z;
										
									};

							}								
			}

}
/* colocando mascara de entrada nos campos */

/* disparando formulario */
this.envia = function(execParametro){

	form       = this.objForm;
	varValor   = '';
	formulario = eval('document.'+form);
	
	for(a = 0; a < formulario.elements.length; a ++){
	
		this.obj      = formulario.elements[a].className.split(' ,');
		this.objClass = formulario.elements[a].className;
		this.objType  = formulario.elements[a].type;
		this.el       = formulario.elements[a];
		this.objValor = formulario.elements[a].value;
		this.objId    = formulario.elements[a].id;


		for(i = 0; i < this.obj.length; i ++){

			if(this.obj[i] == Class){ 			
	
			/* Pegando valor dos campos */
				switch (this.objType){
					
					/*''============================================================''*/
					case 'checkbox':
					   /* campos requeridos */
						if( this.obj[3] == 'requerido' ){
							
							
							if ( !this.el.checked ){	
							
								alert(this.obj[4])

								formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
								
								this.el.focus();
								

									if ( !pega('erro_'+this.objId) ){
										
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}							
								
								return false;
							}else{
								
								formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
								
							
									if ( pega('erro_'+this.objId) ){ 
									
										pega('erro_'+this.objId).style.display = "none";
										
									}							
							}
											
						}
						
						if(this.el.checked){
		
							varValor = this.objId + '=' + escape(this.objValor) +'&'+ varValor
							
						}
	
					break;
					
					
					/*''============================================================''*/
					case 'radio':
					   /* campos requeridos */
			
					var tmp_checked;
					var tmp_alert
						
					this.elCheck = objName(this.el.name)

					for ( i = 0; i <  this.elCheck.length ; i++){
					
					tmp_nome = this.elCheck[i].name	
						
						if( this.obj[3] == 'requerido' ){
						
								if(!this.elCheck[i].checked && tmp_checked != this.objId[0]){
																		

									tmp_alert = this.obj[4];
									
									if ( !pega('erro_'+this.objId) ){
										
										 cria_elemento_depois('* Obrigatorio', '<span>', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
									formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
									
									this.el.focus();
									
									tmp_checked = false		
										
								}else{
									
									tmp_checked = this.objId[0];
									tmp_alert   = ''
									
									formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
									if ( pega('erro_'+this.objId) ){ 
									
										pega('erro_'+this.objId).style.display = "none";
										
									}																		
								}
								
						}else if( this.obj[3] != 'requerido' && tmp_checked != false  ){
							
									tmp_checked = this.objId[0];
									tmp_alert   = ''
									
									formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]							
									if ( pega('erro_'+this.objId) ){ 
									
										pega('erro_'+this.objId).style.display = "none";
										
									}							
							
						}
						
					}
					
					if ( tmp_alert != "" ) alert( this.obj[4] )
					
					if ( tmp_checked != this.objId[0] ) return false;
					
						if(this.el.checked){
		
							varValor = this.objId + '=' + escape(this.objValor) +'&'+ varValor;
							
						}


					break;		
					
					/*''============================================================''*/
					case 'text':
						   /* campos requeridos */
							if( this.obj[3] == 'requerido' ){
								
								
								if ( this.objValor == '' ){	
								
									alert(this.obj[4])

									formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]

									this.el.focus();
									
									
									if ( !pega('erro_'+this.objId) ){
										
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
									return false;
								}else{
									
									formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
									
									if ( pega('erro_'+this.objId) ){ 
									
										pega('erro_'+this.objId).style.display = "none";
										
									}
									

									
								}
												
							}
							box_mini = this.obj[5].split('=');
							box_max  = this.obj[6].split('=');

							if ( parseInt(box_mini[1]) > this.objValor.length ){
								alert('Valor minimo para o campo é de '+box_mini[1]+' caracteres.')
								
									if ( !pega('erro_'+this.objId) ){
										
										 formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
								return false
								
							}
							
							if ( parseInt(box_max[1]) < this.objValor.length ){
								alert('Valor máximo para o campo é de '+box_max[1]+' caracteres.')
								
									if ( !pega('erro_'+this.objId) ){
										
										 formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
								return false
								
							}
							

							if ( this.obj[8] != 'false' ){
								
								this.valida(this.obj[8], this.objId, this.objForm)
							
								if(!result){
									return false;
								}
								
							}
							
							
							
							formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
							varValor = this.objId + '=' + escape(this.objValor) +'&'+ varValor;
							
					break;
					
					/*''============================================================''*/
					case 'textarea':
					
						   /* campos requeridos */
							if( this.obj[3] == 'requerido' ){
								
								
								if ( this.objValor == '' ){	
								
									alert(this.obj[4])

									formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]

									this.el.focus();
									
									
									if ( !pega('erro_'+this.objId) ){
										
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
									return false;
								}else{
									
									formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
									
									if ( pega('erro_'+this.objId) ){ 
									
										pega('erro_'+this.objId).style.display = "none";
										
									}
									

									
								}
												
							}					
					
							box_mini = this.obj[5].split('=');
							box_max  = this.obj[6].split('=');

							if ( parseInt(box_mini[1]) > this.objValor.length ){
								alert('Valor minimo para o campo é de '+box_mini[1]+' caracteres.')
								
									if ( !pega('erro_'+this.objId) ){
										

										 formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
								return false
								
							}
							
							if ( parseInt(box_max[1]) < this.objValor.length ){
								alert('Valor máximo para o campo é de '+box_max[1]+' caracteres.')
								
									if ( !pega('erro_'+this.objId) ){
										
										 formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
								return false
								
							}
							
							varValor = this.objId + '=' + escape(this.objValor) +'&'+ varValor;
							
					break;
					
					/*''============================================================''*/
					case 'password':
						   /* campos requeridos */
							if( this.obj[3] == 'requerido' ){
								
								
								if ( this.objValor == '' ){	
								
									alert(this.obj[4])

									formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]

									this.el.focus();
									
									
									if ( !pega('erro_'+this.objId) ){
										
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
									return false;
								}else{
									
									formulario.elements[a].className = this.classNormal+' ,'+this.classRequerido+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
									
									if ( pega('erro_'+this.objId) ){ 
									
										pega('erro_'+this.objId).style.display = "none";
										
									}
									

									
								}
												
							}
							box_mini = this.obj[5].split('=');
							box_max  = this.obj[6].split('=');

							if ( parseInt(box_mini[1]) > this.objValor.length ){
								alert('Valor minimo para o campo é de '+box_mini[1]+' caracteres.')
								
									if ( !pega('erro_'+this.objId) ){
										
										 formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
								return false
								
							}
							
							if ( parseInt(box_max[1]) < this.objValor.length ){
								alert('Valor máximo para o campo é de '+box_max[1]+' caracteres.')
								
									if ( !pega('erro_'+this.objId) ){
										
										 formulario.elements[a].className = this.classRequerido+' ,'+this.classNormal+' ,'+this.obj[2]+' ,'+this.obj[3]+' ,'+this.obj[4]+' ,'+this.obj[5]+' ,'+this.obj[6]+' ,'+this.obj[7]+' ,'+this.obj[8]
										 cria_elemento_depois('* Obrigatorio', 'span', this.objId)									 
										 pega('erro_'+this.objId).style.color = '#FF0000'
									 
									}
									
								return false
								
							}
							

							if ( this.obj[8] != 'false' ){
								
								this.valida(this.obj[8], this.objId, this.objForm)
							
								if(!result){
									return false;
								}
								
							}
							
							varValor = this.objId + '=' + escape(this.objValor) +'&'+ varValor;
							
					break;					
					
					/*''============================================================''*/
					case 'select-one':
					
						if(this.el.selectedIndex > -1){
							
							varValor = this.objId + '=' + escape(this.el.options[this.el.selectedIndex].value) +'&'+ varValor;
	
						}
						
					break;
					
					/*''============================================================''*/
					case 'select-multiple':
					
							
							
					break;					
					
					/*''============================================================''*/
					case 'hidden':
					
							varValor = this.objId + '=' + escape(this.objValor) +'&'+ varValor;
							
					break;				
				
				}		
				
					
				}else{
				
			}
		}	
}
	
	this.varValor   = varValor.substr(0,(varValor.length-1));	
	
			switch (this.elMethod){
				/*  
				'
				'	enviando formulário por POST no ajax
				'
				*/	
				case 'post':

				xmlhttp.abort()
				xmlhttp.open('POST', this.varArquivo+'?'+numero_rnd(999), true);
				
				xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; iso-8859-1");
				xmlhttp.setRequestHeader("CharSet", "iso-8859-1")
				xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
				xmlhttp.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
				xmlhttp.setRequestHeader("Pragma", "no-cache");
				
				xmlhttp.send(this.varValor);

				xmlhttp.onreadystatechange = function(){
					
					if(xmlhttp.readyState == 4){
									
									var txtRetorno   = xmlhttp.responseText;
									
									tagScript(txtRetorno)
									pega(objDiv).innerHTML = txtRetorno;																																			

					}
				}
					
					
				break;


				/*  
				'
				'	enviando formulário por GET no ajax
				'
				*/	
				case 'get':
				
				xmlhttp.abort()
				xmlhttp.open('GET', this.varArquivo+"?"+this.varValor,true);
				
				xmlhttp.setRequestHeader("Content-Type", "text/html; charset=iso-8859-1");
				
				xmlhttp.onreadystatechange = function(){
				
						if(xmlhttp.readyState == 4){
								var txtRetorno         = xmlhttp.responseText;
								
								tagScript(txtRetorno)
								pega(objDiv).innerHTML = txtRetorno;	
									
						}

				}
				xmlhttp.send(null)
														
				break;


				/*  
				'
				'	enviando formulário por POST dando reload na página
				'
				*/	
				case 'post/submit':
								
					formulario.method = 'post'
					formulario.action = this.varArquivo;
					formulario.submit(); 				
					
				break


				/*  
				'
				'	enviando formulário por GET dando reload na página
				'
				*/
				case 'get/submit':
				
					formulario.method = 'get'
					formulario.action = this.varArquivo;
					formulario.submit(); 				
					
				break				

				/*  
				'
				'	requisitando um XML com template em XSL pelo methodo GET
				'
				*/
				case 'xml':
				
					var ConteudoTransformado;
					var objeDiv = pega(objDiv);
					var objeXml;
					var objeXsl;
					
					/* Caso Internet Explorer */
					if (window.ActiveXObject) {

						var objeXml   = new ActiveXObject("Microsoft.XMLDOM");
						objeXml.async = false;
						objeXml.load(this.varArquivo+'?'+numero_rnd(999));
					
						var objeXsl   = new ActiveXObject("Microsoft.XMLDOM");
						objeXsl.async = false;
						objeXsl.load(this.varArquivoXLS+'?'+numero_rnd(999));
					
						ConteudoTransformado = objeXml.transformNode(objeXsl);
						objeDiv.innerHTML    = ConteudoTransformado;
						
						objXmlPopulado = true;
					
					
					/* Caso Fire Fox */
					} else if(window.XMLHttpRequest) {
						
						var objeXSLTProcessor;
						var objeXmlDoc;
						var objeXSLT;
					
						objeXSLTProcessor = new XSLTProcessor();
						
						objeXsl = new XMLHttpRequest();
						objeXsl.open("GET", this.varArquivoXLS+'?'+numero_rnd(999), false);
						objeXsl.send(null);
						
						objeXSLT = objeXsl.responseXML;
						objeXSLTProcessor.importStylesheet(objeXSLT);
						
						objeXml = new XMLHttpRequest();
						objeXml.open("GET", this.varArquivo+'?'+numero_rnd(999), false);
						objeXml.send(null);
						
						objeXmlDoc = objeXml.responseXML;
						
						ConteudoTransformado = objeXSLTProcessor.transformToFragment(objeXmlDoc, document);
						objeDiv.innerHTML    = '';
						objeDiv.appendChild(ConteudoTransformado);
						
						objXmlPopulado = true;

					}
				
				
				break;

				default:
				
					/* Nenhum valor de methodo de envio sendo passado, caimos aqui. */
				
				break;
			}			
document.formDemo.reset()
}
/* disparando formulario */


}