<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ("iugu-php-master/lib/Iugu.php");

// API KEY desenvolvimento SM
Iugu::setApiKey("ce8f797df93da1b54c71e53a4f772864");

// API KEY de Produção
//Iugu::setApiKey("39ba5657e6938cfb6e1e0260e9dcdf00");




/*
 * Cria um cliente
 * nome, emial,cpf,nota string
 *
 * retorna o customer_id , identificador na plataforma
 */
function criaCliente($nome, $email, $cpf, $notas, $endereco, $numero, $complemento, $cidade, $estado, $pais, $cep)
{
    $return = Iugu_Customer::create(Array(
        "email" => $email,
        "name" => $nome,
        "cpf_cnpj" => $cpf,
        "notes" => $notas,
        "street" => $endereco,
        "number" => $numero,
        "complement" => $complemento,
        "city" => $cidade,
        "state" => $estado,
        "country" => $pais,
        "zip_code" => $cep
    ));
    
    return $return['id'];
}

/*
 * Retorna os dados do cliente em formato array
 * customer_id string
 */
function obtemCliente($customer_id)
{
    $retorno = Iugu_Customer::fetch($customer_id);
    return $retorno;
}

/*
 * Deleta o cliente na plataforma, desde que não tenha historico de pagamento
 * customer_id string
 */
function deleteCliente($customer_id)
{
    $customer = Iugu_Customer::fetch($customer_id);
    $customer->delete();
}

/*
 * Gera um boleto
 * $customer_id, $ddd, $telefone string
 * $itens array no seguinte formato exemplo
 * 
 * array(
        Array("description" => "Caderno","quantity" => "1", "price_cents" => "10000"),
        Array("description" => "bolsa","quantity" => "2", "price_cents" => "40000"),
        Array("description" => "queijo","quantity" => "1", "price_cents" => "50000"),    
    );
 * 
 * 
 * 
 */
function geraBoleto($customer_id, $ddd, $telefone, $itens)
{
    $cliente = Iugu_Customer::fetch($customer_id);
    
    $dados_cliente = Array(
        
        "name" => $cliente['name'],
        "phone_prefix" => "11",
        "phone" => "984770406",
        "email" => $cliente['email'],
        
        "address" => Array(
            "street" => $cliente['street'],
            "number" => $cliente['numbe'],
            "city" => $cliente['city'],
            "state" => $cliente['state'],
            "country" => $cliente['country'],
            "zip_code" => $cliente['zip_code']
        )
    );
    
    $boleto = Iugu_Charge::create(array(
        
        "customer_id" => $customer_id,
        "method" => "bank_slip",
        "payer" => $dados_cliente,
        "items" => $itens
    ));
    
    return $boleto;
}

/*
 * Gera um pagamento com cartão de credito
 * $customer_id, $ddd, $telefone , $token string
 * $token recebido pela plataforma, só pode ser usado uma vez
 * $itens array no seguinte formato exemplo
 *
 * array(
     Array("description" => "Caderno","quantity" => "1", "price_cents" => "10000"),
     Array("description" => "bolsa","quantity" => "2", "price_cents" => "40000"),
     Array("description" => "queijo","quantity" => "1", "price_cents" => "50000"),
   );
 *
 *
 *
 */
function geraCC($customer_id, $ddd, $telefone, $itens,$token)
{
    $cliente = Iugu_Customer::fetch($customer_id);
    
    $dados_cliente = Array(
        
        "name" => $cliente['name'],
        "phone_prefix" => "11",
        "phone" => "984770406",
        "email" => $cliente['email'],
        
        "address" => Array(
            "street" => $cliente['street'],
            "number" => $cliente['numbe'],
            "city" => $cliente['city'],
            "state" => $cliente['state'],
            "country" => $cliente['country'],
            "zip_code" => $cliente['zip_code']
            )
        );
    
    $cc = Iugu_Charge::create(array(        
        "customer_id" => $customer_id,
        "token" => $token,
        "payer" => $dados_cliente,
        "items" => $itens
    ));
    
    return $cc;
}

?>
