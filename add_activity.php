<?php
/**
 * Este script utiliza el contenido del formulario en activity_form.php
 * para crear una actividad nueva
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

if(isset($_POST["submit"])){
    $empresa = User::getLoggedUser();
    
    $nombre=$_POST["nombre"];
    $tipo=$_POST["tipo"];
    $descripcion=$_POST["descripcion"];
    $precio=$_POST["precio"];
    $aforo=$_POST["aforo"];
    $fecha_numerico = strtotime($_POST["fecha"]);
    $duracion= $_POST['duracion']*60;
    switch($_FILES["imagen"]['error']){
        case 0:
            $imagen=file_get_contents($_FILES["imagen"]['tmp_name']);
            $idempresa=$empresa['id'];
            
            
            
            $res = DB::execute_sql('INSERT INTO actividades (idempresa, nombre, tipo, descripcion, precio, aforo, inicio, duracion, imagen) 
                                    VALUES (:idemp, :nombre, :tipo, :descrip, :precio, :aforo, :inicio, :duracion, :img);',
                                    array(":idemp"=>$idempresa, ":nombre"=>$nombre, ":tipo"=>$tipo, ":descrip"=>$descripcion, 
                                    ":precio"=>$precio, ":aforo"=>$aforo, ":inicio"=>$fecha_numerico, ":duracion"=>$duracion, ":img"=>$imagen));
            
            if($res){
                View::message_page("Se insertó la actividad correctamente",
                                    "my_activities.php",5);
            }else{
                View::message_page("Hubo un error al insertar, intentelo nuevamente.",
                                    "activity_form.php",5);
            }
            break;
        case 2:
            View::message_page("Hubo un error al insertar, la imagen supera los 60KB.",
                                    "activity_form.php",10);
            break;
        default:
            View::message_page("Hubo un error con la imagen, intentelo nuevamente.",
                                    "activity_form.php",10);
    }
}

?>