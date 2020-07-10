<?php
/**
 * Este script utiliza el contenido del formulario en activity_form.php
 * para modificar el contenido de una actividad
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

$id = $_GET["id"];

if(isset($_POST["submit"])){
    
    $nombre=$_POST["nombre"];
    $tipo=$_POST["tipo"];
    $descripcion=$_POST["descripcion"];
    $precio=$_POST["precio"];
    $aforo=$_POST["aforo"];
    $fecha_numerico = strtotime($_POST["fecha"]);
    $duracion= $_POST['duracion']*60;
    
    $consulta="UPDATE actividades SET nombre=:nombre, tipo=:tipo, descripcion=:desc,
    precio=:precio, aforo=:aforo, inicio=:inicio, duracion=:duracion";
    
    $params = array( ":nombre"=>$nombre, ":tipo"=>$tipo, ":desc"=>$descripcion, ":precio"=>$precio, 
                     ":aforo"=>$aforo, ":inicio"=>$fecha_numerico, ":duracion"=>$duracion);
   
    switch($_FILES["imagen"]['error']){
        case 0: //Image uploaded succesfully
            $imagen=file_get_contents($_FILES["imagen"]['tmp_name']);
            $consulta .= ",imagen=:imagen";
            $params[':imagen'] = $imagen;
        case 4: //No image uploaded
            $no_error = true; //case 0 and case 4 are correct cases
            break;
        case 2:
            View::message_page("Hubo un error al modificar, la imagen supera los 60KB.",
                                    "activity_form.php?id=$id",7);
            break;
        default:
            View::message_page("Hubo un error con la imagen, intentelo nuevamente.",
                                    "activity_form.php?id=$id",5);
    }
    
    if(isset($no_error)){
        $consulta .= " WHERE id = :id;";
        $params[':id'] = $id;
        $res = DB::execute_sql($consulta, $params);
        
        if($res){
            View::message_page("Se actualizó correctamente","my_activities.php",5);
        }else{
            View::message_page("Hubo un error al actualizar, intentelo nuevamente.",
                                "activity_form.php?id=$id",5);
        }   
    }
}