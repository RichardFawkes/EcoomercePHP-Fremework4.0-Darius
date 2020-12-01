<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
require_once('inc/def.php');



$sql = 'SELECT c.id, c.idEstado, e.estado
FROM CidadesIBGE c
JOIN Estados e ON e.id = c.idEstado
WHERE c.codigoIBGE='.$_GET['id'].';';
$q = mysqli_query($link , $sql);
$row = mysqli_fetch_array($q);

$json = array('idCidade' => $row['id'], 'idEstado'=>$row['idEstado'],'estado'=>$row['estado'] );


echo json_encode($json);
