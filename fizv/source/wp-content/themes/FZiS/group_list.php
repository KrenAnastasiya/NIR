<?php /* Template Name: Список групп */ ?>
<? get_header(); ?>
<?
  global $wpdb;
  if(empty($_GET['id_group'])){
    if(getrole() == 4 || getrole() == 3 || getrole() == 1){
      $groups = $wpdb->get_results("SELECT * FROM groups ORDER BY id_disp");
      $groups_status_id = 0;
      $groups_status = true;
      ?>
        <div class="list_group">
      <?
      foreach ($groups as $key) {
        if($groups_status_id != $key->id_disp && $groups_status){
          ?>
            <div class="list_group_element-title">
              <?
                echo getDispById($key->id_disp)->full_name;
              ?>
            </div>
          <?
          $groups_status = false;
        }
        ?>
          <div class="list_group_element"><a href="?id_group=<? echo $key->id_group_disp; ?>"><? echo $key->name?></a></div>
        <?
        $groups_status_id = $key->id_disp;
      }
      ?>
        </div>
      <?
    }
  }else{
    if(GETA('action','delete')){
      $wpdb->update( 'students',
        array( 'id_group' => 0),
        array( 'id' => $_GET['id_stud'] )
      );
    }
    $stud_by_group = $wpdb->get_results("SELECT * FROM students WHERE id_group=".$_GET['id_group']);
    ?>
      <table>
        <tr>
          <td>ФИО</td>
          <td>Группа</td>
          
        </tr>
    <?
    foreach ($stud_by_group as $key) {
      ?>
        <tr>
          <td><? echo $key->lastname.' '.$key->firstname.' '.$key->patronymic?></td>
          <td><? echo $key->group?></td>
          <?
            if(getrole() == 4 || (getrole() == 1 && $key->id_discipline == get_info_auth_people()->id_discipline)){
              ?>
                <td><a href="?id_group=<? echo $_GET['id_group']?>&action=delete&id_stud=<? echo $key->id?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
              <?    
            }
          ?>
          
        </tr>
      <?
    }
    ?>
      </table>
    <?
  }
  
?>
<? get_footer(); ?>