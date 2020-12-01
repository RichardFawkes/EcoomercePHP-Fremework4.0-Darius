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
    $filename = "relatoriopedidos_" . date('Ymd') . ".csv"; // Create file name

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('#','Nome Cliente', 'Estado', 'Data', 'Item', 'QTD','ValorUnitario','Total','Pago');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    $sql = 'SELECT (c.id)idCompra,u.nome,c.idUser,es.estado,pd.titulo,cp.qtde,pq.valorUnitario,c.pago,formata_data(c.dataHora)data,cat.categoria,cxp.idCategoria,(cp.qtde * pq.valorUnitario )total
    FROM Compras_X_Produtos cp
    JOIN Compras c ON c.id = idCompra
    LEFT JOIN Categorias_X_Produtos cxp ON cxp.idProduto = cp.idProduto
	LEFT JOIN Categorias cat ON cat.id = cxp.idCategoria
    LEFT JOIN Users_X_Enderecos ue ON ue.idUser = c.idUser
    LEFT JOIN Users u ON u.id = c.idUser
    LEFT JOIN Estados es ON es.id = ue.idEstado
    LEFT JOIN Produtos pd ON cp.idProduto = pd.id
    LEFT JOIN PrecosQuantidades pq ON cp.idProduto = pq.idProduto
    WHERE pago = '.$_GET['pago'].' and DATE( c.dataHora ) between "'.$_GET['datainicio'].'" and "'.$_GET['datafinal'].'" AND cxp.idCategoria = '.$_GET['id'].' group by titulo,nome order by idCompra';
    $res = mysqli_query($link,$sql);
    while($row = mysqli_fetch_array($res)){
        $lineData = array($row['idCompra'], $row['nome'], $row['estado'], $row['data'],$row['titulo'],$row['qtde'],$row['valorUnitario'],$row['total'],$row['pago']);
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
