<?php
/**
 * Este script contiene un formulario usado tanto para modificar
 * una actividad como añadir una nueva
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

$user = User::getLoggedUser();
if(isset($_GET['id'])){
    $new = false;
    $id = $_GET["id"];

    $res = DB::execute_sql('SELECT * FROM actividades WHERE id = ?', array($id));
    
    $res->setFetchMode(PDO::FETCH_NAMED);
    
    $activity = $res->fetch();
    $action = "modify_activity.php?id=$id";
    $image_required = "";
} else {
    $new = true;
    $activity['duracion'] = 0;
    $activity['nombre'] = '';
    $activity['tipo'] = '';
    $activity['descripcion'] = '';
    $activity['precio'] = '';
    $activity['aforo'] = '';
    $activity['inicio'] = time();
    $action = "add_activity.php";
    $image_required = "required";
}
if($user && ($new || $activity['idempresa'] === $user['id'])){
    View::start("empresa");
    View::navigation();
    echo "<h1>Actividad</h1>";

    $duracion = $activity['duracion']/60;  
    echo 
        "<div id='formulario'>";
    
    echo "<form action='$action' method='POST' enctype='multipart/form-data' onsubmit='return validationActivity()'>";
    echo        "<div class='row'>
                    <div class='col-20'><label>Nombre: </label></div>
                    <div class='col-80'><input class='contactform' type='text' name='nombre' id='nombre' value='". $activity['nombre'] ."' ><span id='spannombre'></span></div>
                </div>
                <div class='row'>
                    <div class='col-20'><label>Tipo: </label></div>
                    <div class='col-80'><input class='contactform' type='text' name='tipo' id='tipo' value='". $activity['tipo'] ."' ><span id='spantipo'></span></div>
                </div>
                <div class='row'>
                    <div class='col-20'><label>Descripcion: </label></div>
                    <div class='col-80'><input class='contactform' type='text' name='descripcion' id='descripcion' value='". $activity['descripcion'] ."'><span id='spandescripcion'></span></div>
                </div>
                <div class='row'>
                    <div class='col-20'><label>Precio: </label></div>
                    <div class='col-80'><input class='contactform' type='number' step='any' name='precio' id='precio' style='height:34px' value='". $activity['precio'] ."' ><span id='spanprecio'></span></div>
                </div>
                <div class='row'>
                    <div class='col-20'><label>Aforo: </label></div>
                    <div class='col-80'><input class='contactform' type='number' name='aforo' id='aforo' style='height:34px' value='". $activity['aforo'] ."' ><span id='spanaforo'></span></div>
                </div>
                <div class='row'>
                    <div class='col-20'><label>Inicio: </label></div>
                    <div class='col-80'><input class='contactform' type='date' name='fecha' id='fecha' style='height:34px' value='". date("Y-m-d", $activity['inicio']) ."' ><span id='spaninicio'></span></div>
                </div>
                <div class='row'>
                    <div class='col-20'><label>Duración (en minutos): </label></div>
                    <div class='col-80'><input class='contactform' type='number' name='duracion' id='duracion' style='height:34px' value='". $duracion ."' ><span id='spanduracion'></span></div>
                </div>
                <div class='row'>
                <div class='row'>
                    <div class='col-20'><label>Imagen: </label></div>
                    <div class='col-80'><input type='hidden' name='MAX_FILE_SIZE' value='65536' />
                    <input class='contactform' type='file' name='imagen' id='imagen' $image_required></div>
                </div>
                <input class='contactform' type='submit' value='Enviar' name='submit'>
                </div>
            </form>
        </div>";
        
    View::footer();
    View::end();
}else {
    View::message_page("Utilidad solo para empresas","index.php",10);
}

?>