<?php /* Template Name: Редактирование норматива */?>
<?
  if(!is_usr_admin()){
    header("Location: ".get_permalink(159));
  }else{
    if(empty($_GET['id'])){
      header("Location: ".get_permalink(159));  
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
  <div class="title">Редактирование норматива</div>
  <?
    
    $id = $_GET['id'];
    global $wpdb;
    $wpdb->flush();
    $normatives = $wpdb->get_results('SELECT * FROM normatives WHERE id='.$id);
    $normatives = $normatives[0];
    
  ?>
  <form action="" method="post" id="form_update_normative">
    <table>
      <tr>
        <td>Название</td>
        <td><input type="text" name="name1" value="<? echo $normatives->name?>"></td>
      </tr>

	  <tr>
        <td>Дисциплина</td>
        <td>
          <select name="disp" id="disp" data-val-id="<? echo $normatives->id_disp?>">
            
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
        <input type="hidden" name="id" value="<? echo $_GET['id']?>">
        <input type="hidden" name="action" value="NormativeUpdate">
      </tr>
    </table>
    <button>Обновить</button>
  </form>
  </div>
  
  
</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
	  $("select").each(function(){
	    $(this).children("option[value="+$(this).data("val-id")+"]").attr('selected', 'selected');
	    
	  })
	  $("#form_update_normative").submit(function(){
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