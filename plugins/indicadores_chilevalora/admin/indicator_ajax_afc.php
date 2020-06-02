<?php

    defined('ABSPATH') or die("Bye bye");

    add_action('wp_ajax_generate_dumy', 'dummy_data');

    //Porcentaje de contratos indefinidos
    function indefnite_contracts_percentage_national($id){

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

            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            
            $count++;
        }

        return $array_response;
    } 

    function indefnite_contracts_percentage_regional($id){

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

            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['region'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            
            $count++;
        }

        return $array_response;
    } 


   //%%s contractos indefinidos
    function higher_indefinite_contracts($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            $count++;
        }

        return $array_response;
    } 


    function lower_indefinite_contracts($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }
    
        return $array_response;
    }

     //contratos indefinidos regional top 3 
    function higher_indefinite_contracts_regional($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['region'] = $result['data']['region'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }
    
        return $array_response;
    }
            

 //XX%s migrantes 
function highest_migrants_percentage($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }
    
        return $array_response;
    }
      
      function lower_migrants_percentage($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }
    
        return $array_response;
    }  

    function highest_migrants_percentage_by_region($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['region'] = $result['data']['region'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }
    
        return $array_response;
    } 
    
     function lower_migrants_percentage_by_region($id){

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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['region'] = $result['data']['region'];
            $array_response[$count]['data']['description'] = $result['data']['description'];
            $count++;
        }
    
        return $array_response;
    } 
 

   //XX%s de mujeres
    function highest_female_percentage($id){

        global $wpdb;

        $array_response = array(array());

        $response = '%s presenta un %s porciento, de mujeres en ultimo periodo';

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
            $array_response[$count]['data']['title'] = $result['data']['title'];
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            $count++;
        }

        return $array_response;
   	}

    function lower_female_percentage($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['value'] = $result['data']['value'];        
                $array_response[$count]['data']['description'] = $result['data']['description']; 
                $count++;
            }

            return $array_response;
        }

        function highest_female_percentage_by_region($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['region'] = $result['data']['region'];         
                $array_response[$count]['data']['description'] = $result['data']['description']; 
                $count++;
            }

            return $array_response;
        }
    
        function lower_female_percentage_by_region($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['region'] = $result['data']['region'];         
                $array_response[$count]['data']['description'] = $result['data']['description']; 
                $count++;
            }

            return $array_response;
        }


    //XX% nuevo empleados
    function new_employees_national($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['value'] = $result['data']['value'];        
                $array_response[$count]['data']['description'] = $result['data']['description']; 
                $count++;
            }

            return $array_response;
        }  

    //XX% Rotación  
    function new_rotation_national($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 

    //numero de ocupados
        function higher_number_occupied($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 
    
    function lower_number_occupied($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 
    
    function higher_number_occupied_by_region($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 

   function lower_number_occupied_by_region($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['region'] = $result['data']['region'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 

     function female_percentage_national($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 
    
    function active_population($id){
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
                $array_response[$count]['type'] = 'text';
                $array_response[$count]['data']['value'] = $result['data']['value'];
                $array_response[$count]['data']['title'] = $result['data']['title'];
                $array_response[$count]['data']['description'] = $result['data']['description'];
                $count++;
            }
                    
            return $array_response;
        } 


    function female_percentage_general($id){
            
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
            $array_response[$count]['type'] = 'text';
            $array_response[$count]['data']['value'] = $result['data']['value'];
            $array_response[$count]['data']['description'] = $result['data']['description']; 
            $count++;
        }

        return $array_response;
    }  
  


?>