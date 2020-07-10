<?php
/**
 * Este script muestra una lista de los clientes con tickets de esa empresa
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';
$user = User::getLoggedUser();
if($user){
    if (!empty($_GET['id'])){
        $res = DB::execute_sql('SELECT nombre, aforo
                                FROM actividades
                                WHERE id = ? AND idempresa = ?;',
                                array($_GET['id'], $user['id']));
        $res->setFetchMode(PDO::FETCH_NAMED);
        $act = $res->fetch();
        if($act){
            View::start('Ver Participantes');
            View::navigation();
            echo "<h2> {$act['nombre']} </h2>";
            echo "Aforo de la actividad : {$act['aforo']}";
            $res = DB::execute_sql('SELECT nombre,SUM(unidades),email,telefono
                                    FROM usuarios as us,tickets as tk
                                    WHERE idactividad = ? AND us.id = idcliente
                                    GROUP BY us.id;',array($_GET['id']));
                                    
            $res->setFetchMode(PDO::FETCH_NAMED);
            $participants = $res->fetchall();
            echo "<table>
                    <tr>
                        <th> Nombre </th>
                        <th> Email </th>
                        <th> Telefono </th>
                        <th> Tickets</th>
                    </tr>";
            $total = 0;
            foreach($participants as $participant){
                $name = $participant['nombre'];
                $tickets = (int) $participant['SUM(unidades)'];
                $total += $tickets;
                echo "<tr>
                        <td> $name </td>
                        <td> {$participant['email']}</td>
                        <td> {$participant['telefono']}</td>
                        <td> $tickets </td>
                      </tr>";
            }
            echo "<tr>
                        <td colspan='3' > Total vendido </td>
                        <td> $total </td>
                      </tr>";
            echo "</table>";
        
            View::footer();
            View::end();
        } else {
            View::message_page("Actividad no encontrada","index.php", 5);
        }
    } else {
        View::message_page("Falta ID","index.php",5);
    }
} else {
    header('Location:login.php');
}
