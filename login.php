<?php
/**
 * Este script contiene el formulario para iniciar sesión
 */
include_once 'presentation.class.php';

View::start('Login');
View::navigation();


echo '<div class="formlogin">
    <form action="login_check.php" method="POST">
        <h2>Identifícate</h2>
        <input type="text" placeholder="&#128272; Usuario" name="user" autofocus>
        <input type="password" placeholder="&#128272; Contraseña" name ="pw"> 
        <input type="submit" value="Iniciar sesión">
        <p class="loginlink">¿No tienes cuenta? <a href="#">Registrate aqui</a></p>
    </form>
</div>';
View::footer();
View::end();