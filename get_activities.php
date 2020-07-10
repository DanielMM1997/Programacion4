<?php

include_once 'data_access.class.php';

// Builds the SQL query for the searcher
$params[0] = "%". ($_GET['q'] ?? "") ."%";
$statement = 'SELECT id,nombre,tipo,inicio,precio 
              FROM actividades 
              WHERE nombre LIKE ?';

if(!empty($_GET['t'])){
    $statement .= ' AND tipo = ?';
    $params[] = $_GET['t'];
}
if(!empty($_GET['sd'])){
    $statement .= ' AND inicio >= ?';
    $start_day = strtotime($_GET['sd']);
    $params[] = $start_day;
}
if(!empty($_GET['ed'])){
    $statement .= ' AND inicio <= ?';
    $end_day = strtotime($_GET['ed']);
    $params[] = $end_day;
}

$statement .= 'ORDER BY inicio;';

$res = DB::execute_sql($statement, $params);
$res->setFetchMode(PDO::FETCH_NAMED);
$activities = $res->fetchAll();

header('Content-type: application/json');
echo json_encode($activities);