<?php
require_once('../../inc/def.php');
libera_acesso(1);
// Determina que o arquivo é uma planilha do Excel
header("Content-type: application/vnd.ms-excel");

// Força o download do arquivo
header("Content-type: application/force-download");



header("Pragma: no-cache");

// Imprime o conteúdo da nossa tabela no arquivo que será gerado
    $delimiter = ",";
    // Seta o nome do arquivo
    $filename = "newsletters_" . date('Ymd') . ".csv"; // Create file name

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('Usuário', 'Email', 'IP', 'City', 'Data do Cadastro');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    $sql = 'SELECT IFNULL(u.nome,"-") nome, n.email, n.ip, formata_data_hora(n.dataHora) dataHoraTxt
    FROM Newsletter n
    LEFT JOIN Users u ON u.id = n.idUser
    ORDER BY n.dataHora DESC;';
    $res = mysqli_query($link,$sql);
    while($row = mysqli_fetch_array($res)){
        $lineData = array($row['nome'], $row['email'], $row['ip'], $row['dataHoraTxt']);
        fputcsv($f, $lineData, $delimiter);
    }

    //move back to beginning of file
    fseek($f, 0);

    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer
    fpassthru($f);
?>
