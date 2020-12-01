<?php

require_once($siteHD.'inc/def.php');


class Carrinho extends conexao{


	public function getSubTotal(){

		$sql = 'SELECT 
		SUM(
		  (SELECT valorUnitario 
			FROM PrecosQuantidades
			WHERE idProduto = c.idProduto
			AND qtde >= c.qtde
			ORDER BY valorUnitario DESC
			LIMIT 1
		  ) * c.qtde
		) subTotal
	FROM Carrinho c
	WHERE c.idUser = '.$_SESSION['idUser'].';';
		$q = mysqli_query($this->link , $sql);
		$r = mysqli_fetch_assoc($q);
		if(is_null($r['subTotal'])){
			$r['subTotal'] = 0;
		}

		return $r['subTotal'];
	}



	public function getProdutos(){

		$sql = 'SELECT p.titulo titulo, p.img , SPLIT_STRING(p.descricao,"<br><br>",1) descricao, c.qtde , c.id idCarrinho , p.id idProduto , p.url , IF(cor.cor IS NULL , "" , CONCAT("Tampa: " , cor.cor)) cor, estoque, quantidade
		, (SELECT valorUnitario FROM PrecosQuantidades WHERE idProduto = c.idProduto AND qtde >= c.qtde ORDER BY valorUnitario DESC LIMIT 1) valorUnitario
				FROM Carrinho c
				JOIN Produtos p ON p.id = c.idProduto
				LEFT JOIN Cores cor ON cor.id = c.idCorTampa
			
				WHERE c.idUser = '.$_SESSION['idUser'].'
				ORDER BY valorUnitario DESC
		
	    

		 
		
	
		;';
		$q = mysqli_query($this->link , $sql);

		$arrayProdutos = array();

		while($r = mysqli_fetch_assoc($q)){
			$arrayProdutos[] = array (
				'idCarrinho' => $r['idCarrinho'] ,
				'idProduto' => $r['idProduto'] ,
				'titulo' => $r['titulo'] ,
				'descricao' => limita_caracteres(nl2br(strip_tags($r['descricao'])),100) ,
				'preco' => $r['valorUnitario'] , 
				'qtde' => $r['qtde'] ,
				'img' => $r['img'] ,
				'url' => $r['url'] ,
				'cor' => $r['cor'],
				'estoque' => $r['estoque'],
				'quantidade' => $r['quantidade']
				

			);
			}

			return $arrayProdutos;
		}



		public function insereProduto($idProduto , $qtde , $idCorTampa=1){

			$sel = 'SELECT qtde FROM Carrinho WHERE idUser = '.$_SESSION['idUser'].' AND idProduto='.$idProduto.' AND  idCorTampa='.$idCorTampa.';';
			$res = mysqli_query($this->link , $sel);
			$r = mysqli_fetch_array($res);

			if($r['qtde']==""){
				$sql = 'INSERT INTO Carrinho (idUser , idProduto , qtde , idCorTampa , dataHora, idProjeto)
				VALUES ('.$_SESSION['idUser'].' , '.$idProduto.' , '.$qtde.' , '.$idCorTampa.' , NOW(),"'.$_GET['id'].'");';
			}else{
				$sql = 'INSERT INTO Carrinho (idUser , idProduto , qtde , idCorTampa , dataHora, idProjeto)
				VALUES ('.$_SESSION['idUser'].' , '.$idProduto.' , '.$qtde.' , '.$idCorTampa.' , NOW(),"'.$_GET['id'].'");';
			}

			mysqli_query($this->link , $sql);

		}


		public function removeProduto($id){

			$sql = 'DELETE FROM Carrinho WHERE idUser = '.$_SESSION['idUser'].' AND id = '.$id.';';
			mysqli_query($this->link , $sql);

		}

		public function limpaCarrinho(){

			$sql = 'DELETE FROM Carrinho WHERE idUser = '.$_SESSION['idUser'].';';
			mysqli_query($this->link , $sql);

		}



		public function getFrete(){
			$sql = 'SELECT tc.id , tc.prazo_entrega , tc.preco_frete
			FROM Transportadoras_Cotacoes tc
			WHERE tc.idUser = "'.$_SESSION['idUser'].'" AND tc.ativo = 1 AND selecionado = 1;';

			$q = mysqli_query($this->link , $sql);
			$r = mysqli_fetch_assoc($q);

			return $r['preco_frete'];

		}



	}

	?>
