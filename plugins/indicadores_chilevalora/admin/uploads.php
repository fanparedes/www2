
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

<?php if (!current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.')); 

	
?>
<?php if ( empty( $_FILES ) ): ?>
	<?php 
	global $wpdb;
	//$tipo_archivo = $_POST["tipo_archivo"];
	//var_dump($tipo_archivo);
	// Use ls command to shell_exec 
	// function 
	//$output = shell_exec('ls'); 
	// Display the list of all file 
	// and directory 
	//echo "<pre>$output</pre>"; 
	
	?> 
<?php

$tipo_carga = isset($_POST['tipo_archivo']) && $_POST['tipo_archivo'] != '' ? strtolower($_POST['tipo_archivo']) : '';
//var_dump($tipo_carga);

$calculo = isset($_POST['calculo_indicador']) && $_POST['calculo_indicador'] != '' ? strtolower($_POST['calculo_indicador']) : '';
//var_dump($calculo);







?>

<div class="container col-md-12">
 	<h3 class="text-center">Subir archivo para carga masiva</h3>
<table class="data-table table table-striped">
        <thead>
            <tr>
                <th width="130%"></th>
            </tr>
        </thead>
   <tbody>

  <tr class="col-md-12">
 
	    <form action="" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('csv-import'); ?>
   
   	<td>
    <label for="file">Seleccione Archivo:</label>
   	</td>	
   	<td>
    
        <input type="file" name="file" id="file">		
    </td>

    <td>    
     
		<label>&nbsp;&nbsp;&nbsp; Tipo de carga:</label>
        <select id="tipo_archivo_carga" name="tipo_archivo"> 
        	<option value="carga_afc">Carga masiva AFC</option> 
        	<option value="carga_casen">Carga masiva CASEN</option> 
        	<!-- <option value="carga_telefonica">Carga masiva telefonica</option>  -->
        	<option value="carga_afc_dicc">Carga masiva diccioanrio de datos AFC</option> 
        	<option value="carga_enadel">Carga masiva ENADEL</option> 
        </select>
        
 		<input type="submit"  class="btn btn-primary" id="save"  name="save" value="Cargar">
		
		
  	</td>
  	</tr>	
  	<tr style="align-content: center;">
  			<td>
<?php


if ($calculo == 'calculo_carga_casen') {

$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_Casen_Ind.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";
}





 if ($calculo == 'etl_afc_indicadores') {
$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Indicadores.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

		
echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}




if ($calculo == 'etl_afc_indicadores_generales') {


$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Indicadores_Generales.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador etl_afc_indicadores_generales se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}
if ($calculo == 'etl_afc_migrantes_regiones') {


$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Migrantes_regiones.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}
if ($calculo == 'etl_afc_mujeres_regiones') {
$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Mujeres_regiones.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}
if ($calculo == 'etl_afc_ocupados_regiones') {
$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Ocupados_regiones.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}
if ($calculo == 'etl_afc_cont_indef_nacional') {
$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Cont_Indef_nacional.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}

if ($calculo == 'etl_afc_cont_indef_regional') {
$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_AFC_Cont_Indef_regional.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";

}

if ($calculo == 'calculo_enadel') {

$path = get_template_directory() ."/data-integration/pan.sh";
$file = get_template_directory() ."/KTRFiles/ETL_enadel_ind.ktr";
$exec = $path." /file:".$file." /level:Basic";
$resultado_etl = shell_exec($exec);	

echo"<form action='' method='post'>";
echo "<h4>El calculo del indicador ENADEL se ha realizado correctamente</h4>";
echo"<input type='text' hidden='true' value='nueva_afc' id='tipo_archivo_carga' name='tipo_archivo'>";
echo "<input type='button' value='TERMINAR' id='terminar' name='terminar'class='btn btn-danger'>";
//echo "<input type='submit'  class='btn btn-primary' id='save'  name='save' value='CALCULAR OTRO INDICADOR'></form>";
}


?>


	</td>
  	</tr>
  	<tr>
  	</tr>
  	<tr>
  	</tr>
	</form> 
	</tbody>
	</table>


<?php else: 
   	
	if ( ! function_exists( 'wp_handle_upload' ) ){	 
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}	
/*
	$uploadedfile = $_FILES['file'];

	$exten = $_FILES['file']['type'];

	if($exten == 'application/vnd.ms-excel'){

	$upload_overrides = array( 'test_form' => false,'unique_filename_callback' => 'my_cust_filename' );
	//Modificar el filtro de uploads para subir archivos a carpeta personalizada
	
	add_filter( 'upload_dir', 'set_etl_upload_path' );
	//add_filter( 'unique_filename_callback', 'set_name' );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	//Restaurar filtro
	remove_filter( 'upload_dir', 'set_etl_upload_path' );
	
	}
	if($exten =! 'application/vnd.ms-excel'){

		echo"<div class='col-md-12'>";
		echo"<div class='col-md-5'>";
		echo "<h4>El formato del archivo no está permitido.</h4>";
		echo"</div>";
		echo"<div class='col-md-6'>";
		echo "<input type='button' value='VOLVER' id='volver' name='volver'class='btn btn-chilevalora btn-block col-md-2'>";
		echo "</div>";
		echo "</div>";

	}
	*/

	
	$tipo_carga = isset($_POST['tipo_archivo']) && $_POST['tipo_archivo'] != '' ? strtolower($_POST['tipo_archivo']) : '';    
	//var_dump($tipo_carga);
	

		if ($tipo_carga == 'nueva_afc') {


		?>

		<h3 class="text-center">Calcular indicadores</h3>


	
<table class="data-table table table-striped">
        <thead>
            <tr>
                <th width="60%">Indicadores AFC</th>
                <th width="40%"></th>
            </tr>
        </thead>
	<tbody>

		 <tr>
		 	<td>
			<label>PORCENTAJE DE MUJERES A NIVEL NACIONAL</label> <br>
			<label>Sector a la baja en % contratos indefinidos (Nacional)</label> <br>
			<label>Sector a la baja Numero Ocupados (Nacional)</label> <br>
			<label>Sector al alza en % contratos indefinidos (Nacional)</label> <br>
			<label>Sector al alza Numero de Ocupados (Nacional)</label> <br>
			<label>Sector mayor porcentaje de migrantes (Nacional)</label> <br>
			<label>Sector mayor porcentaje de mujeres (Nacional)</label> <br>
			<label>Sector menor porcentaje de migrantes (Nacional)</label> <br>
			<label>Sector menor porcentaje de mujeres (Nacional)</label> <br>
			<label>XX% Rotación (Nacional)</label> <br>
		  	</td>
		  	 <form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_indicadores" name="calculo_indicador">
			  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>

		<tr>
		 	<td>
		  	<label>PORCENTAJE POBLACIÓN ACTIVA A NIVEL REGIONAL</label> <br>
		  	<label>PORCENTAJE DE MUJERES TOTALES A NIVEL REGIONAL</label> <br>
		   	</td>
		  	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_indicadores_generales" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>

		<tr>
		 	<td>
		  	<label>Sector mayor porcentaje de migrantes (Regional)</label> <br>
		  	</td>
		 	 <form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_migrantes_regiones" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>


		<tr>
		 	<td>
		  	<label>Sector mayor porcentaje de mujeres (Regional)</label> <br>
		  	</td>
		 	 <form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_mujeres_regiones" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>



		<tr>
		 	<td>
		  	<label for="file">Sector al alza Numero de Ocupados (Regional)</label> <br>
		  	<label for="file">Sector a la baja Numero Ocupados (Regional)</label> <br>
		  	</td>
		 	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_cont_indef_nacional" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>	 

		<tr>
		 	<td>
			<label>PORCENTAJE DE CONTRATOS INDEFINIDOS  A NIVEL REGIONAL</label> <br>
			<label>XX% de Contratos Indefinidos (Nacional)</label> <br>

		  	</td>
		 	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_ocupados_regiones" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>	

		<tr>
		 	<td>
			<label>Sector a la baja en % contratos indefinidos (Regional)</label> <br>
			<label>Sector al alza en % contratos indefinidos (Regional)</label> <br>

		  	</td>
		 	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_cont_indef_regional" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>	
		
	

			
	</tbody>




		<?php



		}




	 	if($tipo_carga == 'carga_afc' ){

	 		$uploadedfile = $_FILES['file'];

	$exten = $_FILES['file']['type'];

	if($exten == 'application/vnd.ms-excel'){

	$upload_overrides = array( 'test_form' => false,'unique_filename_callback' => 'my_cust_filename' );
	//Modificar el filtro de uploads para subir archivos a carpeta personalizada
	
	add_filter( 'upload_dir', 'set_etl_upload_path' );
	//add_filter( 'unique_filename_callback', 'set_name' );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	//Restaurar filtro
	remove_filter( 'upload_dir', 'set_etl_upload_path' );
	
		

		$path = get_template_directory() ."/data-integration/pan.sh";
		$file = get_template_directory() ."/KTRFiles/carga_afc.ktr";
		
		$exec = $path." /file:".$file." /level:Basic";
		$resultado_etl = shell_exec($exec);		
			
		
	    global $wpdb;
	    $results = $wpdb->get_results("SELECT * FROM cl_registros_erroneos WHERE tipo_carga = 'carga_afc' ORDER BY id_reg DESC", OBJECT);
	    
	    //var_dump($results);

	    $cuenta = count($results);

	    

	    ?>
	 	<h3 class="text-center">Carga AFC realizada satisfactoriamente</h3>
	 	<h4> Tienes <?php echo $cuenta ?> errores <button data-toggle="collapse" class="btn btn-primary" data-target="#demo">Ver</button></h4>

	 	<div id="demo" class="collapse">

    <table class="data-table nopagination table table-striped">
        <thead>
            <tr>
                <th width="50%">Registro </th>
                <th width="50%">Tipo de error</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($results as $result): 
            //$origen->url = admin_url('admin.php').'?page=indicadores_chilevalora/admin/origen_datos.php&origen='.$origen->origin;
            ?>
            <tr>
                <td><?php echo'Error en la línea '.substr($result->registro,1,10)?></td>
                <td><?php echo'Registro nulo'?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

	<h3 class="text-center">Calcular indicadores</h3>


	
<table class="data-table table table-striped">
        <thead>
            <tr>
                <th width="60%">Indicadores AFC</th>
                <th width="40%"></th>
            </tr>
        </thead>
		<tbody>

		 <tr>
		 	<td>
			<label>PORCENTAJE DE MUJERES A NIVEL NACIONAL</label> <br>
			<label>Sector a la baja en % contratos indefinidos (Nacional)</label> <br>
			<label>Sector a la baja Numero Ocupados (Nacional)</label> <br>
			<label>Sector al alza en % contratos indefinidos (Nacional)</label> <br>
			<label>Sector al alza Numero de Ocupados (Nacional)</label> <br>
			<label>Sector mayor porcentaje de migrantes (Nacional)</label> <br>
			<label>Sector mayor porcentaje de mujeres (Nacional)</label> <br>
			<label>Sector menor porcentaje de migrantes (Nacional)</label> <br>
			<label>Sector menor porcentaje de mujeres (Nacional)</label> <br>
			<label>XX% Rotación (Nacional)</label> <br>
		  	</td>
		  	 <form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_indicadores" name="calculo_indicador">
			  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>

		<tr>
		 	<td>
		  	<label>PORCENTAJE POBLACIÓN ACTIVA A NIVEL REGIONAL</label> <br>
		  	<label>PORCENTAJE DE MUJERES TOTALES A NIVEL REGIONAL</label> <br>
		   	</td>
		  	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_indicadores_generales" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>

		<tr>
		 	<td>
		  	<label>Sector mayor porcentaje de migrantes (Regional)</label> <br>
		  	</td>
		 	 <form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_migrantes_regiones" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>


		<tr>
		 	<td>
		  	<label>Sector mayor porcentaje de mujeres (Regional)</label> <br>
		  	</td>
		 	 <form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_mujeres_regiones" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>



		<tr>
		 	<td>
		  	<label for="file">Sector al alza Numero de Ocupados (Regional)</label> <br>
		  	<label for="file">Sector a la baja Numero Ocupados (Regional)</label> <br>
		  	</td>
		 	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_cont_indef_nacional" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>	 

		<tr>
		 	<td>
			<label>PORCENTAJE DE CONTRATOS INDEFINIDOS  A NIVEL REGIONAL</label> <br>
			<label>XX% de Contratos Indefinidos (Nacional)</label> <br>

		  	</td>
		 	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_ocupados_regiones" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>	

		<tr>
		 	<td>
			<label>Sector a la baja en % contratos indefinidos (Regional)</label> <br>
			<label>Sector al alza en % contratos indefinidos (Regional)</label> <br>

		  	</td>
		 	<form action="" method="post">
			<input type="text" hidden="true" value="etl_afc_cont_indef_regional" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>	
		
	

			
	</tbody>



<?php

	
}else{
		echo"<div class='col-md-12'>";
		echo"<div class='col-md-5'>";
		echo "<h4>El formato del archivo no está permitido.</h4>";
		echo"</div>";
		echo"<div class='col-md-6'>";
		echo "<input type='button' value='VOLVER' id='volver' name='volver'class='btn btn-chilevalora btn-block col-md-2'>";
		echo "</div>";
		echo "</div>";

	}

}


if ($tipo_carga == 'carga_casen') {
				
	$uploadedfile = $_FILES['file'];

	$exten = $_FILES['file']['type'];

	if($exten == 'application/vnd.ms-excel'){

	$upload_overrides = array( 'test_form' => false,'unique_filename_callback' => 'my_cust_filename' );
	//Modificar el filtro de uploads para subir archivos a carpeta personalizada
	
	add_filter( 'upload_dir', 'set_etl_upload_path' );
	//add_filter( 'unique_filename_callback', 'set_name' );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	//Restaurar filtro
	remove_filter( 'upload_dir', 'set_etl_upload_path' );
	
	//var_dump($movefile);die;

		$path = get_template_directory() ."/data-integration/pan.sh";
		$file = get_template_directory() ."/KTRFiles/carga_casen.ktr";
		
		$exec = $path." /file:".$file." /level:Basic";
		$resultado_etl = shell_exec($exec);	
			
		#echo $resultado_etl;
		
		
	    global $wpdb;
	    $results = $wpdb->get_results("SELECT * FROM cl_registros_erroneos WHERE tipo_carga = 'carga_casen' ORDER BY id_reg DESC", OBJECT);
	    
	    //var_dump($results);

	    $cuenta = count($results);

	    

	    ?>
	 	<h3 class="text-center">Carga realizada satisfactoriamente</h3>
	 	<h4> Tienes <?php echo $cuenta ?> errores <button data-toggle="collapse" class="btn btn-primary"data-target="#demo">Ver</button></h4>

	 	<div id="demo" class="collapse">

    <table class="data-table nopagination table table-striped">
        <thead>
            <tr>
                <th width="50%">Registro </th>
                <th width="50%">Tipo de error</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($results as $result): 
            //$origen->url = admin_url('admin.php').'?page=indicadores_chilevalora/admin/origen_datos.php&origen='.$origen->origin;
            ?>
            <tr>
                <td><?php echo'Error en la línea '.substr($result->registro,1,10)?></td>
                <td><?php echo'Registro nulo'?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


	     <h3 class="text-center">Calcular indicadores</h3>

<table class="data-table table table-striped">
        <thead>
            <tr>
                <th width="60%">Indicadores CASEN</th>
                <th width="40%"></th>
            </tr>
        </thead>
	<tbody>

		<tr>
		  	<td><label for="file">Ranking Porcentaje más ocupados</label></td>
		  	<td></td>
		</tr>

		<tr>
		  	<td><label for="file">Porcentaje de contratos indefinidos</label></td>
		  	<td></td>
		</tr>
		
		<tr>
		  	<td><label for="file">Mediana Salarial</label></td>
		  	<td></td>
		</tr>
		
		<tr>
		  	<td><label for="file">Participación distintos sectores</label></td>
		  	<form action="" method="post">
			<input type="text" hidden="true" value="calculo_carga_casen" name="calculo_indicador">
		  	<td><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>
		
		<tr>
		  	<td><label for="file">Tasa de cremiento (Top 5 Mayores)</label></td>
		  	<td>
		  	</td>
		</tr>
		
		<tr>
		  	<td><label for="file">Tasa de cremiento (Top 1 Menor)</label></td>
		  	<td>
		  	</td>
		</tr>
		
		<tr>
		  	<td><label for="file">Porcentaje mujeres</label></td>
		  	<td>
		  	</td>
		</tr>
		
	</tbody>

</table>




<?php

}else{
		echo"<div class='col-md-12'>";
		echo"<div class='col-md-5'>";
		echo "<h4>El formato del archivo no está permitido.</h4>";
		echo"</div>";
		echo"<div class='col-md-6'>";
		echo "<input type='button' value='VOLVER' id='volver' name='volver'class='btn btn-chilevalora btn-block col-md-2'>";
		echo "</div>";
		echo "</div>";

	}


}
if ($tipo_carga == 'carga_telefonica') {



				
		$path = get_template_directory() ."/data-integration/pan.sh";
		$file = get_template_directory() ."/KTRFiles/carga_telefonica.ktr";
		
		$exec = $path." /file:".$file." /level:Basic";
		$resultado_etl = shell_exec($exec);	
			
		//echo $resultado_etl; 
		}

		if ($tipo_carga == 'carga_afc_dicc') {
				

		$path = get_template_directory() ."/data-integration/pan.sh";
		$file = get_template_directory() ."/KTRFiles/carga_afc_dicc.ktr";
		
		$exec = $path." /file:".$file." /level:Basic";
		$resultado_etl = shell_exec($exec);	
			
		//echo $resultado_etl; 
		}




	if ($tipo_carga == 'carga_enadel') {

		$uploadedfile = $_FILES['file'];

	$exten = $_FILES['file']['type'];

	if($exten == 'application/vnd.ms-excel'){

	$upload_overrides = array( 'test_form' => false,'unique_filename_callback' => 'my_cust_filename' );
	//Modificar el filtro de uploads para subir archivos a carpeta personalizada
	
	add_filter( 'upload_dir', 'set_etl_upload_path' );
	//add_filter( 'unique_filename_callback', 'set_name' );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	//Restaurar filtro
	remove_filter( 'upload_dir', 'set_etl_upload_path' );	

				

		$path = get_template_directory() ."/data-integration/pan.sh";
		$file = get_template_directory() ."/KTRFiles/carga_enadel.ktr";
		
		$exec = $path." /file:".$file." /level:Basic";
		
		//var_dump($exec);die;

		$resultado_etl = shell_exec($exec);	
			
		//echo $resultado_etl; 


		   global $wpdb;
	    $results = $wpdb->get_results("SELECT * FROM cl_registros_erroneos WHERE tipo_carga = 'carga_enadel' ORDER BY id_reg DESC", OBJECT);
	    
	    //var_dump($results);

	    $cuenta = count($results);

	    

	    ?>
	 	<h3 class="text-center">Carga ENADEL realizada satisfactoriamente</h3>
	 	<h4> Tienes <?php echo $cuenta ?> errores <button data-toggle="collapse" class="btn btn-primary"data-target="#demo">Ver</button></h4>

	 	<div id="demo" class="collapse">

    <table class="data-table nopagination table table-striped">
        <thead>
            <tr>
                <th width="50%">Registro </th>
                <th width="50%">Tipo de error</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($results as $result): 
            //$origen->url = admin_url('admin.php').'?page=indicadores_chilevalora/admin/origen_datos.php&origen='.$origen->origin;
            ?>
            <tr>
                <td><?php echo'Error en la línea '.substr($result->registro,1,10)?></td>
                <td><?php echo'Registro nulo'?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


	     <h3 class="text-center">Calcular indicadores</h3>

<table class="data-table table table-striped">
        <thead>
            <tr>
                <th width="60%">Indicadores ENADEL</th>
                <th width="40%"></th>
            </tr>
        </thead>
	<tbody>

		<tr>
		 	<td>
			<label>Ocupaciones más difíciles de llenar por puesto de trabajo- Nacional</label> <br>
			<label>Ocupaciones más difíciles de llenar por puesto de trabajo -Regional</label> <br>
			<label>Dificultades para llenar vacantes de los puestos de trabajo</label> <br>
			<label>Dificultades para llenar vacantes de los puestos de trabajo por región</label> <br>
			<label>Habilidades o competencias buscadas en una ocupación</label> <br>
			<label>Habilidades o competencias buscadas en una ocupación por región</label> <br>
			<label>Canales de reclutamiento por ocupación</label> <br>
			<label>Canales de reclutamiento por ocupación por región</label> <br>
			</td>
		  	 <form action="" method="post">
			<input type="text" hidden="true" value="calculo_enadel" name="calculo_indicador">
			  	<td colspan="8" style="vertical-align: middle;"><button type="submit"   class="btn btn-chilevalora btn-block"> Calcular</button></td>
		  	</form>
		</tr>
		
	
	</tbody>


<?php
		}

	}else {
			 //echo "No ejecutó la ETL";
		}	
		
endif;






	
	?> 

</div>


<script>
  function calcular(){
    alert('Cálculo realizado correctamente');
   
    location.reload();
    
  }


  $("#terminar").on("click",function(event){
    location.reload();

 }); 


  $("#volver").on("click",function(event){
  window.history.back();

 });
</script>



<?php
 function accion(){
  
		$path = get_template_directory() ."/data-integration/pan.sh";
		$file = get_template_directory() ."/KTRFiles/ETL_Casen_Ind.ktr";
		
		$exec = $path." /file:".$file." /level:Basic";
		$resultado_etl = shell_exec($exec);	
    
   }
 ?>
