<?php /* Template Name: Нормативы */?>
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
	<div class="title">Нормативы на кафедре ФВиС</div>
	<?
		
		
    if(is_usr_admin()){
      global $wpdb;
      if(GETA('action','remove')){
        
        $normatives = $wpdb->get_results('SELECT id_disp FROM normatives WHERE id='.$_GET['id']);
        $normatives = $normatives[0]->id_disp;
        $wpdb->delete(
            'normatives',
            array('id' => $_GET['id'])
        );
      }
    }
		$normatives = $wpdb->get_results('SELECT * FROM normatives order by id_disp');
		
	?>
	<table>
    		<tr>
    			<td>№</td>
    			<td>Название</td>
    			<td>Дисциплина</td>
			
    		</tr>
    		
        <?
          $i = 1;
          foreach ($normatives as $key) {
            ?>
              <tr>
                <td><? echo $i;?></td>
                <td><? echo $key->name;?></td>
                <td><? echo getDispById($key->id_disp)->full_name;?></td>
                <?
                  if(is_usr_admin()){
                    ?>
                      <td>
                        <a href="?action=remove&id=<? echo $key->id?>">X</a>
                      </td>
                      <td><a href="<? echo get_permalink(168).'?id='.$key->id?>">Информация</a></td>
                      <td>
                        <a href="<? echo get_permalink(164).'?id='.$key->id?>">Редактировать</a>
                      </td>
                    <?
                  }
                ?>
              </tr>
            <? 
            $i++;
          }
        ?>
    	</table>
	
    	<a href="<? echo get_permalink(162).'?id='.$key->id?>">Добавить новый норматив</a>
  </div>
  
  
</div>
</div>

<? get_footer(); ?>