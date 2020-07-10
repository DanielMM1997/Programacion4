<?php
/**
 * Este script guarda el formulario de consulta en el fichero contact
 */
include_once 'presentation.class.php';
View::start('Confirmation');
echo "<h3>Sus datos han sido enviados correctamente</h3>
    <p>Gracias " . $_POST['name'] . "</p>
    <p>En breve nos pondremos en contacto con usted, mediante el correo: " . $_POST['email'] . "</p>
    <a href='index.php'>Volver a página principal</a>";
View::end();