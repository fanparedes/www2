<?php
    global $wpdb;
    $results = $wpdb->get_results('SELECT * FROM cl_indicator_sections ORDER BY id_indicator_section DESC', OBJECT);
    $url_imagen = wp_upload_dir();

?>

<div class="container">
    
    <h3 class="text-center">Listado de indicadores</h3>

    <table class="data-table nopagination table table-striped">
        <thead>
            <tr>
                <th width="80%">Indicador</th>
                <th width="20%"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($results as $result): 
            //$origen->url = admin_url('admin.php').'?page=indicadores_chilevalora/admin/origen_datos.php&origen='.$origen->origin;
            ?>
            <tr>
                <td><?php echo $result->name_indicator_section; ?></td>
                <td><a href="<?php echo admin_url('admin.php') . '?page=indicadores_chilevalora/admin/create_ind.php&ind=' . $result->id_indicator_section ; ?>" class="btn btn-chilevalora btn-block">Ver Indicador</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
   

</div>
