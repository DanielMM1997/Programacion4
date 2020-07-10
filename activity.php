<?php
/**
 * Este script guarda el formulario de consulta en el fichero contact
 */
include_once 'presentation.class.php';
include_once 'data_access.class.php';

View::start('GCActiva');
View::navigation();
View::showActivity(DB::getActivity($_GET['id']));
View::footer();
View::end();