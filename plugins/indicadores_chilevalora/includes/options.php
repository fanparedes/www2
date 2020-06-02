<?php

    add_action( 'admin_menu', 'ind_options_page' );

    function ind_options_page() {
        add_menu_page(
            'Indicadores',
            'Indicadores Chilevalora',
            'manage_options',        
            IND_RUTA . 'admin/configuration.php',
            null,
            plugin_dir_url(__FILE__) . 'images/uno.png',
            20
        );
    }


    add_action( 'admin_menu', 'ind_options_puestos' );

    function ind_options_puestos() {
        add_menu_page(
            'Puestos de trabajo',
            'Puestos de trabajo',
            'manage_options',        
            IND_RUTA . 'admin/job_positions.php',
            null,
            plugin_dir_url(__FILE__) . 'images/uno.png',
            20
        );
    }

    add_action( 'admin_menu', 'ind_options_carga' );

    function ind_options_carga() {
        add_menu_page(
            'Carga masiva',
            'Carga masiva',
            'manage_options',        
            IND_RUTA . 'admin/uploads.php',
            null,
            plugin_dir_url(__FILE__) . 'images/uno.png',
            20
        );
    }

    add_action('admin_menu', 'ind_submenu_administrador' );

    function ind_submenu_administrador(){

      //  add_submenu_page(IND_RUTA . 'admin/configuration.php','Carga masiva','Carga masiva','manage_options' , IND_RUTA . 'admin/uploads.php', null, 24);

       // add_submenu_page(IND_RUTA . 'admin/configuration.php','Puestos de trabajo','Puestos de trabajo','manage_options' , IND_RUTA . 'admin/job_positions.php', null, 23);

        add_submenu_page(IND_RUTA . 'admin/configuration.php','Añadir indicador','','manage_options' , IND_RUTA . 'admin/create_ind.php', null, 25);
       
    }
    

    add_action( 'admin_enqueue_scripts', 'my_enqueue_script' );

    function my_enqueue_script( $hook ) {

        wp_enqueue_style( 'indicadores-chilevalora-style', get_template_directory_uri() . '/css/bootstrap.min.css');

        wp_enqueue_style( 'datatables', plugin_dir_url(dirname(__FILE__)) . 'css/datatables.min.css'); 
        wp_enqueue_style( 'main-chilevalora-style', plugin_dir_url(dirname(__FILE__)) . 'css/main.css?v003'.time()); 

        wp_enqueue_script( 'datatables-script',
            plugins_url( '../js/datatables.min.js', __FILE__ ),
            array( 'jquery' )
        );
      
        wp_enqueue_script( 'ajax-script',
            plugins_url( '../js/scripts.js?v003'.time(), __FILE__ ),
            array( 'jquery' )
        );

        $indicador_nonce = wp_create_nonce( 'indicador' );

        wp_localize_script('ajax-script', 'ajax_var', array(
            'url' => admin_url('/admin-ajax.php'),
            
        )); 


    }

    add_action( 'wp_ajax_get_types_indicator', 'get_types_indicator' );

    function get_types_indicator() {
        global $wpdb;
        check_ajax_referer( 'indicador' );
        
        if(isset($_POST['id'])){
            $result = $wpdb->get_results('SELECT * FROM cl_indicator_type where id_indicator_section = '.$_POST['id'].'', OBJECT);
        }

        // $response = update_ind($_POST['id'], $estatus);
        echo json_encode($result);
        wp_die();
    }

    function update_ind($id, $status){
        global $wpdb;
        $respuesta = $wpdb->update( 'cl_indicators', 
            // Datos que se remplazarán
            array( 
                'status' => $status
            ),
            // Cuando el ID del campo es igual al número 1
            array( 'id_indicator' => $id )
        );

        return $respuesta;
    }
    //Registrar URL para subida de archivos de la ETL
    function set_etl_upload_path( $dir ) {

        return array(
            'path'   => '/var/www/html/wordpress/wp-content/themes/chilevalora/KTRFiles',
            'url'    => '/var/www/html/wordpress/wp-content/themes/chilevalora/KTRFiles',
         
        ) + $dir;
        
        // return array(
        //     'path'   => get_template_directory() . '/KTRFiles',
        //     'url'    => get_template_directory() . '/KTRFiles',
         
        // ) + $dir;
        
        
        
        // return array(
        //     'path'   => '/var/www/html/wordpress/wp-content/themes/chilevalora/KTRFiles',
        //     'url'    => '/var/www/html/wordpress/wp-content/themes/chilevalora/KTRFiles',
         
        // ) + $dir;
        
        
    }
 

function my_cust_filename($dir, $name, $ext){
 
 // $tipo_carga = $_POST['tipo_carga'];
 
$tipo_carga = isset($_POST['tipo_archivo']) && $_POST['tipo_archivo'] != '' ? strtolower($_POST['tipo_archivo']) : '';    

  //var_dump($tipo_carga);die;

    $name = $tipo_carga;
    return $name.$ext;

    + $dir + $name + $ext;
}

 
?>



