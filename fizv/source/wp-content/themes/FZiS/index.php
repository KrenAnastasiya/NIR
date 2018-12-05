<?php get_header();?>
<div class="container">
  <?
    if(check_auth()){//если вошел
     
	  $position=get_user_info()->position;
	  
		 if($position==1){//если это преподаватель
	  ?>
	<div class="menu_teacher">
		<div class="left_side">
			<a href="home_url()/timetable/" class="knopka">Расписание</a>
			<a href="home_url()/disciplines/" class="knopka">Дисциплины</a>
		</div>
	</div>
	  <?
  }else{
	  if($position==2){//если это студент
		  ?>
	<div class="menu_teacher">
		<div class="left_side">
			<a href="home_url()/timetable/" class="knopka">Расписание</a>
			<a href="home_url()/disciplines/" class="knopka">Дисциплины</a>
		</div>
	</div>
	
		  <?
	  }else{
		  if($position==3){//если это руководство
			  ?>
	<div class="menu_teacher">
		<div class="left_side">
			<a href="home_url()/timetable/" class="knopka">Расписание</a>
			<a href="home_url()/disciplines/" class="knopka">Дисциплины</a>
		</div>
	</div>
			  <?
			  }else{
				  if($position==4){//если это админ
					  ?>
	<div class="menu_teacher">
		<div class="left_side">
			<a href="home_url()/timetable/" class="knopka">Расписание</a>
			<a href="home_url()/disciplines/" class="knopka">Дисциплины</a>
		</div>
	</div>
					  <?
				  }
			  }
	  }
	  }
	  
	  
	  
    }else{//если не вошел
      ?>  
        <form id="form-auth" action="<? echo get_theme_file_uri('auth.php');?>" method="POST">
          <input name="login" style="width:300px;height:50px;" class="auth"/>
          <input name="password" style="width:300px;height:50px;" class="auth"/>
          <button>Войти</button>
        </form>
      <?
    }
	
  ?> 
</div>  
<?php get_footer();?>