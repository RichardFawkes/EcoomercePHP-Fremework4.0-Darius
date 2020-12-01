// JavaScript Document


	function mascara_data(obj,teclapres){
		
		data = document.getElementById(obj.id);
		var tecla = teclapres.keyCode;
		if(tecla != 8 && tecla != 46){		
		
			if(data.value.length == 2){
				data.value = data.value+"/";
			}else if(data.value.length == 5){
				data.value = data.value+"/";
			}else{
				return false;
			}
		}else{
			return false;			
		}			
	}



	function mascara_hora(obj,teclapres){
		
		hora = document.getElementById(obj.id);
		var tecla = teclapres.keyCode;
		if(tecla != 8 && tecla != 46){		
		
			if(hora.value.length == 2){
				hora.value = hora.value+":";
			}else{
				return false;
			}
		}else{
			return false;			
		}			
	}



	
	function foco_inicial(){
		document.getElementById('nome').focus();	
	}
	
	window.onload = foco_inicial;
	
	
	
	
	function mascara_inscricao_estadual(obj,teclapres){	
		ie = document.getElementById(obj.id);
		var tecla = teclapres.keyCode;
		
		if(tecla != 8 && tecla != 46){		


			if(ie.value.length == 3){
				ie.value = ie.value+".";
			}else if(ie.value.length == 7){
				ie.value = ie.value+".";
			}else if(ie.value.length == 11){
				ie.value = ie.value+".";
			}else{
				return false;
			}
		}else{
			return false;			
		}			
	}

	function mascara_cnpj(obj,teclapres){
		
		cnpj = document.getElementById(obj.id);
		var tecla = teclapres.keyCode;
		if(tecla != 8 && tecla != 46){		
		
			if(cnpj.value.length == 2){
				cnpj.value = cnpj.value+".";
			}else if(cnpj.value.length == 6){
				cnpj.value = cnpj.value+".";
			}else if(cnpj.value.length == 10){
				cnpj.value = cnpj.value+"/";
			}else if(cnpj.value.length == 15){
				cnpj.value = cnpj.value+"-";
			}else{
				return false;
			}
	
		}else{
			return false;			
		}			
			
	}

	function mascara_cep(obj,teclapres){
		
		cep = document.getElementById(obj.id);
		var tecla = teclapres.keyCode;
		if(tecla != 8 && tecla != 46){		
		
			if(cep.value.length == 5){
				cep.value = cep.value+"-";
			}else{
				return false;
			}
	
		}else{
			return false;			
		}			
			
	}

	