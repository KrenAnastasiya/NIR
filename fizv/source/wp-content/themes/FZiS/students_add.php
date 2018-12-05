<?php /* Template Name: Добавление студента */?>
<?
  if(!is_usr_admin()){
    header("Location: ".get_permalink(31));
  }
?>
<? get_header(); ?>
<?php
  if(is_page() && !is_front_page()){
    $connexion_breadcumb = new connexions_lite_breadcrumb_class();
  ?>
    <div class="bread-title-holder">
      <div class="container">
        <div class="row-fluid">
          <div class="container_inner clearfix">

            <!-- #logo -->
            <div id="logo" class="span6">
              <?php if( get_theme_mod('connexions_lite_logo_img', '' ) != '' ) { ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" ><img class="logo" src="<?php echo esc_url(get_theme_mod('connexions_lite_logo_img')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
              <?php } elseif ( display_header_text() ) { ?>
              <!-- #description -->
              <div id="site-title" class="logo_desp">
                <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name') ?>" ><?php bloginfo('name'); ?></a> 
                <div id="site-description"><?php bloginfo('description'); ?></div>
              </div>
              <!-- #description -->
              <?php } ?>
            </div>
            <!-- #logo -->

            <span class="span6">
                <h1 class="title"><?php single_post_title(); ?><i class="fa fa-folder-open-o"></i></h1>
              <?php
              if ((class_exists('connexions_lite_breadcrumb_class'))) {$connexion_breadcumb -> connexions_lite_custom_breadcrumb();
              }
 ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

<div class="skt-default-page">

<div class="skt-page-overlay"></div>

<!-- Container-->
<div class="container post-wrap rpage_wrap">
  <div class="row-fluid">
    <div class="content">
  <div class="title">Добавление студента</div>
  <?
    global $wpdb;
    $id = $_GET['id'];
    if(GETA('action','save')){
      ?>
        <div class="" style="display: inline-block;border: 1px solid;border-radius: 28px;padding: 5px 30px;margin-bottom: 10px;box-shadow: 0 0 10px blue;">
          Студент успешно добавлен!
        </div>
      <?
      
      
      $wpdb->insert( 'Accesses',
        array( 
          'login'=>$_POST['log'],
          'password'=>$_POST['pwd'],
          'position'=>2
        )
      );
      $lastid = $wpdb->insert_id;
    
       $wpdb->insert( 'students',
          array( 
              'firstname' => $_POST['name1'], 
              'lastname' => $_POST['name2'],
              'patronymic' => $_POST['name3'],
  			 'group' => $_POST['group'],
  			  'med_acsess' => $_POST['med_acsess'],
              'sex' => $_POST['sex'],
  			'weight' => $_POST['weight'],
              'id_discipline' => $_POST['disp'],
  			'sbornik' => $_POST['sbornik'],
              'id_accesses' => $lastid
          )
        );
      
      
    }
    
    
  ?>
  <form action="?action=save" method="post">
    <table>
      <tr>
        <td>Логин</td>
        <td><input type="text" name="log"></td>
      </tr>
      <tr>
        <td>Пароль</td>
        <td><input type="text" name="pwd" value="<? echo generatePassword();?>"></td>
      </tr>
      <tr>
        <td>Фамилия</td>
        <td><input type="text" name="name1" ></td>
      </tr>
      <tr>
        <td>Имя</td>
        <td><input type="text" name="name2"></td>
      </tr>
      <tr>
        <td>Отчество</td>
        <td><input type="text" name="name3"></td>
      </tr>
      <tr>
        <td>Группа</td>
        <td><input type="text" name="group"></td>
      </tr>
	   <tr>
        <td>Медицинская справка</td>
         <td><select name="med_acsess" id="med_acsess">
            
            <?
              $med_acsess = $wpdb->get_results('SELECT * FROM med_acsess');
              foreach ($med_acsess as $key) {
              ?>
              <option value="<? echo $key->id?>"><? echo $key->type?></option>
            <? } ?>
          </select></td>
      </tr>
	  <tr>
        <td>Пол</td>
        <td><select name="sex" id="sex">
            
            <option value="м">М</option>
            <option value="ж">Ж</option>
          </select></td>
      </tr>
	   <tr>
        <td>Вес</td>
        <td><input type="text" name="weight"></td>
      </tr>
      <tr>
        <td>Дисциплина</td>
        <td>
          <select name="disp" id="disp">
            
            <?
              $disp = $wpdb->get_results('SELECT * FROM discipline');
              foreach ($disp as $key) {
              ?>
              <option value="<? echo $key->id_discipline?>"><? echo $key->brief_name?></option>
            <? } ?>
          </select>
        </td>
      </tr>
	  <tr>
		<td>Участник сборной ВУЗа</td>
		<td><input type="checkbox" name="sbornik"></td>
	  </tr>
    </table>
    <button>Добавить</button>
  </form>
  </div>
  
  
</div>
</div>

<? get_footer(); ?>