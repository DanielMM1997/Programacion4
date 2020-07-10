<?php
/**
 * Este script muestra la información de contacto de la empresa GC activa
 * y un formulario para dudas
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

View::start('Contacta con nosotros');
View::navigation();
echo "<h1>Formulario de contacto</h1>
    <h3>Si desea contactar con nosotros puedes:</h3>
    <ul>
        <li>LLamar a nuestro teléfono fijo: 828954627 (de lunes a viernes de 8 am a 4 pm)</li>
        <li>Escribir un mensaje al teléfono movil: +34 652187564</li>
        <li>Escribir un mensaje al correo electrónico: GCActivate@info.com</li>
    </ul>
    <h3>Si eres una empresa envíenos a través de este formulario sus consultas, 
    sugerencias o quejas referentes a la página web o sus aplicaciones</h3>";    

echo "<div id='formulario'>
    <form action='contact_confirmation.php' method='post'>
        <div class='row'>
            <div class='col-20'><label>Nombre: </label></div>
            <div class='col-80'><input class='contactform' type='text' name='name' required></div>
        </div>
        <div class='row'>
            <div class='col-20'><label>NIF: </label></div>
            <div class='col-80'><input class='contactform' type='text' name='nif' required></div>
        </div>
        <div class='row'>
            <div class='col-20'><label>E-mail: </label></div>
            <div class='col-80'><input class='contactform' type='email' name='email' required></div>
        </div>
        <div class='row'>
            <div class='col-20'><label>Asunto: </label></div>
            <div class='col-80'><input class='contactform' type='text' name='matter' required></div>
        </div>
        <div class='row'>
            <div class='col-20'><label>Mensaje: </label></div>
            <div class='col-80'><textarea class='contactform' rows='10' name='msg' required></textarea></div>
        </div>
        <div class='row'>
            <input class='contactform' type='submit' value='Enviar'></div>
    </form>
</div>";
View::footer();
View::end();
