<?php /* Template Name: Регистрация */ ?>
<?

/*
 * status
 * 0 - нет пользователя
 * 1 - не правильный пароль 
 * 2 - успешный вход
 * 
 *Пользовательские id
 *1- преподаватель
 *2-студент
 *4-администратор
 * */
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
global $wpdb;
$login = $_POST['login'];// получаем значение логина
$password = $_POST['password'];
$response = array();
$query = $wpdb->get_results('SELECT * FROM Accesses WHERE login="'.$login.'"');  
if(sizeof($query) != 0){
  
  if($password == $query[0]->password){
    $response['status'] = 2;  
    $_SESSION[global_param()['key_enter']] = md5($password + wp_salt());
    $_SESSION['login'] = $query[0]->login;
  }else{
    $response['status'] = 1;
	
  }
}else{
  $response['status'] = 0;
}
header("Location: ".home_url());


