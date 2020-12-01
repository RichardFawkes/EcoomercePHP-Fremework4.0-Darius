<?php
require_once('inc/def.php');
libera_acessoSite(1, 2, 3, 4, 5);

if (@$_POST['idCidade'] == ''
  || @$_POST['idEstado'] == ''
  || @$_POST['nome'] == ''
  || @$_POST['sobrenome'] == ''
  || @$_POST['telefone'] == ''
  || @$_POST['cep'] == ''
  || @$_POST['bairro'] == ''
  || @$_POST['logradouro'] == ''
  || @$_POST['numero'] == ''
  || @$_POST['titulo'] == ''

) {
    ir($site.'endereco', 'Por favor preencha os campos para calcular o valor do frete.');
    exit;
}

$sql = 'SELECT id FROM CidadesIBGE WHERE cidade = (SELECT cidade FROM CidadesIBGE WHERE id = '.$_POST['idCidade'].') AND idEstado = '.$_POST['idEstado'].';';
$q = mysqli_query($link, $sql);
$r = mysqli_fetch_assoc($q);
$idCidade = $r['id'];
if ($_POST['tipo_pessoa']=='PF') {
    $cpf = ($_POST['cpf']=="")? 'NULL' : '"'.addslashes($_POST['cpf']).'"';
    $cnpj = 'NULL';
    $inscricao_estadual = 'NULL';
    $empresa = 'NULL';
} else {
    $cpf = 'NULL';
    $cnpj = ($_POST['cnpj']=="")? 'NULL' : '"'.addslashes($_POST['cnpj']).'"';
    $inscricao_estadual = ($_POST['inscricao_estadual']=="")? 'NULL' : '"'.addslashes($_POST['inscricao_estadual']).'"';
    $empresa = ($_POST['empresa']=="")? 'NULL' : '"'.addslashes($_POST['empresa']).'"';
}



if (!isset($_POST['id'])) {
    $sql = 'INSERT INTO Users_X_Enderecos (
      idUser
      , nome
      , sobrenome
      , email
      , empresa
      , cnpj
      , inscricao_estadual
      , cpf
      , tipo_pessoa
      , telefone
      , informacoes_adicionais
      , idEstado
      , idCidade
      , cep
      , bairro
      , logradouro
      , numero
      , complemento
      , titulo
    ) VALUES (
      "'.$_SESSION['idUser'].'"
      , "'.addslashes($_POST['nome']).'"
      , "'.addslashes($_POST['sobrenome']).'"
      , "'.addslashes($_POST['email']).'"
      , '.$empresa.'
      , '.$cnpj.'
      , '.$inscricao_estadual.'
      , '.$cpf.'
      , "'.addslashes($_POST['tipo_pessoa']).'"
      , "'.addslashes($_POST['telefone']).'"
      , "'.addslashes($_POST['informacoes_adicionais']).'"
      , "'.addslashes($_POST['idEstado']).'"
      , "'.$idCidade.'"
      , "'.addslashes($_POST['cep']).'"
      , "'.addslashes($_POST['bairro']).'"
      , "'.addslashes($_POST['logradouro']).'"
      , "'.addslashes($_POST['numero']).'"
      , "'.addslashes($_POST['complemento']).'"
      , "'.addslashes($_POST['titulo']).'"
    );';
    ir($site."meus-enderecos");

} else {
    $sql = 'INSERT INTO Users_X_Enderecos (
      idUser
      , nome
      , sobrenome
      , email
      , empresa
      , cnpj
      , inscricao_estadual
      , cpf
      , tipo_pessoa
      , telefone
      , informacoes_adicionais
      , idEstado
      , idCidade
      , cep
      , bairro
      , logradouro
      , numero
      , complemento
      , titulo
    ) VALUES (
      "'.$_SESSION['idUser'].'"
      , "'.addslashes($_POST['nome']).'"
      , "'.addslashes($_POST['sobrenome']).'"
      , "'.addslashes($_POST['email']).'"
      , '.$empresa.'
      , '.$cnpj.'
      , '.$inscricao_estadual.'
      , '.$cpf.'
      , "'.addslashes($_POST['tipo_pessoa']).'"
      , "'.addslashes($_POST['telefone']).'"
      , "'.addslashes($_POST['informacoes_adicionais']).'"
      , "'.addslashes($_POST['idEstado']).'"
      , "'.$idCidade.'"
      , "'.addslashes($_POST['cep']).'"
      , "'.addslashes($_POST['bairro']).'"
      , "'.addslashes($_POST['logradouro']).'"
      , "'.addslashes($_POST['numero']).'"
      , "'.addslashes($_POST['complemento']).'"
      , "'.addslashes($_POST['titulo']).'"
    );';

    $upd = 'UPDATE Users_X_Enderecos SET ativo=0 WHERE idUser = "'.$_SESSION['idUser'].'" AND id = "'.$_POST['id'].'";';
    ir($site."meus-enderecos");

}
$q = mysqli_query($link, $sql) or die(mysqli_error($link));
$q = mysqli_query($link, $upd) or die(mysqli_error($link));

ir($site."meus-enderecos");
