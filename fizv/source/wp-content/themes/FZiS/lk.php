<?php /* Template Name: Личный кабинет */?>
<?
  if(is_usr_student() || is_usr_teacher()){
    
  }else{
    header("Location: ".home_url());
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
  <div class="title">Мои данные</div>
  <?
    
    
    global $wpdb;
    if(is_usr_student()){
  ?>
  <form action="?action=save" method="post" id="form_update_student">
    <table>
      <tr>
        <td>Фамилия</td>
        <td>
            <?
              if(get_info_auth_people()->save1 == 0){
                ?>
                  <input type="text" name="name1" value="<? echo get_info_auth_people()->firstname?>">
                <?
              }else{
                echo get_info_auth_people()->firstname;
              }
            ?>
          
        </td>
      </tr>
      <tr>
        <td>Имя</td>
        <td>
          
           <?
              if(get_info_auth_people()->save1 == 0){
                ?>
                  <input type="text" name="name2" value="<? echo get_info_auth_people()->lastname?>">
                <?
              }else{
                echo get_info_auth_people()->lastname;
              }
            ?>
        </td>
      </tr>
      <tr>
        <td>Отчество</td>
        <td>
          <?
              if(get_info_auth_people()->save1 == 0){
                ?>
                  <input type="text" name="name3" value="<? echo get_info_auth_people()->patronymic?>">
                <?
              }else{
                echo get_info_auth_people()->patronymic;
              }
            ?>
        </td>
      </tr>
       <tr>
        <td>Группа</td>
        <td><? echo get_info_auth_people()->group?></td>
      </tr>
    <tr>
        <td>Медицинская справка</td>
         <td><? getMedaccess(get_info_auth_people()->med_acsess);?></td>
      </tr>
    <tr>
        <td>Пол</td>
        <td><? echo get_info_auth_people()->sex?></td>
      </tr>
     <tr>
        <td>Вес</td>
        <td><? echo get_info_auth_people()->weight?></td>
      </tr>
    <tr>
        <td>Дисциплина</td>
        <td>
          <?
            if(get_info_auth_people()->save2 == 0){
              ?>
                <select name="disp" id="disp" data-val-id="<? echo $students->id_discipline?>">
                  <option value="0">Не выбрано</option>
                  <?
                    $disp = $wpdb->get_results('SELECT * FROM discipline');
                    foreach ($disp as $key) {
                    ?>
                    <option value="<? echo $key->id_discipline?>"><? echo $key->brief_name?></option>
                  <? } ?>
                </select>
              <?
            }else{
              echo getDispById(get_info_auth_people()->id_discipline)->brief_name;
            }
          ?>
          
        </td>
      </tr>
      <input type="hidden" name="action" value="StudentUpdateS">
    <tr>
   
    </table>
    <?
      if(get_info_auth_people()->save2 == 0 || get_info_auth_people()->save1 == 0){
        echo '<button>Обновить</button>';    
      }
    ?>
    
  </form>
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
     
      $("#form_update_student").submit(function(){
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
  <?
  }
  if(is_usr_teacher()){
    ?>
     <form action="?action=save&id=<? echo $id?>" method="post" id="form_update_teacher">
      <table>
        <tr>
          <td>Фамилия</td>
          <td><input type="text" name="name1" value="<? echo get_info_auth_people()->firstname?>"></td>
        </tr>
        <tr>
          <td>Имя</td>
          <td><input type="text" name="name2" value="<? echo get_info_auth_people()->lastname?>"></td>
        </tr>
        <tr>
          <td>Отчество</td>
          <td><input type="text" name="name3" value="<? echo get_info_auth_people()->patronymic?>"></td>
        </tr>
        <tr>
          <td>Должность</td>
          <td><input type="text" name="position" value="<? echo get_info_auth_people()->position?>"></td>
        </tr>
      <tr>
          <td>Звание</td>
          <td><input type="text" name="rank" value="<? echo get_info_auth_people()->rank?>"></td>
        </tr>
      <tr>
          <td>e-mail</td>
          <td><input type="text" name="email" value="<? echo get_info_auth_people()->email?>"></td>
        </tr>
      <tr>
          <td>Телефон</td>
          <td><input type="text" name="phone" value="<? echo get_info_auth_people()->phone?>"></td>
        </tr>
        <tr>
          
          <input type="hidden" name="action" value="TeacherUpdateS">
        </tr>
      </table>
      <button>Обновить</button>
    </form>
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
    <?
  }
  ?>
  </div>
  
  
</div>
</div>


<? get_footer(); ?>