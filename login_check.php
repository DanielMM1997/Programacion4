<?php
/**
 * Este script comprueba si las credenciales son ciertas e
 * inicia sesión si el usuario existe
 */
include_once 'business.class.php';
include_once 'presentation.class.php';

if( isset($_POST['user']) && isset($_POST['pw']) ){
    if(User::login($_POST['user'],$_POST['pw'])){
        header('Location: index.php');
    } else{
        View::message_page("Datos erróneos", "login.php", 2);
    }
}