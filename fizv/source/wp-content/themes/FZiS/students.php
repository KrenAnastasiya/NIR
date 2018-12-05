<?php /* Template Name: Преподаватели */?>
<?
  if(!is_usr_admin()){
    header("Location: ".home_url());
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
	<div class="title">Список студентов на кафедре ФЗиС</div>
	<?
		
		
    if(is_usr_admin()){
      global $wpdb;
      if(GETA('action','remove')){
        
        $students_access = $wpdb->get_results('SELECT id_accesses FROM students WHERE id='.$_GET['id']);
        $students_access = $students_access[0]->id_accesses;
        $wpdb->delete(
            'students',
            array('id' => $_GET['id'])
        );
        $wpdb->delete(
            'Accesses',
            array('id' => $students_access)
        );
      }
    }
    if(is_usr_admin()){
      global $wpdb;
      if(GETA('action','load')){
        
        $target_dir = getcwd()."/uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
        $file_handle = fopen($target_dir.'1.csv', "r");
        while($line_of_text = fgetcsv($file_handle, 1000)){
          
          $CSV_STRING=iconv("CP1251", "UTF-8", $line_of_text[0]);
          $str = explode(";",$CSV_STRING);
          $name = explode(" ",$str[0]);
          $firstname = $name[1];
          $lastname = $name[0];
          $patronymic = $name[2];
          $sex = $str[3];
          $log = $str[1];
          $group = $str[2];
          
          $wpdb->insert( 'Accesses',
            array( 
              'login'=>$log,
              'password'=>generatePassword(),
              'position'=>2
            )
          ); 
          $lastid = $wpdb->insert_id; 
          
          $wpdb->insert( 'students',
            array( 
                'firstname' => $lastname, 
                'lastname' => $firstname,
                'patronymic' => $patronymic,
                'NumberZach'=>$log,
               'group' => $group,
                'med_acsess' => 0,
                    'sex' => $sex,
              'weight' => 0,
                    'id_discipline' => 0,
              'sbornik' => 0,
              'essay' => 0,
                'id_accesses' => $lastid
            )
          ); 
           
        }
        unlink($target_file);
      }
    }
        
        
        
        
    ?>
      <form action="" method="get">
        <input type="hidden" name="action" value="search"/>
        <select name="course" id="course">
          <option value="0">Курс</option>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
        <select name="fac" id="fac">
          <option value="0">Факультет</option>
          <?
            $fac = $wpdb->get_results('SELECT * FROM faculty');
            foreach ($fac as $key) {
            ?>
            <option value="<? echo $key->id?>"><? echo $key->name?></option>
            <? }
          ?>
        </select>
        <select name="disp" id="disp">
          <option value="0">Дисциплина</option>
          <?
            $disp = $wpdb->get_results('SELECT * FROM discipline');
            foreach ($disp as $key) {
            ?>
            <option value="<? echo $key->id_discipline?>"><? echo $key->brief_name?></option>
          <? } ?>
        </select>
        <select name="groupall" id="fac">
          <option value="0">Учебная группа</option>
          
          <?
            $fac = $wpdb->get_results('SELECT * FROM students group by `group`');
            foreach ($fac as $key) {
            ?>
            <option value="<? echo $key->group?>"><? echo $key->group?></option>
            <? }
          ?>
        </select>
        <button>Найти</button>
      </form>
    <?
    $ar_search_group = "";
    $ar_search_disp = "";
    if(GETA('action','search')){
      $f_1 = false;
      $f_2 = false;
      if(!empty($_GET['course'])){
          $f_1 = true;
          $m = date('n');
          $y = substr(date('y'),1,2);
          $f = $_GET['course'];
          $str = "";
          if($f == 1){
            if($m >= 9 && $m <= 12){
              $str = $y;
            }else{
              $str = $y-1;
            }
          }else{
            if($m >= 9 && $m <= 12){
              $str = $y-1;
            }else{
              $str = $y-2;
          }
           
        }
        
      }
      if(!empty($_GET['fac'])){
        $f_2 = true;
        
      }
      if(!empty($_GET['disp'])){
        
        $ar_search_disp = $_GET['disp'];
      }
      if($f_1 && $f_2){
        $ar_search_group = $str.$_GET['fac'].'%';
      }
      if($f_1 && !$f_2){
        $ar_search_group = $str.'%';
      }
      if(!$f_1 && $f_2){
        $ar_search_group = '%'.$_GET['fac'].'%';
      }
    }
    $cond = array();
    if(!empty($ar_search_group)){
      $group = '`group` like "'.$ar_search_group.'"';  
      array_push($cond,$group);
    }
    if(!empty($ar_search_disp)){
      $disp = 'id_discipline='.$ar_search_disp;  
      array_push($cond,$disp);
    }
    
    
    
    $s = implode(' AND ', $cond);
    if(!empty($_GET['groupall'])){
      $students = $wpdb->get_results('SELECT * FROM students where `group`='.$_GET['groupall']);
      
    }else{
      if(!empty($s)){
        $students = $wpdb->get_results('SELECT * FROM students where '.$s);  
      }else{
        $students = $wpdb->get_results('SELECT * FROM students');
      } 
    }		
	?>
	<table>
    		<tr>
    			<td>№</td>
    			<td>ФИО</td>
    			<td>Номер зачетной книжки</td>
    			<td>Учебная группа</td>
    			<td>Медицинская справка</td>
				<td>Пол</td>
				<td>Вес</td>
				<td>Дисциплина обучения</td>
				
    		</tr>
    		
        <?
          $i = 1;
          foreach ($students as $key) {
            ?>
              <tr>
                <td><? echo $i;?></td>
                <td><? echo $key->lastname.' '.$key->firstname.' '.$key->patronymic;?></td>
                <td><? echo $key->NumberZach;?></td>
                <td><? echo $key->group;?></td>
				 <td><? echo getMedaccess($key->med_acsess);?></td>
				  <td><? echo $key->sex;?></td>
				    <td><? echo $key->weight;?></td>
                <td><? echo getDispById($key->id_discipline)->full_name;?></td>
                <?
                  if(is_usr_admin()){
                    ?>
                      <td>
                        <a href="?action=remove&id=<? echo $key->id?>">X</a>
                      </td>
                      <td>
                        <a href="<? echo get_permalink(156).'?id='.$key->id?>">Редактировать</a>
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
	
    	<a href="<? echo get_permalink(153).'?id='.$key->id?>">Добавить нового студента</a>
    	<form action="?action=load" method="post" enctype="multipart/form-data">
    	  <input type="file" name="file">
    	  <button>Загрузить студентов</button>
    	</form>
  </div>
  
  
</div>
</div>

<? get_footer(); ?>