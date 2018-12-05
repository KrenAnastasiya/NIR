<?php /* Template Name: Преподаватели */?>
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
	<div class="title">Список преподавателей на кафедре ФЗиС</div>
	<?
		
		
    if(is_usr_admin()){
      global $wpdb;
      if(GETA('action','remove')){
        
        $teachers_access = $wpdb->get_results('SELECT id_acceses FROM teachers WHERE id='.$_GET['id']);
        $teachers_access = $teachers_access[0]->id_acceses;
        $wpdb->delete(
            'teachers',
            array('id' => $_GET['id'])
        );
        $wpdb->delete(
            'Accesses',
            array('id' => $teachers_access)
        );
      }
    }
		$teachers = $wpdb->get_results('SELECT * FROM teachers');
		
	?>
	<table>
    		<tr>
    			<td>№</td>
    			<td>ФИО</td>
    			<td>Должность</td>
				<td>Звание</td>
    			<td>Вид преподаваемой дисциплины</td>
				<td>E-mail</td>
				<td>Телефон</td>
    		</tr>
    		
        <?
          $i = 1;
          foreach ($teachers as $key) {
            ?>
              <tr>
                <td><? echo $i;?></td>
                <td><? echo $key->lastname.' '.$key->firstname.' '.$key->patronymic;?></td>
                <td><? echo $key->position;?></td>
				<td><? echo $key->rank;?></td>
                <td><? echo getDispById($key->id_discipline)->full_name;?></td>
				<td><? echo $key->email;?></td>
				<td><? echo $key->phone;?></td>
                <?
                  if(is_usr_admin()){
                    ?>
                      <td>
                        <a href="?action=remove&id=<? echo $key->id?>">X</a>
                      </td>
                      <td>
                        <a href="<? echo get_permalink(151).'?id='.$key->id?>">Редактировать</a>
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
	
    	<a href="<? echo get_permalink(149).'?id='.$key->id?>">Добавить нового преподавателя</a>
  </div>
  
  
</div>
</div>

<? get_footer(); ?>