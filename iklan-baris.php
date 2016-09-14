<?php
/**
 * Plugin Name: Iklan Baris
 * Description: Iklan Baris help you for optimize SEO and promotion you website.
 * Version: 0.1
 * Text Domain: iklan-baris
 *
 * Code by the WordPress.com CBF team, Dojox00 team, and Pendekar Langit.
 * Author: Pendekar Langit
 * Author URI: http://learningbasicnetwork.blogspot.com
 * License Freeware.
 */

defined('ABSPATH') or die("Fuck accessing!");

    /**
     * Register Appearance" Admin Menu
     */
    function iklan_baris_register_submenu_page() {
        add_theme_page( __( 'Iklan Baris', 'iklan_baris' ), __( 'Iklan Baris', 'iklan_baris' ), 'edit_theme_options', basename( __FILE__ ), 'iklan_baris_render_submenu_page' );
    }
    add_action( 'admin_menu', 'iklan_baris_register_submenu_page' );

    // admin_enqueue_scripts
    function iklan_baris_enqueue_editor_scripts($hook) {

        // Return if the page is not a settings page of this plugin
        if ( 'appearance_page_iklan-baris' != $hook ) {
            return;
        }

        // Style sheet
        wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . 'bootstrap/css/bootstrap.css');
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css');
        // wp_enqueue_style('font-awesome-css', plugin_dir_url(__FILE__) . 'font-awesome/font-awesome.css');
        wp_enqueue_style('admin-lte', plugin_dir_url(__FILE__) . 'dist/css/AdminLTE.css');
        wp_enqueue_style('iklan-baris', plugin_dir_url(__FILE__) . 'css/iklan-baris.css');

        // js
        // wp_enqueue_script('codemirror-js', plugin_dir_url(__FILE__) . 'inc/js/codemirror.js');
        // wp_enqueue_script('css-js', plugin_dir_url(__FILE__) . 'inc/js/css.js');
        wp_enqueue_script('jquery-js', plugin_dir_url( __FILE__ ) . 'plugins/jQuery/jquery-2.2.3/min.js');
        wp_enqueue_script('bootstrap-js', plugin_dir_url( __FILE__ ) . 'bootstrap/js/bootstrap.min.js');

    }
    add_action( 'admin_enqueue_scripts', 'iklan_baris_enqueue_editor_scripts' );

    /**
    * Create database for plugin iklan baris.
    */

    $iklan_baris_db_version = "1.0";

    function iklan_baris_install () {
        global $wpdb;
        global $iklan_baris_db_version;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // initial table name
        $table_name_content = $wpdb->prefix . "iklan_baris_content";
        $table_name_log = $wpdb->prefix . 'iklan_baris_log';
        $table_name_access = $wpdb->prefix . 'iklan_baris_access';

        if($wpdb->get_var("show tables like " . $table_name_content . "") != $table_name_content) {

            $sql = "CREATE TABLE " . $table_name_content . " (
                id_content mediumint(9) NOT NULL AUTO_INCREMENT,
                content_title varchar(255) NOT NULL,
                content_link varchar(255) NOT NULL,
                content_description text NOT NULL,
                PRIMARY KEY (id_content)
            );";

            dbDelta($sql);
        }
        if($wpdb->get_var("show tables like " . $table_name_access . "") != $table_name_access){

            $sql = "CREATE TABLE " . $table_name_access . "(
                id_access mediumint(9) NOT NULL AUTO_INCREMENT,
                api_link varchar(255) NOT NULL,
                api_key varchar(255) NOT NULL,
                PRIMARY KEY (id_access)
            );";
            dbDelta($sql);
       }

        if($wpdb->get_var("show tables like " . $table_name_log . "") != $table_name_log){

            $sql = "CREATE TABLE " . $table_name_log . " (
                id_log mediumint(9) NOT NULL AUTO_INCREMENT,
                id_content mediumint(9) NOT NULL,
                click smallint(5) NOT NULL,
                PRIMARY KEY (id_log)
            );";
            dbDelta($sql);
       }

       
    }
    register_activation_hook(__FILE__, 'iklan_baris_install');

    // When deactivation
    function iklan_baris_uninstall(){
        global $wpdb;

        // initial table name
        $table_name_content = $wpdb->prefix . "iklan_baris_content";
        $table_name_log = $wpdb->prefix . 'iklan_baris_log';
        $table_name_access = $wpdb->prefix . 'iklan_baris_access';

        //Delete any options thats stored also?
        delete_option($iklan_baris_db_version);

        $wpdb->query("DROP TABLE IF EXISTS " . $table_name_content . "");
        $wpdb->query("DROP TABLE IF EXISTS " . $table_name_log . "");
        $wpdb->query("DROP TABLE IF EXISTS " . $table_name_access . "");

    }

    register_deactivation_hook( __FILE__, 'iklan_baris_uninstall' );

    //  inc calling; 
    // for plugin admin 
    require_once( plugin_dir_path( __FILE__ ) . 'inc/iklan_baris_function.php' );
    // for plugin widget
    require_once( plugin_dir_path( __FILE__ ) . 'inc/iklan_baris_widget.php');
    // for api
    require_once( plugin_dir_path( __FILE__ ) . 'inc/api/iklan_baris_api.php');

    /**
    * Notice for success installation and recomended to relogin for make api key
    */
    /*function iklan_baris_install_success() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Done!. Please relogin to make api key.', 'sample-text-domain' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'iklan_baris_install_success' ); */