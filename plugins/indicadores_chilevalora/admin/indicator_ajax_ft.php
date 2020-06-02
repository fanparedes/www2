<?php

    defined('ABSPATH') or die("Bye bye");

    //RANKING DE LAS HABILIDADES MÁS SOLICITADAS EN LAS BOLSAS DE EMPLEO (NIVEL NACIONAL)
    function ranking_request_abilities_national(){

        global  $wpdb;

        $response = '%s presenta un %s porciento a nivel nacional en el último periodo.';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT k.code_knowledge, k.name_knowledge, round(cast((((ko.number_offer::float*100)/(select sum(number_offer::float) from cl_knowledges_offers))) as numeric), 1) as percentage
            from cl_knowledges_offers ko, cl_knowledges k
            where k.code_knowledge = ko.code_knowledges
            order by percentage desc
            limit 10");

        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result->percentage;
            $array_response[$count]['data']['title'] = $result->name_knowledge;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_knowledge, $result->percentage); 

            $count++;
  
        }

        return $array_response;   
      
    }
    
    //RANKING DE LAS HABILIDADES MÁS SOLICITADAS EN LAS BOLSAS DE EMPLEO (NIVEL REGIONAL)
    function ranking_request_abilities_regional(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en la region %s el ultimo periodo';

        $array_response = array(array()); 
       
        $regions = $wpdb->get_results("SELECT id_region, code_region, name_region FROM cl_regions");
  
        $count = 0;

        foreach ($regions as $region) {

            $results = $wpdb->get_results("SELECT k.code_knowledge, k.name_knowledge, r.id_region, r.name_region, round(cast(((kro.number_offer * 100)/a.total_region) as numeric),1) as percentage
                from cl_knowledges_regions_offers kro, cl_knowledges k, cl_regions r,
                (select id_region, sum(number_offer) as total_region from cl_knowledges_regions_offers group by id_region) as a
                where k.code_knowledge = kro.code_knowledge and r.id_region = kro.id_region and kro.id_region = a.id_region 
                and a.id_region = {$region->id_region}
                order by percentage desc
                limit 3");

            foreach ($results as $result) {

                $array_response[$count]['data']['type'] = 'text';
                $array_response[$count]['data']['title'] = $result->name_knowledge;
                $array_response[$count]['data']['value'] = $result->percentage;
                $array_response[$count]['data']['region'] = $result->name_region;
                $array_response[$count]['data']['description'] = sprintf($response, $result->name_knowledge, $result->percentage, $result->name_region );

                $count++;
            }         
    
        }
        return $array_response;

    }

    //XX% DE OFERTAS DE TRABAJO QUE CITAN ESTA HABILIDAD (NIVEL NACIONAL)
    function job_offer_national(){

        global  $wpdb;

        $response = '%s presenta un %s porciento a nivel nacional en el último periodo.';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT k.code_knowledge, k.name_knowledge, round(cast((((ojk.number_offer::float*100)/(select sum(number_offer::float) from cl_offers_jobs_knowledges))) as numeric), 1) as percentage
            from cl_offers_jobs_knowledges ojk, cl_knowledges k
            where k.code_knowledge = ojk.code_knowledge
            order by percentage desc");

        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result->percentage;
            $array_response[$count]['data']['title'] = $result->name_knowledge;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_knowledge, $result->percentage); 

            $count++;
  
        }

        return $array_response;   
      
    }

    //XX% DE OFERTAS DE TRABAJO QUE CITAN ESTA HABILIDAD (NIVEL REGIONAL)
    function job_offer_regional(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en la region %s el ultimo periodo';

        $array_response = array(array()); 
  
            $results = $wpdb->get_results("SELECT r.id_region, r.name_region, k.code_knowledge, k.name_knowledge, round(cast(((kro.number_offer::float * 100)/a.total_region::float) as numeric),1) as percentage
                from cl_knowledges_regions_offers kro, cl_knowledges k, cl_regions r,
                (select id_region, sum(number_offer) as total_region from cl_knowledges_regions_offers group by id_region) as a
                where k.code_knowledge = kro.code_knowledge and r.id_region = kro.id_region and kro.id_region = a.id_region
                order by id_region, percentage desc");

            $count = 0;

            foreach($results as $result){

                $array_response[$count]['data']['type'] = 'text';
                $array_response[$count]['data']['title'] = $results[0]->name_knowledge;
                $array_response[$count]['data']['value'] = $results[0]->percentage;
                $array_response[$count]['data']['region'] = $results[0]->name_region;
                $array_response[$count]['data']['description'] = sprintf($response, $results[0]->name_knowledge, $results[0]->percentage, $results[0]->name_region ); 

                $count++;

            }
        
        return $array_response;
    
    }

    //RANKING DE OCUPACIONES QUE SOLICITAN ESTA HABILIDAD (NIVEL NACIONAL)
    function occupation_ranking_ability_national(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en %s a nivel nacional en el último periodo.';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT k.code_knowledge, k.name_knowledge, jp.code_job_position, jp.name_job_position, round(cast(((jpko.number_offer::float*100)/a.total) as numeric),1) as percentage
            from cl_job_positions_knowledges_offers jpko, cl_job_positions jp, cl_knowledges k, 
            (select code_knowledge, sum(number_offer::float) as total from cl_job_positions_knowledges_offers group by code_knowledge) as a
            where jp.code_job_position = jpko.code_job_position and k.code_knowledge = jpko.code_knowledge and jpko.code_knowledge = a.code_knowledge 
            order by code_knowledge, percentage desc");

        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result->percentage;
            $array_response[$count]['data']['title'] = $result->name_job_position;
            $array_response[$count]['data']['region'] = $result->name_knowledge;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_knowledge, $result->percentage, $result->name_job_position); 

            $count++;
  
        }

        return $array_response;   
      
    }

    //RANKING DE LAS OCUPACIONES MÁS DEMANDADAS EN LAS BOLSAS DE EMPLEO (DIGITALES - NIVEL NACIONAL)
    function demmanded_occupation_digital_national(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en la habilidad %s a nivel nacional.';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT k.code_knowledge, k.name_knowledge, jp.code_job_position, jp.name_job_position, round(cast(((jpko.number_offer::float*100)/a.total) as numeric),1) as percentage
            from cl_job_positions_knowledges_offers jpko, cl_job_positions jp, cl_knowledges k, 
            (select code_knowledge, sum(number_offer::float) as total from cl_job_positions_knowledges_offers group by code_knowledge) as a
            where jp.code_job_position = jpko.code_job_position and k.code_knowledge = jpko.code_knowledge and jpko.code_knowledge = a.code_knowledge 
            order by code_knowledge, percentage desc");

        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result->percentage;
            $array_response[$count]['data']['title'] = $result->name_job_position;
            $array_response[$count]['data']['region'] = $result->name_knowledge;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_knowledge, $result->percentage, $result->name_job_position); 

            $count++;
  
        }

        return $array_response;   
      
    }

    //RANKING DE LAS OCUPACIONES MÁS DEMANDADAS EN LAS BOLSAS DE EMPLEO (DIGITALES - NIVEL REGIONAL)(EL ID DE REGIÓN DEBE SER REMPLAZADO POR CADA REGIÓN)
    function demmanded_occupation_digital_regional(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en la region %s el ultimo periodo';

        $array_response = array(array()); 

        $regions = $wpdb->get_results("SELECT id_region, code_region, name_region FROM cl_regions");

        $count = 0;

        foreach ($regions as $region) {

            $results = $wpdb->get_results("SELECT k.code_knowledge, k.name_knowledge, r.id_region, r.name_region, round(cast(((kro.number_offer * 100)/a.total_region) as numeric),1) as percentage
                from cl_knowledges_regions_offers kro, cl_knowledges k, cl_regions r,
                (select id_region, sum(number_offer) as total_region from cl_knowledges_regions_offers group by id_region) as a
                where k.code_knowledge = kro.code_knowledge and r.id_region = kro.id_region and kro.id_region = a.id_region 
                and a.id_region = {$region->id_region}
                order by percentage desc
                limit 3");

                $array_response[$count]['data']['type'] = 'text';
                $array_response[$count]['data']['title'] = $results[0]->name_knowledge;
                $array_response[$count]['data']['value'] = $results[0]->percentage;
                $array_response[$count]['data']['region'] = $results[0]->name_region;
                $array_response[$count]['data']['description'] = sprintf($response, $results[0]->name_knowledge, $results[0]->percentage, $results[0]->name_region ); 

                $count++;

        }
        
        return $array_response;
    
    }

    //RANKING DE LAS DE LAS 10 HABILIDADES MÁS DEMANDADAS PARA ESTA OCUPACIÓN (NIVEL NACIONAL)
    function ranking_demmanded_abilities_occupation_national(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en el conocimiento %s a nivel nacional en el último periodo.';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT jp.code_job_position, jp.name_job_position, k.code_knowledge, k.name_knowledge, round(cast((kjpo.ranking_profile_knowledges*100)as numeric),1)
            from cl_knowledges_job_positions_offers kjpo, cl_knowledges k, cl_job_positions jp
            where k.code_knowledge = kjpo.code_knowledge and jp.code_job_position = kjpo.code_job_position
            order by  jp.code_job_position, kjpo.ranking_profile_knowledges desc");

        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result->round;
            $array_response[$count]['data']['title'] = $result->name_job_position;
            $array_response[$count]['data']['region'] = $result->name_knowledge;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position, $result->round, $result->name_knowledge); 

            $count++;
  
        }

        return $array_response;   
      
    }

    //XX% DE OFERTAS DE TRABAJO QUE CITAN ESTA OCUPACIÓN (NIVEL NACIONAL)
    function job_offers_occupation_national(){

        global  $wpdb;

        $response = '%s presenta un total de %s ofertas  a nivel nacional en el último periodo.';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT jp.name_job_position, jpro.number_offer as percentage 
            from cl_job_positions_regions_offers jpro, cl_job_positions jp
            where jp.code_job_position = jpro.code_job_position
            group by jp.name_job_position, jpro.number_offer
            order by percentage desc");
        
        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['value'] = $result->percentage;
            $array_response[$count]['data']['title'] = $result->name_job_position;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position, $result->percentage); 

            $count++;
  
        }

        return $array_response;   
      
    }

    //XX% DE OFERTAS DE TRABAJO QUE CITAN ESTA OCUPACIÓN (NIVEL REGIONAL)
    function job_offers_occupation_regional(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en la region %s el ultimo periodo';

        $array_response = array(array()); 
  
            $results = $wpdb->get_results("SELECT r.id_region, r.name_region, jp.code_job_position, jp.name_job_position, round(cast(((jpro.number_offer::float*100)/a.total_region) as numeric),1) as percentage
                from cl_job_positions_regions_offers jpro, cl_job_positions jp, cl_regions r,
                (select id_region, sum(number_offer::float) as total_region from cl_job_positions_regions_offers group by id_region ) as a
                where jp.code_job_position = jpro.code_job_position and r.id_region = jpro.id_region and jpro.id_region = a.id_region
                group by jp.code_job_position, jp.name_job_position, r.id_region, jpro.number_offer, a.total_region
                order by r.id_region, percentage desc");

            $count = 0;

            foreach($results as $result){

                $array_response[$count]['data']['type'] = 'text';
                $array_response[$count]['data']['title'] = $results[0]->name_job_position;
                $array_response[$count]['data']['value'] = $results[0]->percentage;
                $array_response[$count]['data']['region'] = $results[0]->name_region;
                $array_response[$count]['data']['description'] = sprintf($response, $results[0]->name_job_position, $results[0]->percentage, $results[0]->name_region ); 

                $count++;

            }
        
        return $array_response;
    
    }

    //OCUPACIONES MÁS DEMANDADAS EN LAS BOLSAS DE EMPLEO (NIVEL NACIONAL)
    function job_demmanded_occupations_national(){

        global  $wpdb;

        $response = '%s';

        $array_response = array(array()); 

        $results = $wpdb->get_results("SELECT jp.code_job_position, jp.name_job_position
                from cl_job_positions_offers jpo, cl_job_positions jp
                where jp.code_job_position = jpo.code_job_position 
                order by jpo.number_offer desc
                limit 10");
        
        $count = 0;

        foreach($results as $result){

            $array_response[$count]['data']['type'] = 'text';
            $array_response[$count]['data']['title'] = $result->name_job_position;
            $array_response[$count]['data']['description'] = sprintf($response, $result->name_job_position); 

            $count++;
  
        }

        return $array_response;   
    }

    //OCUPACIONES MÁS DEMANDADAS EN LAS BOLSAS DE EMPLEO (NIVEL REGIONAL)
    function job_demmanded_occupations_regional(){

        global  $wpdb;

        $response = '%s presenta un %s porciento en la region %s el ultimo periodo';

        $array_response = array(array()); 

        $regions = $wpdb->get_results("SELECT id_region, code_region, name_region FROM cl_regions");

        $count = 0;

        foreach ($regions as $region) {

            $results = $wpdb->get_results("SELECT jp.code_job_position, jp.name_job_position, r.id_region, r.name_region, round(cast(((jpro.number_offer::float*100)/a.total_region) as numeric),1) as percentage
                from cl_job_positions_regions_offers jpro, cl_job_positions jp, cl_regions r,
                (select id_region, sum(number_offer) as total_region from cl_job_positions_regions_offers group by id_region ) as a
                where jp.code_job_position = jpro.code_job_position and r.id_region = jpro.id_region and jpro.id_region = a.id_region
                and a.id_region = {$region->id_region}
                group by jp.code_job_position, jp.name_job_position, r.id_region, jpro.number_offer, a.total_region
                order by percentage desc
                limit 3");

                $array_response[$count]['data']['type'] = 'text';
                $array_response[$count]['data']['title'] = $results[0]->name_job_position;
                $array_response[$count]['data']['value'] = $results[0]->percentage;
                $array_response[$count]['data']['region'] = $results[0]->name_region;
                $array_response[$count]['data']['description'] = sprintf($response, $results[0]->name_job_position, $results[0]->percentage, $results[0]->name_region ); 

                $count++;

        }
        
        return $array_response;
    
    }   

    
?>
