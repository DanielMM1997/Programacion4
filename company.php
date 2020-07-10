<?php
 /**
  * Este script muestra la información de una empresa y sus actividades
  */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

View::start("Empresa");

View::navigation();

$res = DB::execute_sql('SELECT * FROM empresas WHERE idempresa = ?',array($_GET['idempresa']));

$res->setFetchMode(PDO::FETCH_NAMED);
$info = $res->fetch();


echo "<h1>{$info['nombre']}</h1>";
$imgb64 = View::imgtobase64($info['logo']);
echo "<img src='$imgb64'>";
$html = "<div class='right'>
<p><b>Descripción:</b> {$info['descripcion']}</p>
<p><b>Contacto:</b> {$info['contacto']}</p>";
echo "</div>";
echo $html;

//aquí para mostrar actividades
echo '<h2>actividades de la empresa:</h2>';

$res = DB::execute_sql('SELECT * FROM actividades WHERE idempresa = ?', array($_GET['idempresa']));

$res->setFetchMode(PDO::FETCH_NAMED); // Establecemos que queremos cada fila como array asociativo
$datos = $res->fetchAll(); // Leo todos los datos de una vez

View::show_activities($datos);

View::footer();
View::end();