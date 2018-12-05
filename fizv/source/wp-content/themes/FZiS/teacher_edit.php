<?php /* Template Name: Редактирование преподавателя */?>
<?
  if(!is_usr_admin()){
    header("Location: ".get_permalink(146));
  }else{
    if(empty($_GET['id'])){
      header("Location: ".get_permalink(146));  
    }
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
  <div class="title">Редактирования преподавателя</div>
  <?
    
    $id = $_GET['id'];
    global $wpdb;
    $wpdb->flush();
    $teachers = $wpdb->get_results('SELECT * FROM teachers WHERE id='.$id);
    $teachers = $teachers[0];
    
  ?>
  <form action="?action=save&id=<? echo $id?>" method="post" id="form_update_teacher">
    <table>
      <tr>
        <td>Фамилия</td>
        <td><input type="text" name="name1" value="<? echo $teachers->firstname?>"></td>
      </tr>
      <tr>
        <td>Имя</td>
        <td><input type="text" name="name2" value="<? echo $teachers->lastname?>"></td>
      </tr>
      <tr>
        <td>Отчество</td>
        <td><input type="text" name="name3" value="<? echo $teachers->patronymic?>"></td>
      </tr>
      <tr>
        <td>Должность</td>
        <td><input type="text" name="position" value="<? echo $teachers->position?>"></td>
      </tr>
	  <tr>
        <td>Звание</td>
        <td><input type="text" name="rank" value="<? echo $teachers->rank?>"></td>
      </tr>
	  <tr>
        <td>e-mail</td>
        <td><input type="text" name="email" value="<? echo $teachers->email?>"></td>
      </tr>
	  <tr>
        <td>Телефон</td>
        <td><input type="text" name="phone" value="<? echo $teachers->phone?>"></td>
      </tr>
      <tr>
        <input type="hidden" name="id" value="<? echo $_GET['id']?>">
        <input type="hidden" name="action" value="TeacherUpdate">
      </tr>
    </table>
    <button>Обновить</button>
  </form>
  </div>
  
  
</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
	  $("#form_update_teacher").submit(function(){
	    $.ajax({
	      type:"post",
	       url:"/wp-admin/admin-ajax.php",
          type:"POST",
          data:$(this).serialize(),
          success:function(data){
            window.location.reload();
          }
	    })
	    return false;
	  });
	});
</script>

<? get_footer(); ?>