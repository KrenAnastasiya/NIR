<?php /* Template Name: Изменение дисциплины */?>
<?
  if(!is_usr_admin()){
    header("Location: ".get_permalink(159));
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
  <div class="title">Добавление дисциплины</div>
  <?
    global $wpdb;
    $id = $_GET['id'];
    
    if(GETA('action','save')){
      ?>
        <div class="" style="display: inline-block;border: 1px solid;border-radius: 28px;padding: 5px 30px;margin-bottom: 10px;box-shadow: 0 0 10px blue;">
          Дисциплина успешно обновлена!
        </div>
      <?   
    }

    $discipline = $wpdb->get_results('SELECT * FROM discipline where id_discipline='.$id);
    $discipline = $discipline[0];
  ?>
  <form action="?action=save&id=<? echo $discipline->id_discipline?>" method="post" id="form_update_descipline">
    <table>
  
      <tr>
        <td>Полное название дисциплины</td>
        <td><input type="text" name="full_name" value="<? echo $discipline->full_name;?>"></td>
      </tr>
      <tr>
        <td>Краткое название</td>
        <td><input type="text" name="brief_name" value="<? echo $discipline->brief_name;?>"></td>
      </tr>
      
      <input type="hidden" value="<? echo $discipline->id_discipline?>" name="id">
      <input type="hidden" value="UpdateDiscipline" name="action">
    </table>
    <button>Обновить</button>
  </form>
  </div>
  
  
</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $("#form_update_descipline").submit(function(){
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