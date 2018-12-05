<?php /* Template Name: Дисциплины */?>
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
	<div class="title">Список дисциплин на кафедре ФВиС</div>
	<?
		
		global $wpdb;
		
		
		
    if(is_usr_admin()){
      global $wpdb;
      if(GETA('action','remove')){
        $wpdb->delete(
            'discipline',
            array('id_page' => $_GET['id'])
        );
        wp_delete_post($_GET['id']);
      }
    }
		$disciplines = $wpdb->get_results('SELECT * FROM discipline order by id_discipline');
		
	?>

        <?
          foreach ($disciplines as $key) {
            ?>
             <a href="<?echo get_permalink($key->id_page);?>">
                <div class="button">
					<? echo $key->full_name;?>
                </div>
			</a>
			<?
			 if(is_usr_admin()){
			   ?>
			     <a href="?action=remove&id=<? echo $key->id_page?>"><div class="plus">Х</div></a><a href="<? echo get_permalink(264)?>?id=<? echo $key->id_discipline?>"><div class="plus"><i class="fa fa-pencil" aria-hidden="true"></i></div></a>   
			   <?
			 }

      }
      if(is_usr_admin()){
        ?>
          <div class="add_disp">
            <a href="<? echo get_permalink(191)?>">Добавить новую дисципину</a>
        </div>
        <?
      }
    ?>
        
		
		
 <style>
 .plus{
	     font-size: 52px;
    margin-top: 8px;
    margin-left: 7px;
    float: left;
    border: 1px solid;
    height: 39px;
    padding: 10px;
 }
 </style>
 
	



<? get_footer(); ?>