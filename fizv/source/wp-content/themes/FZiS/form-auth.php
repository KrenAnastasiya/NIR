<div class="container">
  <?
    if(!check_auth()){//если не вошел
      ?>  
	  <div class="text_auth">Авторизуйтесь в системе</div>
        <form id="form-auth" action="<? echo get_theme_file_uri('auth.php');?>" method="POST">
          <input name="login" class="auth1" style="margin-left: 89px;"/>
          <input name="password" class="auth1"/>
          <button class="auth_button">Войти</button>
        </form>
      <?
    }
  
  ?> 
</div> 