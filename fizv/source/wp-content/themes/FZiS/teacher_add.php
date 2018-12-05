<?php /* Template Name: Добавление преподавателя */?>
<?
  if(!is_usr_admin()){
    header("Location: ".get_permalink(146));
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
  <div class="title">Добавление преподавателя</div>
  <?
    global $wpdb;
    $id = $_GET['id'];
    if(GETA('action','save')){
      ?>
        <div class="" style="display: inline-block;border: 1px solid;border-radius: 28px;padding: 5px 30px;margin-bottom: 10px;box-shadow: 0 0 10px blue;">
          Преподаватель успешно добавлен!
        </div>
      <?
      $firstname = $_POST['name1'];
      
      $wpdb->insert( 'Accesses',
        array( 
          'login'=>$_POST['log'],
          'password'=>$_POST['pwd'],
          'position'=>1
        )
      );
      $lastid = $wpdb->insert_id;
  
     $wpdb->insert( 'teachers',
        array( 
            'firstname' => $_POST['name1'], 
            'lastname' => $_POST['name2'],
            'patronymic' => $_POST['name3'],
            'position' => $_POST['position'],
			'rank' => $_POST['rank'],
            'id_discipline' => $_POST['disp'],
			'email' => $_POST['email'],
			'phone' => $_POST['phone'],
            'id_acceses' => $lastid,
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
        <td>Должность</td>
        <td><input type="text" name="position"></td>
      </tr>
	  <tr>
        <td>Звание</td>
        <td><input type="text" name="rank"></td>
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
        <td>email</td>
        <td><input type="text" name="email"></td>
      </tr>
	    <tr>
        <td>phone</td>
        <td><input type="text" name="phone"></td>
      </tr>
    </table>
    <button>Добавить</button>
  </form>
  </div>
  
  
</div>
</div>

<? get_footer(); ?>