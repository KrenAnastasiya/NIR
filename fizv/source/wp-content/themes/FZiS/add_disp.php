<?php /* Template Name: Добавление дисциплины */?>
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
          Дисциплина успешно добавлена!
        </div>
      <?
      
      if(!get_page_by_title($_POST['brief_name'])){
        
       $args = array(
                      'post_parent'=>39,
                      'post_title'=>$_POST['brief_name'],
                      'post_type'=>'page',
                      'post_status'=>'publish'
                    );
         $id_post = wp_insert_post($args);
         update_post_meta( $id_post, '_wp_page_template', 'descipline.php' );
         $wpdb->insert( 'discipline',
          array( 
            'full_name'=>$_POST['full_name'],
            'brief_name'=>$_POST['brief_name'],
            
            'id_page'=>$id_post
          )
        );
      }     
    }

  
  ?>
  <form action="?action=save" method="post">
    <table>
	
      <tr>
        <td>Полное название дисциплины</td>
        <td><input type="text" name="full_name"></td>
      </tr>
      <tr>
        <td>Краткое название</td>
        <td><input type="text" name="brief_name"></td>
      </tr>
      
      
    </table>
    <button>Добавить</button>
  </form>
  </div>
  
  
</div>
</div>

<? get_footer(); ?>