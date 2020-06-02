<?php 
//if (!current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

if(isset( $_GET['ind'] ) && is_numeric($_GET['ind'])){

	$ind = $_GET['ind'];

	global $wpdb;

	$origins = $wpdb->get_results("SELECT id_data_origin, origin FROM cl_data_origins", OBJECT);

	$indicator_type = $wpdb->get_results("SELECT name_indicator_section FROM cl_indicator_sections WHERE id_indicator_section = '{$ind}' ", OBJECT);

	$html .= 	'<div class="container-fluid indicators-table-container">';

	$html .= '<h1>Indicador: ' . $indicator_type[0]->name_indicator_section . '</h1>';

	$html .= '<hr>';

	$total_indicators = array();
	
	foreach ($origins as $origin) {
		
		$types_indicators = $wpdb->get_results("
			SELECT cli.id_indicator_type, cli.name_indicator_type 
				FROM cl_indicator_types cli 
				INNER JOIN cl_indicator_type_origin clito 
				ON cli.id_indicator_type = clito.id_indicator_type 
			WHERE cli.id_indicator_section = " . $ind . " AND clito.id_data_origin = " . $origin->id_data_origin . "", OBJECT);

		if($types_indicators){

			$html .= 	'<h2>Fuente de datos ' . $origin->origin . '</h2>';
			$html .=	'<hr>';
			$html .= 	'<table class="table data-table table-stripped">';
				$html .= 	'<thead>';
					$html .= 	'<tr>';
					$html .= 	'<td>';
							$html .= 	'ID';
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= 	'Descripción de indicador';
						$html .= 	'</td>';
						
						$html .= 	'<td>';
							$html .= 	'Resultado Generado';
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= 	'Resultado Publicado';
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= 	'Estado';
						$html .= 	'</td>';
						$html .= 	'<td style="text-align: center;min-width: 111px;">';
							$html .= 	'Creado';
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= 	'Acciones';
						$html .= 	'</td>';
					$html .= 	'</tr>';
				$html .= 	'</thead>';
				$html .= 	'<tbody>';

				foreach($types_indicators as $indicator){
					
					$results = create_indicator_preview($indicator->id_indicator_type);

					$html .= 	'<tr>';									
						$html .= 	'<td>';
							$html .= $indicator->id_indicator_type;
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= $indicator->name_indicator_type;
						$html .= 	'</td>';
										
						$html .= 	'<td><b>- </b><span class="slidetd">' . $results[0]['data']['description'] . '</span><ul class="listind">';

						$ind_key = $indicator->id_indicator_type;

						$i = 0;

						foreach ($results as $result) {	
							
							$total_indicators[$ind_key][$i]['data']['name'] = $indicator->name_indicator_type;
							$total_indicators[$ind_key][$i]['data']['description'] = $result['data']['description'];
							$total_indicators[$ind_key][$i]['data']['value'] = @$result['data']['value'];
							$total_indicators[$ind_key][$i]['data']['title'] = @$result['data']['title'];
							$total_indicators[$ind_key][$i]['data']['class'] = @$result['data']['class'];
							$total_indicators[$ind_key][$i]['data']['sector'] = @$result['data']['sector'];
							$total_indicators[$ind_key][$i]['data']['occupation'] = @$result['data']['occupation'];
							$total_indicators[$ind_key][$i]['data']['name'] = @$result['data']['name'];
							$total_indicators[$ind_key][$i]['data']['region'] = @$result['data']['region'];
							
							if ($i != 0){
									$html .= "<li><b>- </b>".$result['data']['description']."</li>";
							}
							$i++;
						}
						$html .= 	'</td>';

						$html .= 	'<td>';

						//Obtener el indicador que ya está publicado
						$last_indicator_query = $wpdb->get_results("
							SELECT 
								id_indicator, 
								id_indicator_type, 
								data, 
								created_at 
							FROM cl_indicators
							WHERE status = 1 
							AND id_indicator_type = " . $indicator->id_indicator_type); 
						

						$last_indicator_button = '';

						if($last_indicator_query){
							
							$last_indicator = array_shift($last_indicator_query);

							$last_indicator_data = json_decode($last_indicator->data, true);

							//print_r($last_indicator_data);
								
							if( count($last_indicator_data) > 1){		
								
								$html .= '<ul>';

								foreach( $last_indicator_data as $data  ){
									
										$html .= '<li>' . $data['data']['description'] . '</li>';
								}

								$html .= '</ul>';

							}else{					

								$html .= $last_indicator_data[0]['data']['description'];

							}

							$last_indicator_button	= '<button id="'.$last_indicator->id_indicator.'" class="btn-danger btn btn-block btn-hide-indicator">
							<span class="hidden spinner-border spinner-border-sm spiner" role="status" aria-hidden="true"></span> 
							Ocultar
							</button>';
							
						}
						$html .= 	'</td>';
						
						$html .= 	'<td>';
							$html .= 	(!empty($last_indicator_button) ? 'Publicado' : 'No publicado');
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= 	(!empty($last_indicator->created_at) ? $last_indicator->created_at : '-');
						$html .= 	'</td>';
						$html .= 	'<td>';
							$html .= 	'<button id="'.$ind_key.'" type="submit" class="btn-success btn btn-block btn-publish-indicator">
								<span class="hidden spinner-border spinner-border-sm spiner" role="status" aria-hidden="true"></span> 
								Publicar 	
								</button>';
							$html .= $last_indicator_button;
						$html .= 	'</td>';

					$html .= 	'</tr>';
 
				}

				$html .= 	'</tbody>';
			$html .= 	'</table>';

		}

	}


	$html .= 	'</div>';

	echo $html;
	
}




session_start();
$_SESSION['indicators'] = $total_indicators;

//print_r($total_indicators[1]);

//print_r($last_indicator_data);


//var_dump( $total_indicators[1]['data']);


?>
