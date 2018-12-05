<?php /* Template Name: Разбаловка */?>
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
  <div class="title">Разбаловка</div>
  <?
    global $wpdb;
    $id = $_GET['id'];
   
    $normatives = $wpdb->get_results('SELECT * FROM normatives WHERE id='.$id);
    $normatives = $normatives[0];
    
    $type_normatives = $wpdb->get_results('SELECT * FROM type_normatives WHERE id='.$_GET['id_type']);
    $type_normatives = $type_normatives[0];
    if(GETA('action','save')){
      $wpdb->insert( 'normatives_ball',
          array( 
            'id_type'=>$_GET['id_type'],
            'mark' => $_POST['mark'], 
            'left_result' => $_POST['min'],
          )
        );
    }
    $normatives_ball = $wpdb->get_results('SELECT * FROM normatives_ball WHERE id_type='.$_GET['id_type'].' order by mark DESC');
    if(GETA('action','add')){
      ?>
        <form action="?action=save&id=<? echo $_GET['id']?>&id_type=<? echo $_GET['id_type']?>" method="post">
          <table>
            <tr>
              <td>Оценка</td>
              <td>
                <input type="text" name="mark"/>
              </td>
            </tr>
            <tr>
              <td>Min</td>
              <td>
                <input type="text" name="min"/>
              </td>
            </tr>
          </table>
          <button>
            Добавить
          </button>
        </form>
      <?
    }
  ?>
  
  
    <table style="width: 500px">
      <tr>
        <td>Дисциплина</td>
        <td><? echo getDispById($normatives->id_disp)->full_name?></td>
      </tr>
      <tr>
        <td>Норматив</td>
        <td><? echo $normatives->name?></td>
      </tr>
      <tr>
        <td>Тип</td>
        <td><? echo $type_normatives->name; ?></td>
      </tr>
    </table>
    <table>
      <tr>
        <td>Оценка</td>
        <td>Min</td>
        <td>Max</td>
        
      </tr>
      <?
        foreach ($normatives_ball as $key) {
          ?>
            <tr>
              <td><? echo $key->mark?></td>
              <td><? echo $key->left_result?></td>
              <td><? echo $key->right_result?></td>
            </tr>
          <?
        }
      ?>
    </table>
    <a href="?action=add&id=<? echo $_GET['id']?>&id_type=<? echo $_GET['id_type']?>">Добавить</a>
  </div>
</div>
</div>

<? get_footer(); ?>