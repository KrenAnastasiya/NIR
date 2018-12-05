<?php /* Template Name: Медобследование */?>
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
    <div class="title"><? echo $post->post_title;?></div>
    <?
      global $wpdb;
      if(is_usr_admin()){
        if(GETA('action','remove')){
           if(GETA('action','remove')){
             $wpdb->get_results('DELETE  FROM timetableMed where id='.$_GET['id']);
           }
        }
        if(GETA('action','saveadd')){
          $date_field = date('Y-m-d',strtotime($_POST['date']));
          $wpdb->insert(
            'timetableMed',
            array( 'id_group' => $_POST['group'], 'date'=>$date_field)
          ); 
        }
        if(GETA('action','add')){
          ?>
            <form action="?action=saveadd" method="post">
              <table>
                <tr>
                  <td>Учебная группа</td>
                  <td>
                    <select name="group">
                      <?
                        $group = $wpdb->get_results('SELECT * FROM students group by `group`');
                        foreach ($group as $key) {
                          ?>
                            <option value="<? echo $key->group?>"><? echo $key->group?></option>
                          <?
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>День</td>
                  <td>
                    <input type="text" name="date" id="datepicker"/>
                  </td>
                </tr>
              </table>
              <button>Добавить</button>
            </form>
          <?
        }
      }
      ?>
        <table>
          <tr>
            <th>Учебная Группа</th>
            <th>День</th>
          </tr>
          <?
            $med = $wpdb->get_results('SELECT * FROM timetableMed order by date');
            foreach ($med as $key) {
              ?>
                <tr>
                  <td><? echo $key->id_group; ?></td>
                  <td>
                    <? 
                    $date_field = date('d-m-Y',strtotime($key->date));
                    echo $date_field; 
                    ?>
                  </td>
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
          <script type="text/javascript" charset="utf-8">
              $( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
          </script>
          <a href="?action=add">Добавить день прохождения</a>
        <?
      }
    ?>
  
    </div>
</div>
</div>

<? get_footer(); ?>