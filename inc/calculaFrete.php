<?php
	require_once('def.php');
  require_once('api_frete_rapido.php');


  // Remove tudo o que não é número para fazer a pesquisa
  $cep = preg_replace("/[^0-9]/", "", $_POST['cep']);

	$url = "https://viacep.com.br/ws/".$cep."/json/";


  try {
    $json = file_get_contents($url);
		$obj = json_decode($json);
		$_SESSION['endereco']['cep'] = $cep;
		$_SESSION['endereco']['logradouro'] = $obj->logradouro;
		$_SESSION['endereco']['bairro'] = $obj->bairro;

		$sql = 'SELECT c.id, c.cidade, c.idEstado, e.estado
		FROM CidadesIBGE c
		JOIN Estados e ON e.id = c.idEstado
		WHERE c.codigoIBGE='.$obj->ibge.';';
		$q = mysqli_query($link , $sql);
		$row = mysqli_fetch_array($q);

		$_SESSION['endereco']['idCidade'] = $row['id'];
		$_SESSION['endereco']['cidade'] = ucwords(mb_strtolower($row['cidade']));
		$_SESSION['endereco']['idEstado'] = $row['idEstado'];
		$_SESSION['endereco']['estado'] = $row['estado'];

		// Valor e prazo
		$freteRapido = new FreteRapido();
		$fretes = $freteRapido->calculaFreteCEP($cep);

  } catch (\Exception $e) {
    echo "CEP não encontrado";
  }


?>
<!-- <select class="form-control" name="frete" id="frete"> -->
  <!-- <option disabled selected>Escolha uma opção</option> -->

<!-- </select> -->
