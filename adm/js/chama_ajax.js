// JavaScript Document

function obj_XMLHTTPRequest(){

	//IE
	if(window.ActiveXObject){
		var versoes = ["MSXML2","MICROSOFT","MSXML","MSXML3"];
		for(var i=0; i<versoes.length; i++){
			try{
				return new ActiveXObject(versoes[i]+".XMLHTTP");	
			}//try
			catch(e){}//esse catch é só pra não dar erro.. não usa pra nada.
		}//for
	}//if
	else {//Mozilla e outros
		if(window.XMLHttpRequest){
			return new XMLHttpRequest();
		}//if XMLHttpRequest
	}//else
}//function




var ajax;
function chama_ajax(div,urlTexto){
	//valida o objeto Ajax
	ajax = obj_XMLHTTPRequest();
//	alert(ajax);
	
	//recebe a função progresso para avaliar o envio e o carregamento do Ajax
	ajax.onreadystatechange = progresso;
	
	//executa o arquivo PHP
	ajax.open("GET",urlTexto,true);
	
	//Seção HEADER NO_CACHE
	ajax.setRequestHeader('Cache-Control','no-store,no-cache,must-revalidate');
	ajax.setRequestHeader('Cache-Control','post-check=0,pre-check=0');
	ajax.setRequestHeader('Pragma','no-cache');	
	
	ajax.send(null);


	function progresso(){
		if(ajax.readyState == 4){
			if(ajax.status == 200){
				var msg = document.getElementById(div);
				var textoAjax = ajax.responseText;
				msg.innerHTML = textoAjax;
			}
		}
	}
}