<?php /* Template Name: Страница норматива */?>
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
  
    <?
      global $wpdb;
      $id = $_GET['id'];
      if(is_usr_admin() || is_usr_teacher()){
        if(GETA('action','remove')){
          $wpdb->delete(
              'type_normatives',
              array('id' => $_GET['id_normative'])
          );
        }
      }
      $normatives = $wpdb->get_results('SELECT * FROM normatives WHERE id='.$id);
      $normatives = $normatives[0];
      $normatives_type = $wpdb->get_results('SELECT * FROM type_normatives WHERE id_normatives='.$id);
      
      
    ?>
    <div class="title">Норматив -  <? echo $normatives->name;?></div>
    <table>
      <tr>
        <td>Тип</td>
      </tr>
      <?
        foreach ($normatives_type as $key) {
          ?>
            <tr>
              <td><? echo $key->name?></td>
              <td><a href="?action=remove&id_normative=<? echo $key->id?>&id=<? echo $id?>">X</a></td>
              <td><a href="<? echo get_permalink(173).'?id='.$id.'&id_type='.$key->id?>">Информация</a></td>
            </tr>
          <?
        }
      ?>
    </table>
    <a href="<? echo get_permalink(166).'?id='.$id?>">Добавить тип</a>
  </div>
</div>
</div>

<? get_footer(); ?>