<ul>
    <?
		global $wpdb;
		$array = $wpdb->get_results('SELECT * FROM `discipline`');
		
        foreach($array as $key){
            
            echo '<li>'.$key->full_name.'</li>';        
        }
    ?>
	
</ul>
