<?php
/**
 * Este script muestra la pantalla de inicio,
 * con información sobre la empresa y 
 * una lista de actividades (las más próximas en el tiempo)
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('GCActiva');

echo "<div class='cabecera'>
            <img class='portada' src='imgs/portada.jpg' alt='Imagen de Portada'>
     </div>";
     
View::navigation();

echo '<div class="index">
        <div id="imgprincipal">
            <img src="imgs/grancanaria.jpg" alt="Imagen de Gran Canaria" id="imgp">
        </div>
        <div class="somos">
            <h3 id=somos>¿Quiénes Somos?</h3>
            <p>Cuando comenzamos nuestra andadura, nos propusimos hacer las cosas 
            de otro modo. Nuestra idea era mostrar todas las opciones de actividades 
            en Gran Canaria en un mismo lugar y crear una alternativa sencilla 
            a las experiencias confusas que ofrecían algunos sitios web, que 
            convertían los viajes en un auténtico calvario. Nos dedicamos a hacer 
            que conocer Gran Canaria y además divertirte sea lo más sencillo 
            posible y ayudamos a todas esas personas a encontrar las mejores 
            opciones de actividades en esta maravillosa isla para pasar un gran 
            día con grandes experiencias.</p>
        </div>
    </div>';

$res = DB::execute_sql('SELECT id, nombre, tipo, inicio, precio 
                        FROM actividades 
                        WHERE inicio > ? 
                        ORDER BY inicio 
                        LIMIT 5;', array(time()));
$res->setFetchMode(PDO::FETCH_NAMED);

$activities = $res->fetchAll(); 
echo "<h2> Actividades próximas: </h2>";
View::show_activities($activities);
View::footer();
View::end();
