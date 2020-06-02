<?php
    /**
    * Plugin Name: Indicadores Chilevalora
    * Plugin URI: https://www.chilevalora.cl
    * Description: Este plugin permite activar o desactivar indicadores para Chilevalora
    * Version: 1.0.0
    * Author: Daniela Venegas, Victor Briceño
    * License: GPL2
    */

    defined('ABSPATH') or die("Bye bye");
    
    add_action('init', 'chilevalora_session', 1);
    function chilevalora_session() {
        if( ! session_id() ) {
            session_start();
        }
    }
    //var_dump(plugin_dir_path(__FILE__)); die;
    define('IND_RUTA',plugin_dir_path(__FILE__));
    include(IND_RUTA.'includes/options.php');
    include(IND_RUTA.'admin/indicator_ajax_afc.php');
    include(IND_RUTA.'admin/indicator_ajax_casen.php');
    include(IND_RUTA.'admin/indicator_ajax_ft.php');
    include(IND_RUTA.'admin/indicator_query.php');
    include(IND_RUTA.'admin/indicator_ajax_enadel.php');

?>
