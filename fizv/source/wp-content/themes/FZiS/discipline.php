<?php /* Template Name: Дисциплина */?>
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
<?
		
		global $wpdb;
		$discipline = $wpdb->get_results('SELECT * FROM discipline order by id_discipline');//не сортирует?
		
	?>
	<div class="title">
	<?
		//print_r($discipline);
		$str = $post->ID;
		$disp = ($wpdb->get_results('SELECT * FROM discipline WHERE id_page='.$str));
		echo $disp[0]->full_name;
	?>
	</div>
	<div class="descr">
	
	<?
		echo wpautop($post->post_content);
	?>
	</div>
	<div class="dispTeachers">
	</div>
	<div class="dispNorms">
	</div>
</div>
  </div>
</div>
  <? get_footer(); ?>