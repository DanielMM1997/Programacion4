<?php
/**
 * Este script cierra la sesión actual
 */
include_once 'business.class.php';
User::logout();
header('location: index.php');