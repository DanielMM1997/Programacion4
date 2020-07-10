<?php
include_once 'business.class.php';
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
                <html lang=\"es\">
                <head>
                <meta charset=\"utf-8\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
                <script src=\"http://code.jquery.com/jquery-1.11.2.js\"></script>
                <link rel=\"stylesheet\" href=\"jquery-ui.min.css\">
                <script src=\"jquery-ui.min.css\"></script>
                <script src=\"scripts.js\"></script>
                <title>$title</title>
                </head>
                <body>";
        User::session_start();
        echo $html;
    }
    
    public static function navigation(){
        $usuario = User::getLoggedUser();;
        echo "<nav class='menu'><ul class='menu'>
                <li class='menu'><a class='menu' href='index.php'><img src='logo.png' alt='gcactivalogo' id='logo'></a></li>
                <li class='menu'><a class='menu' href='contact.php'>Contacto</a></li>
                <li class='menu'><a class='menu' href='view_activities.php'>Actividades</a></li>";
        if (isset($_SESSION['user'])){
            switch($_SESSION['user']['tipo']){
                case 1:
                    echo "<li class='menu'><a class='menu' href='login.php'>Empresas</a></li>
                    <li class='menu'><a class='menu' href='login.php'>Clientes</a></li>
                    <li class='menu'><a class='menu' href='login.php'>Usuarios</a></li>";
                    break;
                case 2:
                    echo "<li class='menu'><a class='menu' href='my_activities.php'>Mis Actividades</a></li>";
                    break;
                case 3:
                    echo "<li class='menu'><a class='menu' href='my_tickets.php'>Ver tickets</a></li>";
                    break;
            }
            echo "<li class='menu'><a class='menu' href='logout.php'>Logout</a></li>
                <li class='menu' id='user'><a class='menu' href='#'>{$usuario['nombre']}</a></li>
                </ul></nav>";
        }else {
            echo "<li class='menu'><a class='menu' href='login.php'>Entrar</a></li>
            </ul></nav>";
        }
    }
    
    public static function imgtobase64($img){
        $b64 = base64_encode($img);
        $signature = substr($b64, 0, 3);
        if ( $signature == '/9j') {
            $mime = 'data:image/jpeg;base64,';
        } else if ( $signature == 'iVB') {
            $mime = 'data:image/png;base64,';
        }
        return $mime . $b64;
    }

    public static function showActivity($datos) {
        $hours = ($datos['duracion'] / 3600);
        $mins = ($datos['duracion'] % 3600)/60;
        $duracion = sprintf("%d:%02d H", $hours, $mins);
        $id = $datos['id'];
        $precio = $datos['precio'];
        echo "<div class='grid-container'>
        <div class='header'>
            <h1>" . $datos['nombre'] . "</h1>
        </div>
        <div class='main'>";
        $img64 = View::imgtobase64($datos['imagen']);
                echo "<img src='$img64' alt=''><br>
            <p>" . $datos['descripcion'] . "</p>
        </div>
        <div class='menu'>
            <a href='book_activity.php?id=$id&precio=$precio'><div id='boton'>Reserva ahora</div></a><hr>
            <p><strong>Inicio:</strong><br>" . date('d-m-Y H:i:s', $datos['inicio']) . "</p><hr>
            <p><strong>Duración:</strong><br>" . $duracion . "</p><hr>
            <p><strong>Precio:</strong><br>" . $precio . " €</p><hr>
            <p><strong>Aforo:</strong><br>" . $datos['aforo'] . "</p><hr>
            <p><strong>Tipo:</strong><br>" . $datos['tipo'] . "</p><hr>
            <p><strong>Empresa:</strong><br><a href='company.php?idempresa=${datos['idempresa']}'>Ver empresa</a></p>
        </div>";
        echo "</div>";
    }
    
    public static function show_activities($activities, $tipo=''){
        echo "<table>";
        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Tipo</th>";
        echo "<th>Fecha</th>";
        echo "<th>Precio</th>";
        if($tipo == 2){
            echo "<th>Opciones</th>";
        }
        echo "</tr>";
        foreach($activities as $activity){
            $id = $activity['id'];
            echo "<tr id=\"fila$id\">";
            $name = $activity['nombre'];
            echo "<td><a href='activity.php?id=$id'>$name</a></td>";
            echo "<td>{$activity['tipo']}</td>";
            $date = date("d/m/Y", $activity['inicio']);
            echo "<td>{$date}</td>";
            echo "<td>{$activity['precio']} €</td>";
            
            if($tipo == 2) {
                echo "<td>
                        <a class='option' title='Ver Participantes' href='view_participants.php?id={$activity['id']}'>
                            &#x1F465;
                        </a>
                        <a class='option' title='Editar' href='activity_form.php?id={$activity['id']}'>
                            &#x1F4DD; 
                        </a>";
                        echo "<button onclick=\"javascript:deleteActivity($id,'$name')\">
                            &#x1F5D1
                        </button>";
                        echo "</td>";
            }
            echo "</tr>";
        }
        echo"</table>";
    }
    
    public static function message_page($message, $url, $refresh){
        header("Refresh:$refresh; url=$url");
        self::start("GCActiva - message");
        self::navigation();
        echo "<h2>$message</h2>";
        self::end();
    }
    
    public static function footer() {
        echo "<footer class='footer'>
            <a href='index.php'>Página principal</a>
            <a href='contact.php'>Contacta con nosotros</a>
            <a href='about.html'>Acerca de nuestra página</a>
            <a href='privacity.html'>Política de privacidad</a>
        </footer>";
    }

    public static function end(){
        echo '</body>
            </html>';
    }
}
