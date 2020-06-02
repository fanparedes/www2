<?php 
defined('ABSPATH') or die("Bye bye");

    add_action('wp_ajax_generate_dumy', 'dummy_data');

    //Ocupaciones más difíciles de llenar por sector
    function ranking_five_occupations($id){

        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){
            $array_response[$count]['type'] = 'text';  
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $array_response[$count]['data']['name'] = $result['data']['name'];
            $array_response[$count]['data']['region'] = $result['data']['region'];
      
            $count++;
        }

        return $array_response;
    } 

	//Ocupaciones más difíciles de llenar por sector por region
    function ranking_five_occupations_regional($id){

        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){
            $array_response[$count]['type'] = 'text';  
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $array_response[$count]['data']['name'] = $result['data']['name'];
            $array_response[$count]['data']['region'] = $result['data']['region'];
            $count++;
        }

        return $array_response;
    } 
    
    //Ocupaciones más difíciles de llenar por sector
    function vacants_fill_dificulty($id){
        
        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
          $count = 0;

            foreach($last_indicator_data as $result){      
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $array_response[$count]['data']['name'] = $result['data']['name'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['data']['class'] = $result['data']['class'];
                $array_response[$count]['data']['sector'] = $result['data']['sector'];
                
                $array_response[$count]['ind'] = $count;
                $count++;
            }

            return $array_response;
        } 

	//dificultad
    function vacants_fill_dificulty_regional($id){
                
        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){      
               
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['name'] = $result['data']['name'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['class'] = $result['data']['class'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['data']['description'] = $result['data']['description'];

                $count++;
        }

        return $array_response;
        
    } 

    //HABILIDADES O COMPETENCIAS BUSCADAS EN UNA OCUPACIÓN
    /*function top_three_abilities($id){
        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){      
        
                $array_response[$count]['type'] = 'text';
                    $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['name'] = $result['data']['name'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['ind'] = $count;

                $count++;
        }

        return $array_response;
        
    } */
         //HABILIDADES O COMPETENCIAS BUSCADAS EN UNA OCUPACIÓN REGIONAL
     function top_three_abilities(){

         global $wpdb;

         $occupations = $wpdb->get_results("SELECT id_occupation FROM cl_occupations");

         $response = '%s (%s) presenta un total de %s a causa de %s a nivel nacional';

         $count = 0;

         foreach ($occupations as $occupation) {
             $query = "SELECT  name_pt_competencias, pt_competencias percentage, name_job_position, name_occupation from cl_competencia cc
                        inner join cl_job_positions cjp
                        on cc.pt_codigo = cjp.code_job_position
                        inner join cl_occupations co 
                        on cjp.id_occupation = co.id_occupation
                        inner join cl_pt_competencias cpc
                        on cc.pt_competencias = cpc.code_pt_competencias
                        where co.id_occupation = '{$occupation->id_occupation}'
                        order by pt_competencias desc
                        limit 3";

             $results = $wpdb->get_results($query);
             
             foreach ($results as $result) {

                     $array_response[$count]['type'] = 'text';
                     $array_response[$count]['data']['value']       = $result->percentage;
                     $array_response[$count]['data']['name']        = $result->name_pt_competencias;
                     $array_response[$count]['data']['title']       = $result->name_job_position;
                     $array_response[$count]['data']['occupation']  = $result->name_occupation;
                     $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position, $result->name_occupation, $result->percentage, $result->name_pt_competencias);

                     $count++;
            }         
    
        }
             return $array_response;
    } 

	//HABILIDADES O COMPETENCIAS BUSCADAS EN UNA OCUPACIÓN REGIONAL
    function top_three_abilities_regional($id){
        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){      
        
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['name'] = $result['data']['name'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
        }

        return $array_response;
    	         
    } 

    //CANALES DE RECLUTAMIENTO POR OCUPACIÓN
    function top_three_ways($id){
        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){      
        
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['name'] = $result['data']['name'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['ind'] = $count;

                $count++;
        }

        return $array_response;
    } 

	//CANALES DE RECLUTAMIENTO POR OCUPACIÓN REGIONAL
    function top_three_ways_regional($id){
        
        global $wpdb;
       
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = ".$id)); 

        $last_indicator_data = json_decode($results->data, true);
         
        $count = 0;

        foreach($last_indicator_data as $result){
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['name'] = $result['data']['name'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['region'] = $result['data']['region'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }

        return $array_response;
    } 
           


    
    
    
    
    
    
    
    
    
    // //Ocupaciones más difíciles de llenar por sector
    // function vacants_fill_dificulty(){
            // global $wpdb;

            // $response = '%s y %s presentan un total de %s a causa de %s a nivel nacional';

            // $query = "	SELECT  name_job_position, name_class, name_pt_code_dificultad, pt_n_dificultad percentage, name_sector
						// from cl_dificultad cd 
						// inner join cl_job_positions cjp 
						// on cd.pt_codigo = cjp.code_job_position
						// inner join cl_pt_code_dificultad cpcd
						// on cd.pt_code_dificultad = cpcd.code_pt_code_dificultad
						// inner join cl_conversion cc
						// on cd.pt_codigo = cc.pt_codigo
						// inner join cl_class ccs 
						// on cc.clase = ccs.id_class
						// inner join cl_groups cg
						// on cg.id_group = ccs.id_group
						// inner join cl_divisions cds
						// on cds.id_division = cg.id_division
						// inner join cl_sectors cs 
						// on cs.id_sector = cds.id_sector
						// order by pt_n_dificultad desc
						// limit 1";

            // $results = $wpdb->get_results($query);
                       
            // $count = 0;

            // foreach($results as $result){
                // $array_response[$count]['type'] = 'text';
                // $array_response[$count]['data']['value'] = $result->percentage;
                // $array_response[$count]['data']['name'] = $result->name_pt_code_dificultad;
                // $array_response[$count]['data']['title'] = $result->name_job_position;
                // $array_response[$count]['data']['class'] = $result->name_class;
                // $array_response[$count]['data']['sector'] = $result->name_sector;
                // $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position,  $result->name_class, $result->percentage, $result->name_pt_code_dificultad); 
                // $array_response[$count]['ind'] = $count;
                // $count++;
            // }

            // return $array_response;
        // } 

	// //dificultad

    // function vacants_fill_dificulty_regional(){

    	// global $wpdb;

        // $regions = $wpdb->get_results("SELECT id_region, name_region FROM cl_regions");

        // $response = '%s y %s presentan un total de %s a causa de %s en la region de %s ';

        // $count = 0;

        // foreach ($regions as $region) {

            // $query = "SELECT  name_job_position, name_class, name_pt_code_dificultad, pt_n_dificultad percentage, name_region 
				// from cl_dificultad cd 
				// inner join cl_job_positions cjp 
				// on cd.pt_codigo = cjp.code_job_position
				// inner join cl_regions cr
				// on cr.id_region = cd.region
				// inner join cl_pt_code_dificultad cpcd
				// on cd.pt_code_dificultad = cpcd.code_pt_code_dificultad
				// inner join cl_conversion cc
				// on cd.pt_codigo = cc.pt_codigo
				// inner join cl_class ccs 
				// on cc.clase = ccs.id_class
				// where region = '{$region->id_region}'
				// order by pt_n_dificultad desc 
				// limit 1";

			// $results = $wpdb->get_results($query);
             
            // foreach ($results as $result) {

                	// $array_response[$count]['type'] = 'text';
                    // $array_response[$count]['data']['value'] = $result->percentage;
                    // $array_response[$count]['data']['name'] = $result->name_pt_code_dificultad;
                    // $array_response[$count]['data']['title'] = $result->name_job_position;
                    // $array_response[$count]['data']['class'] = $result->name_class;
                    // $array_response[$count]['data']['region'] = $result->name_region;
                    // $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position, $result->name_class, $result->percentage, $result->name_pt_code_dificultad, $result->name_region);

                    // $count++;
            // }         
    
        // }
            // return $array_response;
    // } 

    // //HABILIDADES O COMPETENCIAS BUSCADAS EN UNA OCUPACIÓN
    // function top_three_abilities(){
            // global $wpdb;

            // $response = '%s presenta un total de %s a causa de %s a nivel nacional';

            // $query = "	SELECT name_pt_competencias, pt_competencias_n percentage, name_job_position from cl_competencia cc
						// inner join cl_job_positions cjp
						// on cc.pt_codigo = cjp.code_job_position
						// inner join cl_pt_competencias cpc
						// on cc.pt_competencias = cpc.code_pt_competencias
						// order by pt_competencias_n desc
						// limit 3";

            // $results = $wpdb->get_results($query);
                       
            // $count = 0;

            // foreach($results as $result){
                // $array_response[$count]['type'] = 'text';
                // $array_response[$count]['data']['value'] = $result->percentage;
                // $array_response[$count]['data']['name'] = $result->name_pt_competencias;
                // $array_response[$count]['data']['title'] = $result->name_job_position;
                // $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position, $result->percentage, $result->name_pt_competencias); 
                // $array_response[$count]['ind'] = $count;
                // $count++;
            // }

            // return $array_response;
        // } 

	// //HABILIDADES O COMPETENCIAS BUSCADAS EN UNA OCUPACIÓN REGIONAL
    // function top_three_abilities_regional(){

    	// global $wpdb;

        // $regions = $wpdb->get_results("SELECT id_region, name_region FROM cl_regions");

        // $response = '%s presenta un total de %s a causa de %s en la region %s';

        // $count = 0;

        // foreach ($regions as $region) {

            // $query = "SELECT  name_pt_competencias, name_region, pt_competencias_n percentage, name_job_position from cl_competencia cc
						// inner join cl_job_positions cjp
						// on cc.pt_codigo = cjp.code_job_position
						// inner join cl_pt_competencias cpc
						// on cc.pt_competencias = cpc.code_pt_competencias
						// inner join cl_regions cr
						// on cc.region = cr.id_region
						// where region = '{$region->id_region}'
						// order by pt_competencias desc
						// limit 3";

			// $results = $wpdb->get_results($query);
             
            // foreach ($results as $result) {

                	// $array_response[$count]['type'] = 'text';
                    // $array_response[$count]['data']['value'] = $result->percentage;
                    // $array_response[$count]['data']['name'] = $result->name_pt_competencias;
                    // $array_response[$count]['data']['title'] = $result->name_job_position;
                    // $array_response[$count]['data']['region'] = $result->name_region;
                    // $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position, $result->percentage, $result->name_pt_competencias, $result->name_region);

                    // $count++;
            // }         
    
        // }
            // return $array_response;
    // } 

// //CANALES DE RECLUTAMIENTO POR OCUPACIÓN
    // function top_three_ways(){
            // global $wpdb;

            // $response = '%s tiene un total de %s de resultados en  %s a nivel nacional';

            // $query = "	SELECT name_actividad_observatorio, name_sector_canales_reclutamiento, sector_canales_reclutamiento_n percentage
						// FROM cl_canal_de_reclutamiento ccr
						// inner join cl_sector_canales_reclutamiento cscr
						// on ccr.code_canal_reclutamiento = cscr.code_sector_canales_reclutamiento
						// inner join cl_actividad_observatorio cao
						// on ccr.actividad_observatorio = cao.code_actividad_observatorio
						// order by sector_canales_reclutamiento_n desc
						// limit 3";

            // $results = $wpdb->get_results($query);
                       
            // $count = 0;

            // foreach($results as $result){
                // $array_response[$count]['type'] = 'text';
                // $array_response[$count]['data']['value'] = $result->percentage;
                // $array_response[$count]['data']['name'] = $result->name_actividad_observatorio;
                // $array_response[$count]['data']['title'] = $result->name_sector_canales_reclutamiento;
                // $array_response[$count]['data']['description'] = sprintf($response, $result->name_sector_canales_reclutamiento, $result->percentage, $result->name_actividad_observatorio); 
                // $array_response[$count]['ind'] = $count;
                // $count++;
            // }

            // return $array_response;
        // } 

	// //CANALES DE RECLUTAMIENTO POR OCUPACIÓN REGIONAL
    // function top_three_ways_regional(){

    	// global $wpdb;

        // $regions = $wpdb->get_results("SELECT id_region, name_region FROM cl_regions");

        // $response = '%s tiene un total de %s de resultados en  %s en la region %s';

        // $count = 0;

        // foreach ($regions as $region) {

            // $query = "	SELECT name_actividad_observatorio, name_sector_canales_reclutamiento, sector_canales_reclutamiento_n percentage, name_region
						// FROM cl_canal_de_reclutamiento ccr
						// inner join cl_regions cs
						// on ccr.region = cs.id_region
						// inner join cl_sector_canales_reclutamiento cscr
						// on ccr.code_canal_reclutamiento = cscr.code_sector_canales_reclutamiento
						// inner join cl_actividad_observatorio cao
						// on ccr.actividad_observatorio = cao.code_actividad_observatorio
						// where region = '{$region->id_region}'
						// order by sector_canales_reclutamiento_n desc
						// limit 3";

			// $results = $wpdb->get_results($query);
             
            // foreach ($results as $result) {

                	// $array_response[$count]['type'] = 'text';
                    // $array_response[$count]['data']['value'] = $result->percentage;
                    // $array_response[$count]['data']['name'] = $result->name_sector_canales_reclutamiento;
                    // $array_response[$count]['data']['title'] = $result->name_actividad_observatorio;
                    // $array_response[$count]['data']['region'] = $result->name_region;
                    // $array_response[$count]['data']['description'] = sprintf($response, $result->name_actividad_observatorio, $result->percentage, $result->name_sector_canales_reclutamiento, $result->name_region);

                    // $count++;
            // }         
    
        // }
            // return $array_response;
    // } 
           


