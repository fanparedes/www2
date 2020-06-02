<?php 

defined('ABSPATH') or die("Bye bye");

function create_indicator_preview($id){
	switch($id){

		//casen    
        case 47:   $result = indefinite_contract(47); break; 
        case 61:   $result = salary_avg(61); break; 
        case 60:   $result = female_percentage(60); break; 
        case 71:   $result = topfiveCrecimiento(71); break; 
        case 72:   $result = menorCrecimiento(72); break; 
        case 46:   $result = ranking_occupied(46); break; 
    
        //Mujeres afc
        case 58:   $result = highest_female_percentage(58); break;
        case 59:   $result = lower_female_percentage(59); break;
        case 11:   $result = highest_female_percentage_by_region(11); break;
        case 12:   $result = lower_female_percentage_by_region(12); break;
        case 30:   $result = female_percentage_national(30); break;
        case 31:   $result = female_percentage_general(31); break;

        //% de rotacion afc
        case 54:   $result = new_rotation_national(54); break;    
        
        //% nuevos trabajadores afc
        case 55:   $result = new_employees_national(55); break;
        
        //inmigrantes afc
        case 56:   $result = highest_migrants_percentage(56); break;
        case 57:   $result = lower_migrants_percentage(57); break;
        case 10:   $result = highest_migrants_percentage_by_region(10); break;
        case 9:    $result = lower_migrants_percentage_by_region(9); break;
        
        //%% contratos indefinidos afc
        case 50:   $result = indefnite_contracts_percentage_national(50); break;
        case 3:    $result = indefnite_contracts_percentage_regional(3); break;
        case 4:    $result = higher_indefinite_contracts_regional(4); break;
        case 5:    $result = lower_indefinite_contracts_regional(5); break;
        case 51:   $result = higher_indefinite_contracts(51); break;
        case 52:   $result = lower_indefinite_contracts(52); break;

        //numero de ocupados
        case 48:    $result = higher_number_occupied(48); break;
        case 49:    $result = lower_number_occupied(49); break;
        case 1:     $result = higher_number_occupied_by_region(1); break;
        case 2:     $result = lower_number_occupied_by_region(2); break;
        case 32:    $result = active_population(32); break;

        //telefonica
        case 14:    $result = ranking_request_abilities_national(); break;
        case 15:    $result = ranking_request_abilities_regional(); break;   
        case 16:    $result = job_offer_national(); break;
        case 17:    $result = job_offer_regional(); break;
        case 18:    $result = occupation_ranking_ability_national(); break;
        case 20:    $result = demmanded_occupation_digital_national(); break;
        case 21:    $result = demmanded_occupation_digital_regional(); break;
        case 22:    $result = ranking_demmanded_abilities_occupation_national(); break;
        case 24:    $result = job_offers_occupation_national(); break;
        case 25:    $result = job_offers_occupation_regional(); break;
        case 26:    $result = job_demmanded_occupations_national(); break;
        case 27:    $result = job_demmanded_occupations_regional(); break;

        //ENADEL
        case 63:    $result = ranking_five_occupations(63); break;
        case 33:    $result = ranking_five_occupations_regional(33); break;
        case 64:    $result = vacants_fill_dificulty(64); break;
        case 34:    $result = vacants_fill_dificulty_regional(34); break;
        case 65:    $result = top_three_abilities(); break;
        case 35:    $result = top_three_abilities_regional(35); break;
        case 66:    $result = top_three_ways(66); break;
        case 37:    $result = top_three_ways_regional(37); break;
        


   }

   return $result;
}

add_action( 'wp_ajax_save_indicator', 'save_indicator' );

function save_indicator($id){

    global $wpdb;

    $indicator_id = $_POST['id'];
    
    $indicators =   $_SESSION['indicators'];

    $indicator =    $indicators[$indicator_id];

	$indicator_actual = $wpdb->get_results("SELECT * FROM cl_indicators WHERE id_indicator_type = {$indicator_id} and status = true");
    
	if ( count( $indicator_actual ) >= 1 ){
		$re_up = $wpdb->query( $wpdb->prepare("UPDATE cl_indicators SET status = 2 WHERE id_indicator_type={$indicator_id}") );        
	}

    $data = array(
                //'id_indicator'      => 1,
                'id_indicator_type' => $indicator_id, 
                'name_indicator'    => 'Nombre de pruebas',
                'status'            => 1,
                'data'              => json_encode($indicator),
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
    );
    
    if( $wpdb->insert('cl_indicators', $data, array('%s','%s','%s','%s','%s') ) ){
         echo json_encode(1);
    }else{
        echo json_encode($wpdb->show_errors);
    }

    wp_die();
   
}

add_action( 'wp_ajax_update_indicator', 'update_indicator' );

function update_indicator($id){

    global $wpdb;

    $indicator_id = $_POST['id'];

    

    $update = $wpdb->query( $wpdb->prepare("UPDATE cl_indicators SET status = 2 WHERE id_indicator =" . $indicator_id ) );
    
    if( $update ){
        echo json_encode($wpdb->show_errors);
    }else{
        echo json_encode($wpdb->show_errors);
    } 

    wp_die();

}

add_action( 'wp_ajax_update_job_positions', 'update_job_positions' );

function update_job_positions($values){

    global $wpdb;

    $values =  $_POST['values'];

    foreach($values as $value){
        $data[$value['name']] = $value['value'];
    }

    $fields = array(
        'id_occupation'     => $data['id_occupation'],
        'code_job_position' => $data['code_job_position'],
        'digital'           => $data['digital'],
        'description'       => $data['description']
    );

    $where = [ 'id_job_position' => $data['id_job_position'] ];

    $update = $wpdb->update( 'cl_job_positions', $data, $where );

    if( $update ){
        echo json_encode(true);
    }else{
        echo json_encode($wpdb->show_errors); 
    } 

    wp_die();

}



add_action( 'wp_ajax_create_job_positions', 'create_job_positions' );

function create_job_positions($values){

    global $wpdb;

    $values =  $_POST['values'];

    foreach($values as $value){
        $data[$value['name']] = $value['value'];
    }

    $fields = array(
        'id_occupation'     => $data['id_occupation'],
        'digital'           => $data['digital'],
        'name_job_position' => $data['name_job_position'],
        'code_job_position' => $data['code_job_position'],
        'description'       => $data['description']
    );

    $id = $wpdb->get_results('select max(id_job_position) id from cl_job_positions ');
    $incremental = $id[0]->id + 1;

    $sql = "INSERT INTO cl_job_positions
                                (id_job_position, id_occupation, code_job_position, name_job_position, description, digital)
                                VALUES($incremental,{$fields['id_occupation']}, '{$fields['code_job_position']}', '{$fields['name_job_position']}', '{$fields['description']}', {$fields['digital']})";
    $create = $wpdb->query($sql );

    if( $create ){
        echo json_encode(true);
    }else{
        echo json_encode($wpdb->show_errors); 
    } 

    wp_die();

}

add_action( 'wp_ajax_remove_job_position', 'remove_job_position' );

function remove_job_position($id_job_position){

    global $wpdb;

    $id_job_position =  $_POST['id_job_position'];

    $where = [ 'id_job_position' => $id_job_position ];
    
    $delete = $wpdb->delete( 'cl_job_positions', $where );

    if( $delete ){
        echo json_encode(true);
    }else{
        echo json_encode($wpdb->show_errors); 
    } 
    
    wp_die();

}

