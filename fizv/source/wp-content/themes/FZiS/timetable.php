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
    	<div class="title">Расписание занятий на кафедре ФВиС</div>
    	<?
    	 global $wpdb;
    	 $array_time = array();
       array_push($array_time,'8:00');
       array_push($array_time,'9:50');
       array_push($array_time,'11:40');
       array_push($array_time,'13:45');
       array_push($array_time,'15:35');
       if(is_usr_admin()){
         if(GETA('action','clear')){
           $wpdb->get_results('DELETE  FROM timetable');
         }
         if(GETA('action','save_edit')){
           
           $wpdb->update( 'timetable',
            array( 'weekday' => $_POST['weekday'], 'time' => $_POST['time'] ),
            array( 'id' => $_POST['id'] )
          );
         }
         if(GETA('action','save_add')){
           $wpdb->insert(
              'timetable',
              array( 'id_fac' => $_POST['fac'], 'id_course' => $_POST['course'],'weekday'=>$_POST['weekday'],'time'=>$_POST['time'])
            );
            
            
         }
         if(GETA('action','add')){
           ?>
            <form action="?action=save_add" method="post" accept-charset="utf-8">
              Добавить в раписание: <br />
              <table>
                <tr>
                  <td>Факультет:</td>
                  <td>
                    <select name="fac" id="">
                      <?
                        $fac = $wpdb->get_results('SELECT * FROM faculty');
                        foreach ($fac as $key) {
                          ?>
                            <option value="<? echo $key->id?>"><? echo $key->name?></option>
                          <?
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Курс:</td> 
                  <td><select name="course" id="">
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select></td>
                </tr>
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
                  <td>Время</td>
                  <td>
                    <select name="time" id="">
                      <?
                        foreach ($array_time as $key) {
                          echo '<option value='.$key.'>'.$key.'</option>';
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
         if(GETA('action','edit')){
           
           ?>
            <form action="?action=save_edit" method="post" accept-charset="utf-8">
              Изменить время и день для факультета:
              <?  
                
                echo getGroupById($_GET['id'])['name'].' - '.getGroupById($_GET['id'])['course'];
              ?>
              (День:<? echo getDayByNumber(getcurInfoGroup($_GET['id'])->weekday);?>,Время:<? echo getcurInfoGroup($_GET['id'])->time;?>)
              <br>
              <input type="hidden" name="id" value="<? echo $_GET['id']?>"/>
              <select name="weekday" id="">
                <option value="1">Понедельник</option>
                <option value="2">Вторник</option>
                <option value="3">Среда</option>
                <option value="4">Четверг</option>
                <option value="5">Пятница</option>
              </select>
              <select name="time" id="">
                <?
                  foreach ($array_time as $key) {
                    echo '<option value='.$key.'>'.$key.'</option>';
                  }
                ?>
              </select>
              <button>Сохранить</button>
            </form>
           <?
         }
         
       }
      ?>
    	<table  class="widt">
    		<tr>
    			<td></td>
    			<td>Понедельник</td>
    			<td>Вторник</td>
    			<td>Среда</td>
    			<td>Четверг</td>
    			<td>Пятница</td>
    		</tr>
    		
        <?
          $array_time = array();
          array_push($array_time,'8:00');
          array_push($array_time,'9:50');
          array_push($array_time,'11:40');
          array_push($array_time,'13:45');
          array_push($array_time,'15:35');
          foreach ($array_time as $key) {
            ?>
              <tr>
                <td><? echo $key;?></td>
                <td><? timetable(1,$key)?></td>
                <td><? timetable(2,$key)?></td>
                <td><? timetable(3,$key)?></td>
                <td><? timetable(4,$key)?></td>
                <td><? timetable(5,$key)?></td>
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