<?php
/**
 * Este script muestra las actividades propias cuando tienes 
 * la sesión de una empresa, también tiene botones a modificar
 * borrar y ver los participantes de las actividades, mas un botón
 * que permite añadir una actividad
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

$empresa = User::getLoggedUser();
$tipo = $empresa['tipo'];
if($tipo == 2){
    View::start("Mis actividades");
    View::navigation();

    $res = DB::execute_sql('SELECT * FROM actividades WHERE idempresa = ?', array($empresa['id']));

    $res->setFetchMode(PDO::FETCH_NAMED);

    $activities = $res->fetchAll(); 
    echo "<div class='añadir'>
        <a href='activity_form.php'>Añadir Actividad</a>
     </div><br>";
    echo '<h2>Mis actividades:</h2>';
    View::show_activities($activities, $tipo);
    
    View::footer();
    View::end();
}else {
    View::message_page("Funcionalidad solo para empresas","index.php",5);
}
