<?php

    if (!current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

    global $wpdb;

    $origen = $wpdb->get_results("SELECT * FROM cl_data_origins WHERE origin = '".$_GET['origen']."'", OBJECT);
    
    if(!empty($origen)){

        $indicadores = $wpdb->get_results("SELECT * FROM cl_indicator_sections WHERE id_data_origin = '".$origen[0]->id_data_origin."' ORDER BY id_indicator_section", OBJECT);
    }
  
?>

<div class="container-fluid">

    <div class="wrap">

        <h1 class="wp-heading">Secciones de Indicadores de <?php echo $origen[0]->origin; ?>
        <a href="http://localhost/wordpress/wp-admin/media-new.php" class="page-title-action aria-button-if-js" role="button" aria-expanded="false">Volver</a></h1>
        <hr>
        
        <div class="row m-2" id="section_ind">

            <?php foreach ($indicadores as $key => $indicador): ?>

                <div class="alert alert-success d-flex justify-content-between col-12" role="alert">
                    <p class="h3 text-warning"><?php echo $indicador->name_indicator_section?></p>
                    <p class="lead float-right">
                        <a href="<?php echo admin_url('admin.php') . '?page=indicadores_chilevalora/admin/create_ind.php&ind=' . $indicador->id_indicator_section . '&name=' . $indicador->name_indicator_section . '&orig_id=' . $indicador->id_data_origin; ?>" class="btn btn-info text-white" id="<?php echo $indicador->id_indicator_section ?>" data-indsection="<?php echo 'section_' . $indicador->id_indicator_section; ?>" >Ver indicadores asociados</a>
                    </p>
                </div>

            <?php endforeach; ?>

        </div><!-- /row -->

    </div><!-- /wrap -->

</div><!-- /container-fluid -->
