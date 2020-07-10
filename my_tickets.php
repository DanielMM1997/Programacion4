<?php

/**
 * Este script muestra los tickets comprados del cliente actual
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

View::start("Mis tickets");

View::navigation();

$client = User::getLoggedUser();

echo '<h2>Tickets:</h2>';

$res = DB::execute_sql('SELECT * FROM tickets WHERE idcliente = ?', array($client['id']));
    
$res->setFetchMode(PDO::FETCH_NAMED); // Establecemos que queremos cada fila como array asociativo
$tickets = $res->fetchAll(); // Leo todos los datos de una vez


//mostramos las actividades, segun el filtro que haya
echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Precio</th>";
echo "<th>Fecha</th>";
echo "<th>Unidades</th>";
echo "<th>Precio pagado</th>";
echo "</tr>";

foreach($tickets as $tickets){
    $res = DB::execute_sql('SELECT * FROM actividades WHERE id = ?', array($tickets['idactividad']));
    
    $res->setFetchMode(PDO::FETCH_NAMED);
    $data = $res->fetchAll();
    
    foreach($data as $registry){
        echo "<tr>";
        echo "<td>{$registry['nombre']}</td>";
        echo "<td>{$registry['precio']}</td>";
        $date = date("d-m-Y H:i", $registry['inicio']);
        echo "<td>{$date}</td>";
        echo "<td>{$tickets['unidades']}</td>";
        $total_price = $tickets['unidades'] * $tickets['precio'];
        echo "<td>$total_price</td>";
        echo "</tr>";
    }
}
echo '</table>';

View::footer();
View::end();