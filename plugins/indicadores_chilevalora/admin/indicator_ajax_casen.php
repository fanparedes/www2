<?php

    defined('ABSPATH') or die("Bye bye");

    //3.2.3   Mediana salarial CORREGIR SQL
    function salary_avg($id){

        global  $wpdb;
        
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = " . $id)); 

        $last_indicator_data = json_decode($results->data, true);

        $count = 0;

        foreach($last_indicator_data as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 

            $count++;

        }

        return $array_response;   
      
    }
    //3.2.1 Ranking de % más ocupados
    function ranking_occupied($id){

        global  $wpdb;

        $results = array_shift($wpdb->get_results("
                                SELECT 
                                    id_indicator, 
                                    id_indicator_type, 
                                    data, 
                                    created_at 
                                FROM cl_indicators
                                WHERE status = 0 
                                AND id_indicator_type = " . $id)); 

        $last_indicator_data = json_decode($results->data, true);

        $count = 0;

        foreach($last_indicator_data as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] =  $result['data']['value'];
            $array_response[$count]['data']['title'] =  $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 

            $count++;

        }

        return $array_response;   
      
    }
    //3.2.2 XX% de contratos indefinidos
    function indefinite_contract($id){
        global $wpdb;

         $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = " . $id)); 

        $last_indicator_data = json_decode($results->data, true);

        $count = 0;

        foreach($last_indicator_data as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 

            $count++;
        }
        
        return $array_response;
    }

    //3.2.6 XX% de mujeres
        // PORCENTAJE DE MUJERES ENTRE LOS TRABAJADORES OCUPADOS EN EL ULTIMO PERIODO.
    function female_percentage($id){     

        global  $wpdb;
        
        $results = array_shift($wpdb->get_results("
                    SELECT 
                        id_indicator, 
                        id_indicator_type, 
                        data, 
                        created_at 
                    FROM cl_indicators
                    WHERE status = 0 
                    AND id_indicator_type = " . $id)); 

        $last_indicator_data = json_decode($results->data, true);

        $count = 0;

        foreach($last_indicator_data as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description'];

            $count++;

        }

        return $array_response;        
    }

    //3.2.5   Tasa de crecimiento de ocupados PTE 1
    // RESPONDE TOP 5 OCUPACIONES CON MAYOR CRECIMIENTO EN EL ULTIMO PERIODO
    function topfiveCrecimiento($id){
        
        global $wpdb;
        
        $array_response = array(array());
        $response = '%s presenta un  %s porciento ';

        $results = array_shift($wpdb->get_results("
                                SELECT 
                                    id_indicator, 
                                    id_indicator_type, 
                                    data, 
                                    created_at 
                                FROM cl_indicators
                                WHERE status = 0 
                                AND id_indicator_type = " . $id)); 

        $last_indicator_data = json_decode($results->data, true);

       
        $count = 0;

        foreach($last_indicator_data as $result){
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            $count++;
        }
	       

        return $array_response;        
    }


    //3.2.5   Tasa de crecimiento de ocupados PTE 2
    function menorCrecimiento($id){
        
        global $wpdb;
        
        $array_response = array(array());
        
        //$response = '%s presenta un  %s porciento ';

        /*$results = $wpdb->get_results("SELECT distinct co.name_occupation, bc.variation as tasa_crecimiento
        	from cl_occupations co, cl_busy_casen bc
        	where bc.ano = (select max(ano) from cl_busy_casen) and bc.variation::varchar != 'NULL' 
        	and bc.id_occupation = co.id_occupation
        	order by bc.variation asc
        	limit 1");*/

        $results = array_shift($wpdb->get_results("
                                SELECT 
                                    id_indicator, 
                                    id_indicator_type, 
                                    data, 
                                    created_at 
                                FROM cl_indicators
                                WHERE status = 0 
                                AND id_indicator_type = " . $id)); 

       $last_indicator_data = json_decode($results->data, true);

       
        $count = 0;
                        

        foreach($last_indicator_data as $result){
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            $count++;
        }

        return $array_response;             
    }


    //3.2.4 Participación en distintos sectores --> FALTA INFO EN EL DOCUMENTO DE INDICADORES

    function participation_by_sector(){
        global $wpdb;
        $array_response = array(array());
        $response = '%s del sector %s tiene un porcentaje de parcitipación de %s';

        $results = $wpdb->get_results(" SELECT 
                                            co.id_occupation, 
                                            co.name_occupation, 
                                            cs.name_sector, 
                                            cosp.participation as porcentaje_participación
                                        FROM 
                                            cl_casen_ocupation_sector_participation cosp, 
                                            cl_occupations co, cl_sectors cs
                                        WHERE 
                                            cosp.code_ocupation = co.id_occupation 
                                        AND 
                                            cosp.code_sector = cs.id_sector
                                        GROUP BY 
                                            co.id_occupation, cs.id_sector, cosp.participation
                                        ORDER BY 
                                            co.id_occupation");

       
       $count = 0;

	        foreach($results as $result){

	            $array_response[$count]['data']['type'] = 'text';
	            $array_response[$count]['data']['value'] = $result->porcentaje_participación;
	            $array_response[$count]['data']['title'] = $result->name_occupation;
	            $array_response[$count]['data']['description'] = sprintf($response, $result->name_occupation, $result->name_sector, $result->porcentaje_participación); 

	            $count++;

	        }

        return $array_response;             
    }


?>
