<?php

    global $wpdb;

    $buscar = isset($_POST['buscar_pt']) && $_POST['buscar_pt'] != '' ? strtolower($_POST['buscar_pt']) : '';

    $pagina = isset($_POST['start']) && $_POST['start'] != '' ? strtolower($_POST['start']) : '';

    $value = isset($_GET['buscar_pt']) ? $_GET['buscar_pt'] : '';

    $occupations = $wpdb->get_results('SELECT id_occupation, name_occupation FROM cl_occupations');
    
    $result = $wpdb->get_results('SELECT count(*) total_rows from cl_job_positions');

    $total = $result[0]->total_rows;

    $results_per_pages = 20;
?>


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>





<div class="container">

	<?php   
		if ($total > 0) {
            $page = false;
         
            //examino la pagina a mostrar y el inicio del registro a mostrar
            if ($pagina) {
                $page = $pagina;
       
            }
         
            if (!$page) {
                $start = 0;
                $page = 1;
            } else {
                $start = ($page - 1) * $results_per_pages;
                
            }
            //calculo el total de paginas
            $total_pages = $total / $results_per_pages; 
            
          }
        $sql = "SELECT * FROM cl_job_positions where lower(name_job_position) like '%".$buscar."%' ORDER BY name_job_position asc limit $results_per_pages offset $start";
 		
    	$job_positions = $wpdb->get_results($sql);
    	
    	//$url_actual = home_url( add_query_arg( array(), $wp->request ) );

    	

    	$url_actual = home_url( add_query_arg( array() ) );

        ?>
    
    <h3 class="text-center">Listado de puestos de trabajos</h3>

		<!-- Modal -->
		<div class="row">
			<div class="col-12 mb-4">
                <form action='' method='post' class="form-inline my-2 my-lg-0 float-right">
                      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" id="buscar_pt"  name="buscar_pt" aria-label="Search" >
                      <button class="btn btn-primary my-2 my-sm-0"  type="submit">Buscar</button>
                </form>
                				<button type="button" style="background-color: #304D6F; font-size: 14px; border-radius: 0; padding: 7px  21px;  " class="btn btn-primary btn-lg col-md-auto float-left" data-toggle="modal" data-target="#myModal">Nuevo</button>  
			</div>
		</div>

        <table class="table table-striped" id="job-positions-table">
  			<thead>
            	<tr>
                	<th width="100%">Puesto de trabajo</th>         	
            	</tr>
        	</thead>
                <tbody>
                <?php if ($job_positions == null ) :?>
			
                <tr>
                    <td>
                        <h4 class="text-center">No se han encontrado resultados</h4>
                    </td>
                </tr>

            <?php else : ?>
			    <?php foreach ($job_positions as $position): ?>

            <tr>
                <td>
                	                	
                	

                    <a href="#" class="job-position-link"> <?php echo $position->name_job_position; ?> </a>

                    	<form class="job-position-content hidden" action="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo'?>" method="post" target="_blank">       

                        <input type="hidden" class="id_job_position" name="id_job_position" value="<?php echo $position->id_job_position; ?>">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                          
                              
                                <button type="submit"   class="btn btn-primary">  Ir a la pagina</button>
                                

                                 <!-- <a  href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$position->id_job_position.'&id_occupation='.$position->id_occupation; ?>" target="_blank" > Ir a la pagina </a> -->
                              

                                <div class="form-group">

                                    <label style="margin-top: 5px;" for="id_occupation">Ocupación padre</label>
                                    <select name="id_occupation" id="id_occupation" class="form-control">
                                        <?php foreach($occupations as $occupation): ?>
                                        <option 
                                        <?php echo ($occupation->id_occupation == $position->id_occupation) ? 'selected="selected"' : ''; ?>
                                        value="<?php echo $occupation->id_occupation;?>"
                                         ><?php echo $occupation->name_occupation; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">Ocupación padre asociada</small>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label  for="digital">Tipo</label>
                                    <select name="digital" id="digital" class="form-control">
                                        <option value="false">No digital</option>
                                        <option 
                                        <?php echo ($position->digital == 't') ? 'selected="selected"' : ''; ?>
                                        value="true">Digital</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="code_job_position">Código</label>
                                    <input type="text" name="code_job_position" class="form-control" id="code_job_position" placeholder="Código" value="<?php echo $position->code_job_position; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea 
                                    name="description" 
                                    id="description" 
                                    class="form-control"
                                    rows="6"><?php echo $position->description; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-success hidden" role="alert"> Puesto de trabajo actualizado correctamente.</div>

                        <a style="color:#fff;margin-right: 10px;" class="btn btn-primary job-position-update">Actualizar</a>
                        <a href="#" class="job-position-delete">Eliminar</a>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
		  	</tbody>
          <?php endif; ?>
		</table>

<?php
			echo '<form style="display: inline" action="" method="post">';
        	echo '<nav >';
    		echo '<ul class="pagination">';
            if ($total_pages > 1) {
                if ($page != 1) {
                    echo '<li class="page-item"><button style="display: inline;" id="start"  name="start"  class="page-link" value="'.($page-1).'"><span aria-hidden="true">&laquo;</span></button></li>';

                }
         
                for ($i=1;$i<=5;$i++) {
                    if ($page == $i) {
                        echo '<li class="page-item active"><button style="display: inline;" class="page-link" href="#">'.$page.'</button></li>';
                    } else {

                    		echo '<li class="page-item"><button style="display: inline;" type="submit" id="start"  name="start"  class="page-link" value="'.$i.'">'.$i.'</button></li>';
           
                    }


                }
             
                if ($page > 5) {
                	echo '<li class="page-item "><button  style="display: inline;" type="submit" id="start"  name="start"  class="page-link" value="'.($page-1).'">...</button></li>';
                	echo '<li class="page-item active"><button  style="display: inline;" type="submit" id="start"  name="start"  class="page-link" value="'.($page).'">'.($page).'</button></li>';
                
                }
                	
               
                if ($page != $total_pages) {


                	
                    echo '<li class="page-item"><button style="display: inline;" class="page-link"  id="start"  name="start" value="'.($page+1).'"><span aria-hidden="true">&raquo;</span></button></li>';
                }
            }
            echo '</ul>';
            echo '</nav>';
            echo '</form>';
        
?>

    <div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
       
          <h4 class="modal-title">Nuevo puesto de trabajo</h4>
        </div>
        <div class="modal-body">
          	<form id="create-form" method="POST">

			<div class="form-group">
				<label for="id_occupation">Selecciona ocupacion padre</label>
			  	<select style="max-width: 49rem;" name="id_occupation" id="id_occupation" class="form-control">
	                <?php foreach($occupations as $occupation): ?>
	                <option <?php echo ($occupation->id_occupation == $position->id_occupation) ?  : ''; ?> value="<?php echo $occupation->id_occupation;?>"><?php echo $occupation->name_occupation; ?></option>
	                <?php endforeach; ?>
	            </select>
	        </div>

	        <div class="form-group">
                <label for="digital">Tipo</label>
                <select  style="max-width: 49rem;"  name="digital" id="digital" class="form-control">
                    <option value="false">No digital</option>
                    <option value="true">Digital</option>
                </select>
            </div>

            <div class="form-group">
			    <label for="code_job_position">Nombre del puesto de trabajo</label>
                <input type="text" name="name_job_position" class="form-control" id="name_job_position" />
			</div>

			<div class="form-group">
			    <label for="code_job_position">Código</label>
                <input type="text" name="code_job_position" class="form-control" id="code_job_position" />
			</div>

			<div class="form-group">
			    <label for="description">Descripcion</label>
			     <textarea 
                   	name="description" 
                   	id="description" 
                   	class="form-control"
                    rows="6"></textarea>
			</div>

			</form>
        </div>
        <div id="create" class="modal-footer">
        	
            <button class="job-position-create btn btn-primary" type="submit" name="submit" data-dismiss="modal">Crear</button>
          <button type="button" class="btn btn-default btn btn-primary"  data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
    </table>

</div>
