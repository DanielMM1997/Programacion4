<?php
/** 
 * Este script muestra las actividades disponibles, además tiene
 * un buscador que permite filtrar las actividades por nombre
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

View::start("GCActiva - Actividades");

View::navigation();
// Activity search form
echo "<form class='search' method='get' action='javascript:getActivities()'>";
echo "<fieldset>
  <legend><h2>Buscador:</h2></legend>";
echo "<div class='search'><input name='q' type='search' placeholder='Nombre de actividad'></div>";
echo "<div class='search'><select name='t' style='height:34px'>";
echo "<option selected value></option>";
$res = DB::execute_sql('SELECT DISTINCT tipo FROM actividades;');
$res->setFetchMode(PDO::FETCH_COLUMN,0);
$types = $res->fetchAll();
foreach($types as $type)
    echo "<option>$type</option>";
echo "</select></div>";
echo "<div class='search'><input name='sd' type='date' style='height:34px'></div>";
echo "<div class='search'><input name='ed' type='date' style='height:34px'></div>";
echo "<input type='submit' value='Buscar'>";
echo "</fieldset>";
echo "</form>";
?>
<script>
    $('input[name=q]').on('keypress',checkInputClosure());
</script>

<?php
// Builds the SQL query for the searcher
$params[0] = "%". ($_GET['q'] ?? "") ."%";
$statement = 'SELECT id,nombre,tipo,inicio,precio 
              FROM actividades 
              WHERE nombre LIKE ?';

if(isset($_GET['t'])){
    $statement .= ' AND tipo = ?';
    $params[] = $_GET['t'];
}
if(isset($_GET['d']) && !empty($_GET['d'])){
    $statement .= ' AND inicio BETWEEN ? AND ?';
    $day = strtotime($_GET['d']);
    $params[] = $day;
    $params[] = strtotime("+1 day",$day);
}

$statement .= 'ORDER BY inicio;';

$res = DB::execute_sql($statement, $params);
$res->setFetchMode(PDO::FETCH_NAMED);
$activities = $res->fetchAll(); 
echo '<h2>Actividades:</h2>';
View::show_activities($activities);

View::footer();
View::end();