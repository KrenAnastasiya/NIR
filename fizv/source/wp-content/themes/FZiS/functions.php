<?php
/**
 * SketchThemes functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
*/
/********************************************************
 INCLUDE REQUIRED FILE FOR THEME (PLEASE DON'T REMOVE IT)
*********************************************************/
require_once(get_template_directory() . '/SketchBoard/functions/admin-init.php');
/********************************************************/

/********************************************************
  REGISTERS THE WIDGETS AND SIDEBARS FOR THE SITE 
*********************************************************/

function connexions_lite_widgets_init() 
{
  register_sidebar(array(
    'name' => __('Blog Sidebar','connexions-lite'),
    'id' => 'blog-sidebar',
    'before_widget' => '<li id="%1$s" class="ske-container %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3 class="ske-title">',
    'after_title' => '</h3>',
  ));
}
add_action( 'widgets_init', 'connexions_lite_widgets_init' );


/**
 * Sets up theme defaults and registers the various WordPress features that
 * Connexions Lite supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
*/
function connexions_lite_theme_setup() {
  /*
  * Makes Connexions Lite available for translation.
  *
  * Translations can be added to the /languages/ directory.
  * If you're building a theme based on Twenty Thirteen, use a find and
  * replace to change 'connexions-lite' to the name of your theme in all
  * template files.
  */
  load_theme_textdomain('connexions-lite', get_template_directory() . '/languages');
   
  // This theme styles the visual editor with editor-style.css to match the theme style.
  add_editor_style();

  add_theme_support( 'title-tag' );

  // This theme allows users to set a custom header.
  add_theme_support( 'custom-header', array( 'flex-width' => true, 'width' => 1600, 'flex-height' => true, 'height' => 200, 'default-image' => get_template_directory_uri() . '/images/header.jpg') );

  // This theme allows users to set a custom background.
  add_theme_support( 'custom-background', apply_filters( 'connexions_lite_custom_background_args', array('default-color' => 'ffffff', ) ) );

  // Adds RSS feed links to <head> for posts and comments.
  add_theme_support( 'automatic-feed-links' );

  /*
  * This theme uses a custom image size for featured images, displayed on
  * "standard" posts and pages.
  */
  add_theme_support('post-thumbnails');
  add_image_size('connexions-lite-standard-thumb', 700, 350, true);
  add_image_size('connexions-lite-front-thumb', 370, 240, true);

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'connexions_main_nav' => __( 'Main Navigation','connexions-lite'),
  ));

  /**
  * SETS UP THE CONTENT WIDTH VALUE BASED ON THE THEME'S DESIGN.
  */
  global $content_width;
  if ( ! isset( $content_width ) ){
        $content_width = 900;
  }
}
add_action( 'after_setup_theme', 'connexions_lite_theme_setup' ); 


/**
* Funtion to add CSS class to body
*/
function connexions_lite_add_class( $classes ) {

  if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && is_front_page() ) {
    $classes[] = 'front-page';
  }
  
  return $classes;
}
add_filter( 'body_class','connexions_lite_add_class' );

/**
 * Filter content with empty post title
 *
 */

function connexions_lite_untitled($title) {
  if ($title == '') {
    return __('Untitled','connexions-lite');
  } else {
    return $title;
  }
}
add_filter('the_title', 'connexions_lite_untitled');


/**
 * Add Customizer 
 */
require get_template_directory() . '/includes/customizer.php';
/**
 * Add Customizer 
 */
require_once(get_template_directory() . '/SketchBoard/functions/admin-init.php');
/**
 * Add Customizer 
 */
require_once(get_template_directory() . '/includes/sketchtheme-upsell.php');



function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}
function remove_menus(){
  
  remove_menu_page( 'index.php' ); 
  remove_menu_page( 'edit-comments.php' ); 
  remove_menu_page( 'plugins.php' );
}
add_action( 'admin_menu', 'remove_menus' );
add_action( 'init', 'custom_blockusers_init' );
function enter_admin($username, $password ) {
  global $wpdb;
  if (!empty($username) && !empty($password)) {
    $query = $wpdb->get_results('SELECT * FROM Accesses WHERE login="'.$username.'"');  
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
  }
}
add_action('wp_authenticate', 'enter_admin', 30, 2);

function logout(){
  if(is_user_logged_in() && !check_auth()){
    wp_logout();
    header('Location:'.home_url());
  }
}
function global_param(){
  $array = array();
  $array['key_enter'] = 'key';
  return $array;
}
function exit_admin() {
  $_SESSION['key'] = "";
  $_SESSION['login'] = "";
}
add_action('wp_logout', 'exit_admin');
function register_my_session()
{
  if( !session_id() )
  {
    session_start();
  }
}

add_action('init', 'register_my_session');
function GETA($action,$res){
  $status = false;
  if($_GET[$action] == $res && !empty($_GET[$action])){
    $status = true;
  }
  return $status;
}
function check_auth(){
  global $wpdb;
  
  $status = false;
  $login = $_SESSION['login'];
  $key = $_SESSION['key'];
  $query = $wpdb->get_results('SELECT * FROM Accesses WHERE login="'.$login.'"');
  if($key == md5($query[0]->password + wp_salt())){
    $status = true;
  }
  return $status;
}
function is_usr_student(){
  $status = false;
  $usr = get_user_info();
  if($usr->position == 2){
    $status = true;
  }
  return $status;
}
function is_usr_teacher(){
  $status = false;
  $usr = get_user_info();
  if($usr->position == 1){
    $status = true;
  }
  return $status;
}
function is_usr_admin(){
	$status = false;
	$usr = get_user_info();
	if(current_user_can('administrator') || $usr->position == 4){
		$status = true;
	}
	return $status;
}
function get_user_info(){
  global $wpdb;
  if(check_auth()){
    $login = $_SESSION['login'];
    $query = $wpdb->get_results('SELECT * FROM Accesses WHERE login="'.$login.'"');
    
  }
  
  return $query[0];
}
function get_info_auth_people(){
  $people = get_user_info();
  
  global $wpdb;
  if($people->position == 1){
    $query = $wpdb->get_results("SELECT * FROM teachers WHERE id_acceses=".$people->id);  
  }
  if($people->position == 2){
    $query = $wpdb->get_results("SELECT * FROM students WHERE id_accesses=".$people->id);  
  }
  if($people->position == 3){
    $query = $wpdb->get_results("SELECT * FROM superiors WHERE id_acceses=".$people->id);  
  }
  if($people->position == 4){
    $query = $wpdb->get_results("SELECT * FROM admin WHERE id_accesses=".$people->id);  
  }
  return $query[0];
}
function getFactulty(){
  $fac = array();
  array_pust($fac,array('id'=>1,'name'=>'ФРТ'));
  array_pust($fac,array('id'=>2,'name'=>'ФЭЛ'));
  array_pust($fac,array('id'=>3,'name'=>'ФКТИ'));
  array_pust($fac,array('id'=>4,'name'=>'ФЭА'));
  array_pust($fac,array('id'=>5,'name'=>'ФИБС'));
  array_pust($fac,array('id'=>6,'name'=>'ФЭМ'));
  array_pust($fac,array('id'=>7,'name'=>'ГФ'));
  return $fac;
}
function getrole(){
  $position=get_user_info()->position;
  return $position;
}
function getFacultyById($id){
  global $wpdb;
  $fac = $wpdb->get_results('SELECT * FROM faculty WHERE id='.$id);
  
  return $fac[0];
}
function getTeacherById($id){
  global $wpdb;
  $teacher = $wpdb->get_results('SELECT * FROM teachers WHERE id='.$id);
  
  return $teacher[0];
}
function getGroupById($id){
  global $wpdb;
  $group = $wpdb->get_results('SELECT * FROM timetable WHERE id='.$id);
  $fac = $wpdb->get_results('SELECT * FROM faculty WHERE id='.$group[0]->id_fac);
  
  return array('name'=>$fac[0]->name,'course'=>$group[0]->id_course);
}
function getcurInfoGroup($id){
  global $wpdb;
  $group = $wpdb->get_results("SELECT * FROM timetable WHERE id=".$id);
  return $group[0];
}
function getNormativeById($id){
  global $wpdb;
  $normative = $wpdb->get_results("SELECT * FROM normatives WHERE id=".$id);
  
  return $normative[0];
}
function getDispById($id){
  
  global $wpdb;
  $disciplne = $wpdb->get_results("SELECT * FROM discipline WHERE id_discipline=".$id);
  
  return $disciplne[0];
}
function getDayByNumber($number){
  $r = 'Понедельник';
  switch ($number) {
      case 2:
          $r = 'Вторник';
          break;
      case 3:
          $r = 'Среда';
          break;
      case 4:
          $r = 'Четверг';
          break;
      case 5:
          $r = 'Пятница';
          break;
  }
  return $r;
}
function timetable_teacher($weekday,$time){
  global $wpdb;
  $day = $wpdb->get_results("SELECT * FROM timetable_teachers WHERE day=".$weekday." and time='".$time."'");
  
  foreach ($day as $key) {
    $teacher = $wpdb->get_results("SELECT * FROM teachers WHERE id=".$key->id_teacher);
    $teacher = $teacher[0];
    //echo '<a href="'.get_permalink(122).'?fac='.$group[0]->id.'">'.$group[0]->name.'-'.$key->id_course.'</a>';
    echo $teacher->firstname.' '.$teacher->lastname.' '.$teacher->patronymic;
    if(getrole() == 4){  
    echo '<a href="?action=edit&id='.$key->id.'">(ред.)</a>';
    }
        
    if($key != end($day)) {
      echo '<br>';
    }    
  }
}
function timetable($weekday,$time){
  global $wpdb;
  $day = $wpdb->get_results("SELECT * FROM timetable WHERE weekday=".$weekday." and time='".$time."'");
  
  foreach ($day as $key) {
    $group = $wpdb->get_results("SELECT * FROM faculty WHERE id=".$key->id_fac);
    //echo '<a href="'.get_permalink(122).'?fac='.$group[0]->id.'">'.$group[0]->name.'-'.$key->id_course.'</a>';
    echo $group[0]->name.'-'.$key->id_course;
    if(getrole() == 4){  
    echo '<a href="?action=edit&id='.$key->id.'">(ред.)</a>';
    }
        
    if($key != end($day)) {
      echo ' / ';
    }    
  }
}

function addJournal_callback(){
  if(is_usr_admin() || is_usr_teacher()){
    global $wpdb;
    $data = $_POST['data'];
    $data = str_replace("\\", "", $data);
    $data = json_decode($data);
    $date_field = date('Y-m-d',strtotime($data->date));
    
    foreach ($data->view as $key => $key_val) {
      
     $wpdb->insert(
        'journal',
        array( 'id_stud' => $key, 'date'=>$date_field,'status'=>$key_val,'id_disp'=>$_POST['id_disp'])
      ); 
      print_r($wpdb->last_query);
    }
    $wpdb->insert(
      'journal_group',
      array( 'fac' => $_POST['fac'], 'date'=>$date_field,'id_disp'=>$_POST['id_disp'],'course'=>$_POST['course'])
    ); 
  }
  exit;
}
add_action('wp_ajax_addJournal', 'addJournal_callback');
add_action('wp_ajax_nopriv_addJournal', 'addJournal_callback');

function compareNormative($res,$id_type){
  global $wpdb;
  $query_journal = $wpdb->get_results('SELECT * FROM `normatives_ball` WHERE id_type='.$id_type.' order by mark ASC');
  $res = floatval($res);
  
  $i = 0;
  foreach ($query_journal as $key) {
    $l = floatval($key->left_result);
    $r = floatval($key->right_result);
    if($res >= $l && $res <= $r){
      $mark = $key->mark;
    }
  } 
  return $mark;
}
function addNormative_callback(){
  if(is_usr_admin() || is_usr_teacher()){
    global $wpdb;
    $data = $_POST['data'];
    $data = str_replace("\\", "", $data);
    $data = json_decode($data);
    $id_norm = $data->normative;
    foreach ($data->view as $key => $key_val) { 
     $res = $key_val->result;
     $id_type = $key_val->type;
     $mark = compareNormative($res,$id_type);
     
     $wpdb->insert(
        'journal_norm',
        array( 'id_type'=>$id_type,'id_norm'=>$id_norm,'id_stud' => $key, 'result'=>$key_val->result,'mark'=>$mark)
      );
      
    }
  }
  exit;
}
add_action('wp_ajax_addNormative', 'addNormative_callback');
add_action('wp_ajax_nopriv_addNormative', 'addNormative_callback');

function GetTypeNormByid_callback(){
  $id = $_POST['id'];
  global $wpdb;
  $type_norm = $wpdb->get_results('SELECT * FROM `type_normatives` WHERE id_normatives='.$id);
  $res = '<select name="type" style="margin-left:10px;height:50px">';
  foreach ($type_norm as $key) {
    $res .= '<option value="'.$key->id.'">'.$key->name.'</option>';   
  }
  $res .= '</select>';
  echo $res;
  exit;
}
add_action('wp_ajax_GetTypeNormByid', 'GetTypeNormByid_callback');
add_action('wp_ajax_nopriv_GetTypeNormByid', 'GetTypeNormByid_callback');


function addJournalUpdate_callback(){
  if(is_usr_admin() || is_usr_teacher()){
    global $wpdb;
    $id = $_POST['id'];
    $val = $_POST['value'];
    $wpdb->update( 
      'journal', 
      array( 
        'status' => $val
      ),
      array('id'=>$id)
    );  
  }
  exit;
}
add_action('wp_ajax_addJournalUpdate', 'addJournalUpdate_callback');
add_action('wp_ajax_nopriv_addJournalUpdate', 'addJournalUpdate_callback');


function TeacherUpdateS_callback(){
  if(is_usr_admin() || is_usr_teacher()){
    global $wpdb;
    $wpdb->update( 'teachers',
      array( 
            'firstname' => $_POST['name1'], 
            'lastname' => $_POST['name2'],
            'patronymic' => $_POST['name3'],
            'position' => $_POST['position'],
      'rank' => $_POST['rank'],
      'email' => $_POST['email'],
      'phone' => $_POST['phone']
      ),
      array( 'id' => get_info_auth_people()->id )
    );
  }
  exit;
}

add_action('wp_ajax_TeacherUpdateS', 'TeacherUpdateS_callback');
add_action('wp_ajax_nopriv_TeacherUpdateS', 'TeacherUpdateS_callback');
function TeacherUpdate_callback(){
  if(is_usr_admin() || is_usr_teacher()){
    global $wpdb;
    $wpdb->update( 'teachers',
      array( 
            'firstname' => $_POST['name1'], 
            'lastname' => $_POST['name2'],
            'patronymic' => $_POST['name3'],
            'position' => $_POST['position'],
			'rank' => $_POST['rank'],
			'email' => $_POST['email'],
			'phone' => $_POST['phone']
      ),
      array( 'id' => $_POST['id'] )
    );
  }
  exit;
}

add_action('wp_ajax_TeacherUpdate', 'TeacherUpdate_callback');
add_action('wp_ajax_nopriv_TeacherUpdate', 'TeacherUpdate_callback');

function StudentUpdate_callback(){
  if(is_usr_admin()){
    global $wpdb;
    $wpdb->update( 'students',
      array( 
        'firstname' => $_POST['name1'], 
        'lastname' => $_POST['name2'],
        'patronymic' => $_POST['name3'],
			  'group' => $_POST['group'],
			  'med_acsess' => $_POST['med_acsess'],
        'sex' => $_POST['sex'],
	      'weight' => $_POST['weight'],
        'id_discipline' => $_POST['disp']
      ),
      array( 'id' => $_POST['id'] )
    );
  }
  exit;
}

add_action('wp_ajax_StudentUpdate', 'StudentUpdate_callback');
add_action('wp_ajax_nopriv_StudentUpdate', 'StudentUpdate_callback');


function StudentUpdateS_callback(){
    if(is_usr_student()){
      global $wpdb;
      if($_POST['disp'] == 0){
        if(get_info_auth_people()->save1 == 0){
            $wpdb->update( 'students',
            array( 
                  'firstname' => $_POST['name1'], 
                  'lastname' => $_POST['name2'],
                  'patronymic' => $_POST['name3'],
                  'save1'=>'1',
                  
            ),
            array( 'id' => get_info_auth_people()->id )
          );    
        }
        
      }else{
        if(get_info_auth_people()->save2 == 0){
          $wpdb->update( 'students',
            array( 
                  
                  'save2'=>'1',
                  'id_discipline' => $_POST['disp']
            ),
            array( 'id' => get_info_auth_people()->id )
          );  
        } 
      }
  }
  exit;
}

add_action('wp_ajax_StudentUpdateS', 'StudentUpdateS_callback');
add_action('wp_ajax_nopriv_StudentUpdateS', 'StudentUpdateS_callback');


function NormativeUpdate_callback(){
  if(is_usr_admin() || is_usr_teacher()){
    global $wpdb;
    
    $wpdb->update( 'normatives',
      array( 
           'name' => $_POST['name1'], 
           'id_disp' => $_POST['disp']
      ),
      array( 'id' => $_POST['id'] )
    );
  }
  exit;
}

add_action('wp_ajax_NormativeUpdate', 'NormativeUpdate_callback');
add_action('wp_ajax_nopriv_NormativeUpdate', 'NormativeUpdate_callback');

function UpdateDiscipline_callback(){
   if(is_usr_admin()){
    global $wpdb;
    
     $wpdb->update( 'discipline',
        array( 
             'full_name' => $_POST['full_name'],
             'brief_name' => $_POST['brief_name'], 
             
        ),
        array( 'id_discipline' => $_POST['id'] )
    );
  }
  exit;
}
function getMedaccess($id){
  if($id == 0){
   echo 'нет';
  }else{
    global $wpdb;
    $ma = $wpdb->get_results("SELECT * FROM `med_acsess` where id=".$id);
    echo $ma[0]->type;
    
    
  }
}
add_action('wp_ajax_UpdateDiscipline', 'UpdateDiscipline_callback');
add_action('wp_ajax_nopriv_UpdateDiscipline', 'UpdateDiscipline_callback');

function getResFull($id){
  global $wpdb;
  $s1 = $wpdb->get_results("SELECT sum(status) FROM `journal` WHERE id_stud=".$id);
  $s2 = $wpdb->get_results("SELECT sum(mark) FROM `journal_norm` where id_stud=".$id);
  $s = 0;
  foreach ($s1[0] as $key) {
      $s += $key;
  }
  foreach ($s2[0] as $key) {
      $s += $key;
  }
  $l = 'незачет';
  if($s >= 70){
    $l = 'зачет';
  }
  return $l;
}
