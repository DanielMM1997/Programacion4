<?php
/**
 * Este script borra la actividad pasada con idactividad
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

$id = $_POST["id"];
$empresa = User::getLoggedUser();
$res = DB::execute_sql('DELETE FROM actividades WHERE id = ? AND idempresa = ?;', 
                        array($id,$empresa['id']));
$result = new stdClass();
if($res && $res->rowCount() > 0){
    $result->deleted = true;
}else{
    $result->deleted = false;
}

header('Content-type: application/json');
echo json_encode($result);