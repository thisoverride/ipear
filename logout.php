<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
    session_start();
    session_unset();
	header('Location: ./index.php');
?>