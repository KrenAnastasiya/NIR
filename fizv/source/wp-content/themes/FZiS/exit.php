<?
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
$_SESSION['key'] = "";
$_SESSION['login'] = "";
header("Location: ".home_url());