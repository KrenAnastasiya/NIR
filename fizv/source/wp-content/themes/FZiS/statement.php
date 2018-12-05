<?php /* Template Name: Ведомость */?>
<?
  if(is_usr_admin() || is_usr_teacher()){
    if(GETA('action','save')){
      include 'PHPWord/PHPWord.php';
      $PHPWord = new PHPWord();
      $section = $PHPWord->createSection();
      
      // Define table style arrays
      $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
      $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
      
      // Define cell style arrays
      $styleCell = array('valign'=>'center');
      $styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
      
      // Define font style for first row
      $fontStyle = array('bold'=>true, 'align'=>'center');
      
      // Add table style
      $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
      
      // Add table
      $table = $section->addTable('myOwnTableStyle');
      
      // Add row
      $table->addRow(900);
      global $wpdb;
      $students = $wpdb->get_results('SELECT * FROM students where `group`='.$_GET['group']);
      

      $table->addCell(2000, $styleCell)->addText('№', $fontStyle);
      $table->addCell(2000, $styleCell)->addText('ФИО', $fontStyle);
      $table->addCell(2000, $styleCell)->addText('Номер зачетной книжки', $fontStyle);
      $table->addCell(2000, $styleCell)->addText('Дисциплина обучения', $fontStyle);
      $table->addCell(2000, $styleCell)->addText('Оценка', $fontStyle);
      
      
      $i = 1;
      foreach ($students as $key) {
        $table->addRow();
        $table->addCell(2000)->addText($i);
        $table->addCell(2000)->addText($key->lastname.' '.$key->firstname.' '.$key->patronymic);
        $table->addCell(2000)->addText($key->NumberZach);
        
        $table->addCell(2000)->addText(getDispById($key->id_discipline)->full_name);
        $table->addCell(2000)->addText(getResFull($key->id));  
        
        $i++;     
      }
      
      $document = $PHPWord->loadTemplate('vedomost.docx');
      $document->setValue('Value1', $_GET['group']);
      $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
      $sTableText = $objWriter->getWriterPart('document')->getObjectAsText($table);
      $document->setValue('Value7', getFacultyById($_GET['group'][1])->full_name);
      $document->setValue('Value6', date("d.m.Y"));
      $m = date('Y');
      $document->setValue('Value4', ($m-1).'/'.$m);
      $document->setValue('Value2', $sTableText);    
      $document->save('v'.$_GET['group'].'.docx');
      
      
    }
  }else{
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
    <div class="title">Ведомость</div>
    <?
      global $wpdb;
      $id = $_GET['id'];
      
    ?>
    <form action="?action=search" method="post">
      <select name="group" id="fac">
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
      if(GETA('action','search')){
        $students = $wpdb->get_results('SELECT * FROM students where `group`='.$_POST['group']);
      }
    ?>
    <table>
      <tr>
        <td>№</td>
        <td>ФИО</td>
        <td>Номер зачетной книжки</td>
        <td>Учебная группа</td>
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
                <td><? echo getDispById($key->id_discipline)->full_name;?></td>
                <td><? echo getResFull($key->id);?></td>
              </tr>
            <? 
            $i++;
          }
        ?>
    </table>
    <?
      if(GETA('action','save')){
        ?>
          <a href="/v<? echo $_GET['group'].'.docx'; ?>" download>Сохранить</a>
        <?
      }else{
        ?>
          <a href="<? echo get_permalink(276)?>?action=save&group=<? echo $_POST['group']?>"> Создать Ведомость</a>
        <?   
      }
    ?>
    
    </div>
  
  
</div>
</div>

<? get_footer(); ?>