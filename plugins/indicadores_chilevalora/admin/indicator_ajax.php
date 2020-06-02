<?php

    defined('ABSPATH') or die("Bye bye");

    add_action('wp_ajax_generate_dumy', 'dummy_data');

    add_action('wp_ajax_create_indicator', 'create_indicator');
    add_action('wp_ajax_save_indicator', 'save_indicator');

    function create_indicator(){
       // TODO en tabla cl_indicator_types falta columna que diferencie si es mayor o menor porcentaje
       // Por ahora se valida esto con el id del indicador
       switch($_GET['indicator_type']){
           case 58: participation_percent_by_sector('mayor', 'mujeres'); break;
           case 59: participation_percent_by_sector('menor', 'mujeres'); break;
           case 56 : participation_percent_by_sector('mayor', 'migrantes'); break;
           case 57 : participation_percent_by_sector('menor', 'migrantes'); break;
          
       }
    }

    function indefinite_contracts_percents() {
        global $wpdb;
        $results = $wpdb->get_results( "SELECT 
        ROUND((SELECT sum(number_workers) 
        FROM cl_afc WHERE id_contract_type = 1) * 100 / (SELECT SUM(number_workers) FROM cl_afc), 1) as porcentaje" );
        var_dump($results);
    }
    
    function participation_percent_by_sector($sign, $field, $time_interval = false){
        global $wpdb;
        $orderby = $sign == 'mayor' ? 'DESC' : 'ASC';
        switch($field){
            case 'migrantes': $conditional_field = 'cl_afc.id_nacionality = 2'; break;
            case 'mujeres': $conditional_field = 'cl_afc.id_sex = 2'; break;
        }

        if($_GET['region_id']) {
            $query =  regional_participation_query($orderby, $conditional_field);
        } else {
            $query =  national_participation_query($orderby, $conditional_field);
        }

        $results = $wpdb->get_results($query);
        
        if($_GET['region_id']){
            if($results){
                $range_text = sprintf('en la %s', $results[0]->name_region);
            } else {
                $region = $wpdb->get_results("SELECT name_region FROM cl_regions WHERE id_region = {$_GET['region_id']}");
                $range_text = sprintf('en la %s', $region[0]->name_region);
            }
        } else {
            $range_text = sprintf('a nivel nacional');
        }

        $description = 'No existen resultados para la solicitud';
        if($results) {

            $indicator_template = $wpdb->get_results("SELECT template FROM cl_indicator_section_template WHERE id_indicator_type = {$_GET['indicator_type']}");
            
            $template = $indicator_template[0]->template;
            // formato ejemplo: %s es el sector con mayor porcentaje de mujeres %s, con un %s%% el último año
            $description = sprintf($template, $results[0]->name_sector, $range_text, $results[0]->porcentaje);
        }
        
        $indicator = array(
            'categoria' => 'texto',        
            'tipo_post' => 'sector',
            'descripcion' => $description,
        );

        // campos de la tabla indicators para no volver a hacer la query al guardar
        $table_data = array(
            'id_indicator_type' => (int)$_GET['indicator_type'],
            'name_indicator' => sprintf('Sector con %s porcentaje de %s %s', $sign, $field, $range_text),
            'data' => json_encode($indicator),
            'page_asoc' => 0,
            'status' => 'true'
        );

        // Guardar en $_SESSION el resultado para ser guardado a la bdd despues que el usuario acepte guardarlo
        $tmp_id = time();
        $_SESSION['indicator_tmp_id_' . $tmp_id] = $table_data;
        
        // Entregar los datos del indicador + el id temporal para enviarlo en ajax al guardado
        $indicator['tmp_id'] = $tmp_id;

        //mostrar indicador con ajax
        echo json_encode($indicator);
        exit();
        
    }

    function save_indicator(){
        global $wpdb;

        // Crear insert manual para traer el id insertado. No funciona $wpdb->insert_id con postgres
        $data = $_SESSION['indicator_tmp_id_' . $_GET['tmp_id']];
        $wpdb->insert('cl_indicators', $data);
        $get_sequence = $wpdb->get_results("SELECT currval('cl_indicators_id_indicator_seq')");
        $indicator_id = $get_sequence[0]->currval;
        if($indicator_id){
            echo json_encode(array('success' => TRUE, 'id' => $indicator_id));
        } else {
            echo json_encode(array('success' => FALSE));
        }
        exit();
    }

    function regional_participation_query($orderby, $conditional_field){
        $query = "SELECT top_sector.name_sector, ROUND((top_sector.total_sector * 100.0 / (SELECT SUM(number_workers) AS total FROM cl_afc WHERE ano = (SELECT MAX(ano) FROM cl_afc) AND cl_afc.id_region_company = {$_GET['region_id']})), 1) AS porcentaje, top_sector.name_region
        FROM 
        (
            SELECT cl_sectors.id_sector, cl_sectors.name_sector, SUM(number_workers) as total_sector, cl_regions.name_region
            FROM cl_afc
            LEFT JOIN cl_subclass on cl_subclass.id_subclass = cl_afc.id_subclass
            LEFT JOIN cl_class  on cl_class.id_class = cl_subclass.id_class
            LEFT JOIN cl_groups on cl_groups.id_group = cl_class.id_group
            LEFT JOIN cl_divisions on cl_divisions.id_division = cl_groups.id_division
            LEFT JOIN cl_sectors ON cl_sectors.id_sector = cl_divisions.id_sector
            LEFT JOIN cl_regions ON cl_regions.id_region = cl_afc.id_region_company
            WHERE $conditional_field
            AND ano = (SELECT MAX(ano) FROM cl_afc)
            AND  cl_afc.id_region_company = {$_GET['region_id']}
            GROUP BY cl_sectors.id_sector, cl_regions.name_region
            ORDER BY total_sector {$orderby}
            LIMIT 1
        ) AS top_sector";

        return $query;
    }

    function national_participation_query($orderby, $conditional_field){
        $query =  "SELECT top_sector.name_sector, ROUND((top_sector.total_sector * 100.0 / (SELECT SUM(number_workers) FROM cl_afc WHERE ano = (SELECT MAX(ano) FROM cl_afc))), 1) AS porcentaje
        FROM 
        (
            SELECT cl_sectors.id_sector, cl_sectors.name_sector, SUM(number_workers) as total_sector
            FROM cl_afc
            LEFT JOIN cl_subclass on cl_subclass.id_subclass = cl_afc.id_subclass
            LEFT JOIN cl_class  on cl_class.id_class = cl_subclass.id_class
            LEFT JOIN cl_groups on cl_groups.id_group = cl_class.id_group
            LEFT JOIN cl_divisions on cl_divisions.id_division = cl_groups.id_division
            LEFT JOIN cl_sectors ON cl_sectors.id_sector = cl_divisions.id_sector
            WHERE $conditional_field
            AND ano = (SELECT MAX(ano) FROM cl_afc)
            GROUP BY cl_sectors.id_sector
            ORDER BY total_sector $orderby
            LIMIT 1
        ) AS top_sector";

        return $query;
    }

    function dummy_data(){
        global $wpdb;
        $results = $wpdb->get_results('SELECT id_afc from cl_afc');
        $parametros = array();
        foreach($results as $result){
            if($_GET['sectores']){
                $parametros = array('id_subclass' => rand(1, 597));
            } else if($_GET['sexo']) {
                $parametros = array('id_sex' => rand(1,2));
            }
            $wpdb->update('cl_afc', $parametros, array('id_afc' => $result->id_afc));
        }
    }

?>
