<?php
/**
 * Este script muestra un formulario con la cantidad de tickets a comprar 
 * y lo manda a book_check
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

$idactivity = $_GET['id'];
$price = $_GET['precio'];

$user = User::getLoggedUser();
if ($user) {
    View::start("Reservar");

    View::navigation();
    
    if($user["tipo"] == 3){
        echo'<form method="post" action="book_check.php">
            <fieldset>
                <legend>Comprar tickets</legend>
                cantidad: <input type="number" min="1" name="quantity">
                <input type="hidden" name="user" value="' . $user["id"] . '">
                <input type="hidden" name="activity" value="' . $idactivity . '">
                <input type="hidden" name="price" value="' . $price . '">
                <input type="submit" value="Comprar">
            </fieldset>
        </form>';
    }else {
        echo"<h2>Solo clientes pueden reservar</h2>";
    }
    View::footer();
    View::end();
}else {
    header('Location:login.php');
}