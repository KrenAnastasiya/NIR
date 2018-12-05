<?php /* Template Name: Факультеты(добавление/удален/trие/) */ ?>
<?
	global $wpdb;
	$array = $wpdb->get_results('SELECT * FROM `faculty`');
	print_r($array);
?>
<table>
	
    <?
		global $wpdb;
		$array = $wpdb->get_results('SELECT * FROM `discipline`');
		
        foreach($array as $key){
            
            echo '<tr><td>'.$key->full_name.'</td></tr>';        
        }
    ?>
	<tr>
		<td>
			<button>Добавить новую дисциплину</button>
		</td>
	</tr>

</table>
