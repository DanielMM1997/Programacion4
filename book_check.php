<?php
/**
 * Este script inserta el nuevo ticket en la tabla de tickets
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

$res = DB::execute_sql('INSERT INTO tickets (idcliente, idactividad, precio, unidades)
    VALUES (?,?,?,?)', 
    array($_POST["user"], $_POST["activity"], $_POST["price"], $_POST['quantity']));

if($res){
    View::message_page("Su compra se ha efectuado correctamente",
                    "activity.php?id={$_POST['activity']}",5);
}else {
    View::message_page("Se produjo un error durante la compra",
    "book_activity.php?id='{$_POST['activity']}&precio={$_POST['price']}",5);
}