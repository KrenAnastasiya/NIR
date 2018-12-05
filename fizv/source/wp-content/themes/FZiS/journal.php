<?php /* Template Name: Журнал */ ?>
<?
  if(!check_auth()){
    header("Location: ".home_url());
  }else{
    if(is_usr_student() && !GETA('action','view')){
      $m = date('n');
      $y = substr(date('y'),1,2);
      $f = get_info_auth_people()->group[0];
      $str = "";
      if($m >= 9 && $m <= 12){
        $str = $y - $f + 1;
      }else{
        $str = $y - $f;
      }
      header("Location: ".get_permalink(67).'?action=view&disp='.get_info_auth_people()->id_discipline.'&fac='.get_info_auth_people()->group[1].'&course='.$str);
    }
  }
?>
<? get_header(); ?>
<script type="text/javascript">
$(document).ready(function() {
	//Событие по клику
	$("ul.type_jornal li").click(function() {
		$("ul.type_jornal li").removeClass("active1"); //Удаление любого "active" класса
		$(this).addClass("active1"); //Добавление "active" класса на категорию
		var value = $(this).data("value");
		$(".open_type").css("display","none");
		if(value == "poseshenia"){
			$("#poseshenia").css("display","block");
		}
		if(value == "normatives"){
			$("#normatives").css("display","block");
		}
	});
});

</script>

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
      <div class="title"><span>Журнал посещаемости и выполнения нормативов студентами</span></div>
      <?
        if(GETA('action','view')){
          ?>
            <table>
              <tr>
                <td>Факультет:</td>
                <td><? echo getFacultyById($_GET['fac'])->name; ?></td>
              </tr>  
              <tr>
                <td>Курс</td>
                <td><? echo $_GET['course']; ?></td>
              </tr>
              <tr>
                <td>Дисциплина</td>
                <td><? echo getDispById($_GET['disp'])->full_name; ?></td>
                
              </tr>
            </table>
          <?
        }
        if(is_usr_admin() || is_usr_teacher()){
      ?>
        <form action="" method="get" accept-charset="utf-8">
          <input type="hidden" name="action" value="view" />
          <?
            if(is_usr_teacher()){
              ?>
                <input type="hidden" name="disp" value="<? echo get_info_auth_people()->id_discipline; ?>" />
              <?    
            }
          ?>
          <select name="fac" id="fac">
            <?
              $fac = $wpdb->get_results('SELECT * FROM faculty');
              foreach ($fac as $key) {
              ?>
              <option value="<? echo $key->id?>"><? echo $key->name?></option>
              <? }
            ?>
          </select>
          
          <select name="course" id="course">
            <option value="0">Курс</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
          <?
            if(is_usr_admin()){
              ?>
              <select name="disp" id="disp">
                <option value="0">Дисциплина</option>
                <?
                  $disp = $wpdb->get_results('SELECT * FROM discipline');
                  foreach ($disp as $key) {
                  ?>
                  <option value="<? echo $key->id_discipline?>"><? echo $key->brief_name?></option>
                <? } ?>
              </select>
              <? 
            }
          ?>
          <button>Найти</button>
        </form>
      <?
      }
      ?>
      <div class="journal">
      	<ul class="type_jornal">
      		<li class="menu_journal active1" data-value="poseshenia"><div class="centr-text">Журнал посещений</div></li>
      		<li class="menu_journal" data-value="normatives"><div class="centr-text">Журнал сдачи нормативов</div></li>
      	</ul>
      	<div class="table_journal1">
      	<div id="poseshenia" class="open_type">
      		<table class="date_in">
      			<tr>
      				<td class="table_journal">№</td>
      				<td class="table_journal">Фамилия, Имя</td>
      				<td class="table_journal">Группа</td>
      				<td class="table_journal">Мед.справка</td>
              <td class="table_journal">Вес</td>
      				<?
      				  $query_journal = $wpdb->get_results('SELECT * FROM `journal_group` WHERE fac='.$_GET['fac'].' AND course='.$_GET['course'].' AND id_disp='.$_GET['disp'].' ORDER BY date ASC');
                foreach ($query_journal as $key1) {
                  echo '<td>'.date("d-m-Y",strtotime($key1->date)).'</td>';
                }
      				  if(is_usr_admin() || is_usr_teacher()){
      				    $id_disp = 0;
      				    if(is_usr_teacher()){
                    $id_disp = get_info_auth_people()->id_discipline;
                  }else{
                    $id_disp = $_GET['disp'];
                  }
      				    
      				    ?>
      				      <td class="table_journal">
                      <a href="" 
                         id="add_date"
                         data-course="<? echo $_GET['course']?>"
                         data-fac="<? echo $_GET['fac']?>"
                         data-disp="<? echo $id_disp; ?>">
                          Добавить дату
                        </a>
                    </td>
      				    <?
      				  }
      				?>
      			</tr>
      			<?
      			 if(GETA('action','view')){
      			   
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
              $str .= $_GET['fac'];
              $query = 'SELECT * FROM students WHERE id_discipline='.$_GET['disp'].' AND `group` LIKE "'.$str.'%"';
              $disp = $wpdb->get_results($query);
              $i = 1;
              foreach ($disp as $key) {
                $group = $key->group;
                global $wpdb;
                $med = $wpdb->get_results('SELECT * FROM timetableMed where id_group='.$group);
                $mysql_date = date('Y-m-d',strtotime($med[0]->date));
                $cur_date = date('Y-m-d');
                $class = "";
                if($key->med_acsess == 0 && $cur_date > $mysql_date){
                  $class = "red";
                }
              ?>
                <tr class="add <? echo $class;?>" data-id="<? echo $key->id; ?>">
                  <td><? echo $i;?></td>
                  <td><? echo $key->firstname.' '.$key->lastname?></td>
                  <td><? echo $key->group?></td>
                  <td><? echo getMedaccess($key->med_acsess);?></td>
                  <td><? echo $key->weight;?></td>
                  <?
                    $query_journal = $wpdb->get_results('SELECT * FROM `journal` WHERE id_stud='.$key->id.' ORDER BY date ASC');
                    foreach ($query_journal as $key1) {
                      echo '<td class="edit" data-id="'.$key1->id.'">'.$key1->status.'</td>';
                    }
                  ?>
                </tr>
                <?
                $i++;
              }
            }
      			?>
      		</table>
      		<style type="text/css" media="">
				  .red{
				    background: rgba(255,0,0,.7);
				  }
			  </style>
      		<div class="addbutton" style="text-align: right">
      		  
      		</div>
      	</div>
      	<div id="normatives" class="open_type" style="display:none;">
      		<table class="norm_in">
      			<tr>
      				<td class="table_journal">№</td>
      				<td class="table_journal">Фамилия, Имя</td>
      				<td class="table_journal">Группа</td>
      				<td class="table_journal">Мед.справка</td>
      				<td class="table_journal">Вес</td>
      				<?
      				  if(GETA('action','view')){
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
                  $str .= $_GET['fac'];
                  $query_journal = $wpdb->get_results('SELECT * FROM `journal_norm` WHERE id_stud in (SELECT id FROM students WHERE id_discipline='.$_GET['disp'].' AND `group` LIKE "'.$str.'%")');
                  $query_journal_id_stud = $query_journal[0]->id_stud;
                  $query_journal = $wpdb->get_results('SELECT * FROM `journal_norm` WHERE id_stud='.$query_journal_id_stud);
                  foreach ($query_journal as $key) {

                    echo '<td>'.getNormativeById($key->id_norm)->name.'</td>';    
                  }
                  
                }
              ?>  
      				
    				  <?
    				    if(is_usr_admin() || is_usr_teacher()){
    				  ?>
    				    <td>
      				  <a href="" id="add_norm_button" data-course="<? echo $_GET['course']?>" data-fac="<? echo $_GET['fac']?>" data-disp="<? echo $_GET['disp']?>">Добавить норматив</a>
      				  <select name="" id="add_norm_select" style="display: none" >
      				    <?
      				      $query_norm = $wpdb->get_results('SELECT * FROM `normatives` WHERE id_disp='.$_GET['disp']);
                    foreach ($query_norm as $key) {
                      echo '<option value="'.$key->id.'">'.$key->name.'</option>';
                    }
      				    ?>
      				  </select>
      				  </td>
    				  <?
                }
    				  ?>
      				
      			</tr>
      			<?
             if(GETA('action','view')){
               
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
              $str .= $_GET['fac'];
              $query = 'SELECT * FROM students WHERE id_discipline='.$_GET['disp'].' AND `group` LIKE "'.$str.'%"';
              
              $disp = $wpdb->get_results($query);
              $i = 1;
              foreach ($disp as $key) {
               $group = $key->group;
                global $wpdb;
                $med = $wpdb->get_results('SELECT * FROM timetableMed where id_group='.$group);
                $mysql_date = date('Y-m-d',strtotime($med[0]->date));
                $cur_date = date('Y-m-d');
                $class = "";
                if($key->med_acsess == 0 && $cur_date > $mysql_date){
                  $class = "red";
                }
              ?>
                <tr class="add_norm <? echo $class?>" data-id="<? echo $key->id; ?>">
                  <td><? echo $i;?></td>
                  <td><? echo $key->firstname.' '.$key->lastname?></td>
                  <td><? echo $key->group?></td>
                  <td><? echo getMedaccess($key->med_acsess);?></td>
                  <td><? echo $key->weight;?></td>
                  <?
                    
                    $query_journal = $wpdb->get_results('SELECT * FROM `journal_norm` WHERE id_stud='.$key->id);
                    
                    foreach ($query_journal as $key1) {
                      
                      echo '<td>'.$key1->result.' ('.$key1->mark.')</td>';    
                    }
                  ?>
                </tr>
                <?
                $i++;
              }
            }
            ?>
      		</table>
      		<div class="addbutton_norm" style="text-align: right">
            
          </div>
      	</div>
      	</div>
      </div>
    </div>
  </div>
</div>
<?
  if(is_usr_admin() || is_usr_teacher()){
?>
<script type="text/javascript" charset="utf-8">
	$("#add_date").click(function(){
	  $(".date_in tr.add").append('<td><input type="text"></td>');
	  var i = 1;
	  var fac = $(this).data('fac');
	  var disp = $(this).data('disp');
	  var course = $(this).data('course');
	  $(this).parent().append('<input type="text" id="datepicker" name="">');
	  $(".addbutton").append('<a href="" id="final_add">Добавить</a>');
	  $(this).remove();
	  $( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
	  
	  $("#final_add").click(function(){
	    
	    var request = {};
	    var obj = new Object();
	    $(".add").each(function(){
	      request[$(this).data('id')] = $(this).find("td").last().children("input").val();
	       
	    })
	    obj.date = $("#datepicker").val();
	    obj.view = request;
	   
	    $.ajax({
	      url:"/wp-admin/admin-ajax.php",
	      type:"POST",
	      data:{
	        action:'addJournal',
	        data:JSON.stringify(obj),
	        fac:fac,
	        course:course,
	        id_disp:disp
	      },
	      success:function(data){
	       window.location.reload();
	       
	      }
	    })
	    return false;
	  });
	  return false;
	});
	$("#add_norm_button").click(function(){
	  
	  var fac = $(this).data('fac');
    var disp = $(this).data('disp');
    var course = $(this).data('course');
    $(this).remove();
	  $("#add_norm_select").toggle();
	  addSelect($("#add_norm_select").val())
	  $("#add_norm_select").change(function(){
	    addSelect($(this).val());
	  })
	  function addSelect(id){
	    $.ajax({
          url:"/wp-admin/admin-ajax.php",
          type:"POST",
          data:{
            action:'GetTypeNormByid',
            id:id,
          },
          success:function(data){
            $(".norm_in tr.add_norm").children("td:nth-last-child(1)").children("select").remove()
            $(".norm_in tr.add_norm").children("td:nth-last-child(1)").append(data)        
          }
        })
        
	  }
	  $(".norm_in tr.add_norm").append('<td><input type="text" class="value_result_norm"></td>');
	  $(".addbutton_norm").append('<a href="" id="final_add_norm">Добавить</a>');
	  $("#final_add_norm").click(function(){
	    var request = {};
	    
      var obj = new Object();
      $(".add_norm").each(function(){
        var in_request = {};
        in_request.result = $(this).find("td").last().children("input").val();
        in_request.type = $(this).find("td").last().children("select").val();
        request[$(this).data('id')] = in_request;
         
      })
      obj.normative = $("#add_norm_select").val();
      obj.view = request;
       $.ajax({
        url:"/wp-admin/admin-ajax.php",
        type:"POST",
        data:{
          action:'addNormative',
          data:JSON.stringify(obj),
          fac:fac,
          course:course,
          id_disp:disp
        },
        success:function(data){
         // console.log(data);
          
         window.location.reload();
        }
      })
	    return false;
	  });
	  return false;
	});
	$(".edit").dblclick(function(){
    var th = $(this);
    var text = $(this).text();
    var id = $(this).data("id");
    $(this).text("");
    $(this).append("<input value="+text+">");
    $(this).children("input").focus()
    $(this).children("input").focusout(function(){
      var val = $(this).val();
      th.text(val);
      $(this).remove();
      $.ajax({
        url:"/wp-admin/admin-ajax.php",
        type:"POST",
        data:{
          action:'addJournalUpdate',
          value:val,
          id:id
        },
        success:function(data){
          
        }
      })
    })
  });
</script>
<?
}
?>
<? get_footer(); ?>

