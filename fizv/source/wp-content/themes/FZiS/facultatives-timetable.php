<?php /* Template Name: Расписание */?>
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
    	<div class="title">Расписание факультативов и занятий сборных университета на кафедре ФВиС</div>
    	<?
    	 global $wpdb;

       if(is_usr_admin()){
         if(GETA('action','clear')){
           $wpdb->get_results('DELETE  FROM timetable_facultets');
         }
         if(GETA('action','remove')){
           $wpdb->get_results('DELETE  FROM timetable_facultets where id='.$_GET['id']);
         }
         if(GETA('action','save_edit')){
           
           $wpdb->update( 'timetable_facultets',
            array( 'day' => $_POST['day'], 'time' => $_POST['time']),
            array( 'id' => $_POST['id'] )
          );
         }
         if(GETA('action','save_add')){
           $wpdb->insert(
            'timetable_facultets',
              array( 
                'id_teacher' => $_POST['teacher'], 
                'day' => $_POST['weekday'],
                'time'=>$_POST['time'],
                'place'=>$_POST['place'],
                'type'=>$_POST['type']
              )
           );
         }
         if(GETA('action','add')){
           ?>
            <form action="?action=save_add" method="post" accept-charset="utf-8">
              Добавить в раписание: <br />
              <table>
                <tr>
                  <td>День недели</td>
                  <td>
                    <select name="weekday" id="">
                      <option value="1">Понедельник</option>
                      <option value="2">Вторник</option>
                      <option value="3">Среда</option>
                      <option value="4">Четверг</option>
                      <option value="5">Пятница</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    Время занятий
                  </td> 
                  <td>
				            <input type="text" name="time"/>
				          </td>
                </tr>
               <tr>
                  <td>Место проведения</td>
                  <td>
                    <input type="text" name="place"/>
                  </td>
                </tr> 
                <tr>
                  <td>Вид занятия</td>
                  <td>
                    <input type="text" name="type"/>
                  </td>
                </tr> 
				        <tr>
                 <td>Преподаватель/Тренер</td>
                  <td>
                   <select name="teacher" id="">
                      <?
                        $firstname = $wpdb->get_results('SELECT * FROM teachers');
                        foreach ($firstname as $key) {
                          ?>
                            <option value="<? echo $key->id?>"><? echo $key->firstname.' '.$key->lastname.' '.$key->patronymic?></option>
                          <?
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                </table>
              <button>Добавить</button>
            </form>
           <?
         }        
       }
      ?>
    	<table  class="widt">
    		<tr>
    			
    			<td>День недели</td>
    			<td>Время занятий</td>
    			<td>Зал</td>
    			<td>Вид занятий</td>
    			<td>Преподаватель/Тренер</td>
    		</tr>
    		
        <?
          
          $list = $wpdb->get_results('SELECT * FROM `timetable_facultets`');
          
          foreach ($list as $key) {
            $teacher = getTeacherById($key->id_teacher);
            ?>
              <tr>
                <td><? echo getDayByNumber($key->day); ?></td>
                <td><? echo $key->time; ?></td>
                <td><? echo $key->place; ?></td>
                
                <td><? echo $key->type; ?></td>
                <td><? echo $teacher->firstname.' '.$teacher->lastname.' '.$teacher->patronymic?></td>
                <?
                  if(is_usr_admin()){
                    ?>
                      <td><a href="?action=remove&id=<?echo $key->id; ?>">Удалить</a></td>
                    <?
                  }
                ?>
              </tr>
            <?
          }
         
        ?>
    	</table>
    	<?
    	 if(is_usr_admin()){
    	   ?>
    	     <a href="?action=add">Заполнить раписание</a><br />   
    	     <a href="?action=clear">Очистить расписание</a>
    	   <?
    	 }
    	?>
    	
      
    </div>
  </div>
</div>
</div>

<? get_footer(); ?>