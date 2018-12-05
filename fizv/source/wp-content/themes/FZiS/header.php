<?
  logout();
?>
<?php
/**
 * The Header for our theme.
 * @package WordPress
 * @SketchThemes
 */
 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<? echo get_template_directory_uri(); ?>/libs/jquery/jquery-1.11.1.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if(!is_front_page()){ ?>
<div class="conx-inner-overlay"></div>
<?php } ?>

<div id="index"></div>

<!-- Header -->
<div id="header" class="clearfix">

	<a id="header-trigger" class="fa fa-bars" href="#"></a>

	<!-- top-head-secwrap -->
	<div id="top-head">

		<!-- #logo -->
		<div id="logo">
			<?php if( get_theme_mod('connexions_lite_logo_img', '' ) != '' ) { ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" ><img class="logo" src="<?php echo esc_url( get_theme_mod('connexions_lite_logo_img') ); ?>" alt="<?php bloginfo('name'); ?>" /></a>
			<?php } elseif ( display_header_text() ) { ?>
			<!-- #description -->
			<div id="site-title" class="logo_desp">
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name') ?>" ><?php bloginfo('name'); ?></a> 
				<div id="site-description"><?php bloginfo( 'description' ); ?></div>
			</div>
			<!-- #description -->
			<?php } ?>
		</div>
		<!-- #logo -->	

		<!-- top-nav-menu -->
		<div class="ske-menu" id="skenav">
		  <?
		     if(check_auth()){//если вошел
          $position=get_user_info()->position;
          if($position==1){
            ?>
              <ul>			
			  <li><a href="<? echo home_url()?>/lk/" class="">Личный кабинет</a></li>
				 <li><a href="<? echo home_url()?>/timetable/" class="">Расписание</a></li>
                <li><a href="<? echo home_url()?>/disciplines/" class="">Дисциплины</a></li>
				<li><a href="<? echo home_url()?>/teachers-timetable/" class="">Расписание преподавателей</a></li>
				<li><a href="<? echo home_url()?>/timetable-facultatives/" class="">Расписание факультативов</a></li>
                <li><a href="<? echo home_url()?>/journal/" class="">Журнал посещений и сдачи нормативов</a></li>
				<li><a href="<? echo home_url()?>/students/" class="">Добавление медицинских справок студентам</a></li>
				<li><a href="<? echo home_url()?>/documents/" class="">Работа с документацией</a></li>
                <li><a href="<? echo get_theme_file_uri('exit.php');?>">Выход</a></li>
              </ul>
            <?
          }
          if($position==2){
            ?>
              <ul>
			  <li><a href="<? echo home_url()?>/lk/" class="">Личный кабинет</a></li>
                 <li><a href="<? echo home_url()?>/timetable/" class="">Расписание</a></li>
				<li><a href="<? echo home_url()?>/teachers-timetable/" class="">Расписание преподавателей кафедры</a></li>
                <li><a href="<? echo home_url()?>/timetable-facultatives/" class="">Расписание факультативов</a></li>
				<li><a href="<? echo home_url()?>/disciplines/" class="">Дисциплины</a></li>
				<li><a href="<? echo home_url()?>/teachers/" class="">Список преподавателей кафедры</a></li>
                <li><a href="<? echo home_url()?>/journal/" class="">Журнал группы</a></li>
                <li><a href="<? echo get_theme_file_uri('exit.php');?>">Выход</a></li>
              </ul>
            <?
          }
          if(is_usr_admin()){
            ?>
              <ul>
			  <li><a href="<? echo home_url()?>/lk/" class="">Личный кабинет</a></li>
                 <li><a href="<? echo home_url()?>/timetable/" class="">Редактирование расписания</a></li>
				<li><a href="<? echo home_url()?>/teachers-timetable/" class="">Редактирование расписания преподавателей кафедры</a></li>
                <li><a href="<? echo home_url()?>/timetable-facultatives/" class="">Редактирование расписания факультативов</a></li>
				<li><a href="<? echo home_url()?>/teachers/" class="">Редактирование списка преподавателей</a></li>
				<li><a href="<? echo home_url()?>/students/" class="">Редактирование списка студентов</a></li>
				<li><a href="<? echo home_url()?>/students/" class="">Редактирование списка нормативов</a></li> 
				<li><a href="<? echo home_url()?>/disciplines/" class="">Редактирование списка дисциплин</a></li>
				<li><a href="<? echo home_url()?>/journal/" class="">Редактирование журналов посещений и сдачи нормативов</a></li>
				<li><a href="<? echo home_url()?>/date-control/" class="">Установить контрольные даты на семестр</a></li>
				<li><a href="<? echo home_url()?>/documents/" class="">Работа с документацией</a></li>
                
              </ul>
            <?
          }
         }/*else{
           ?>
            <ul>
              <li><a href="<? echo home_url()?>/timetable/" class="">Расписание</a></li>
              <li><a href="<? echo home_url()?>/disciplines/" class="">Дисциплины</a></li>
			   <li><a href="<? echo home_url()?>/teachers/" class="">Преподаватели кафедры ФЗиС</a></li>
              <li><a href="<? echo home_url()?>/preptimetable/" class="">Расписание преподавателей кафедры</a></li>
              
            </ul>
          <?
         }*/
		  ?>
			<?php //wp_nav_menu( array ( 'container_class' => 'ske-menu', 'container_id' => 'skenav', 'menu_id' => 'menu', 'theme_location' => 'connexions_main_nav') ); ?>
		</div>
		<!-- top-nav-menu -->

		
	</div>
	<!-- top-head-secwrap -->

</div>
<!-- Header -->

<!-- wrapper -->
<div id="wrapper" class="skepage">


<?php if(!is_front_page()) { ?><div class="header-clone"></div><?php } ?>
<!-- Slider Banner Section\\ -->
<?php 
if( is_front_page() ) { 
	 get_template_part("includes/front","bgimage-section");
}
?>
<!-- \\Slider Banner Section -->

<?php 
if(is_archive() || is_home()) {
$connexion_breadcumb = new connexions_lite_breadcrumb_class();
?>
<div class="bread-title-holder">
	<div class="container">
		<div class="row-fluid">
			<div class="container_inner clearfix">

				<!-- #logo -->
					<div id="logo" class="span6">
						<?php if(get_theme_mod('connexions_lite_logo_img', '') != '' ) { ?>
							<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" ><img class="logo" src="<?php echo esc_url(get_theme_mod('connexions_lite_logo_img')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
						<?php } else{ ?>
						<!-- #description -->
						<div id="site-title" class="logo_desp">
							<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name') ?>" ><?php bloginfo('name'); ?></a> 
							<div id="site-description"><?php bloginfo( 'description' ); ?></div>
						</div>
						<!-- #description -->
						<?php } ?>
					</div>
				<!-- #logo -->	

				<span class="span6">

					<?php 
					if(is_home()) { ?>
						<h1 class="title"><?php single_post_title(); ?><i class="fa fa-folder-open-o"></i></h1>
					<?php 
					}elseif(is_author()){ ?>
						<h1 class="title"><?php global $wp_query; $curauth = $wp_query->get_queried_object(); printf( __('Author', 'connexions-lite') . ' / ' . $curauth->display_name ); ?><i class="fa fa-folder-open-o"></i></h1>
					<?php
					}elseif(is_tag()){ ?>
						<h1 class="title"><?php printf( __( 'Tag Archives / %s', 'connexions-lite' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?><i class="fa fa-folder-open-o"></i></h1>
					<?php
					}elseif(is_category()){ ?>
						<h1 class="title"><?php printf( __( 'Category Archives / %s', 'connexions-lite' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?><i class="fa fa-folder-open-o"></i></h1>
					<?php
					}elseif(is_date()){ ?>
						<h1 class="title">						
							<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives / <span>%s</span>', 'connexions-lite' ), get_the_date() ); ?>
							<?php elseif ( is_month() ) : ?>
								<?php printf( __( 'Monthly Archives / <span>%s</span>', 'connexions-lite' ), get_the_date('F Y') ); ?>
							<?php elseif ( is_year() ) : ?>
								<?php printf( __( 'Yearly Archives / <span>%s</span>', 'connexions-lite' ), get_the_date('Y') ); ?>
							<?php else : ?>
							<?php _e( 'Blog Archives', 'connexions-lite' ); ?>
						<?php endif; ?><i class="fa fa-folder-open-o"></i></h1>
					<?php
					}elseif(is_tax()){ ?>
						<h1 class="title"><?php printf(single_cat_title( '', false ) . '' ); ?><i class="fa fa-folder-open-o"></i></h1>
					<?php
					}elseif(is_page()){     
					?>
						<h1 class="title"><?php the_title(); ?><i class="fa fa-folder-open-o"></i></h1>
					<?php } ?>
					<?php if ((class_exists('connexions_lite_breadcrumb_class'))) {$connexion_breadcumb->connexions_lite_custom_breadcrumb();} ?>
				</span>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
