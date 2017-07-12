<?php if( !class_exists( 'config' ) ) 
{   
    class config 
    {
         public static $name        = "Monitoring";
         public static $icon        = "wp-monitoring/assets/images/Tools_-_common_fixed-14-16.png";
         public static $plugin_slug = 'wp_monitoring';
         public static $folder      = 'wp-monitoring';
         public static $shortcode   = 'wp_monitoring';
         public static $assets      = 'assets';
         
         protected $values          = array();

         public static $tbls = array( 'table1' => '_monitoring' );
        
         function __construct() 
         {
                global $wpdb;
                
                add::action_page( array( $this, 'admin_page' ) );
                
                /** backend style ( admin ) **/
                 
                add::style( true, self::$plugin_slug.__( 'admin-style', 'wp-raffle' ), self::$folder.'/'.self::$assets.'/css/admin.css' );
                
                
                /** frontend style ( front ) **/
                
                add::style( false, self::$plugin_slug.__( 'front-style', 'wp-raffle' ), self::$folder.'/'.self::$assets.'/css/front.css' );
                
                /** backend script **/
                
                add::wp_script( 'jquery' );
                add::wp_script( 'jquery-ui-sortable' );
                add::wp_script( 'jquery-ui-draggable' );
                add::wp_script( 'jquery-ui-droppable' );
                
                add::wp_script( 'jquery-ui-core' );
                add::wp_script( 'jquery-ui-dialog' );
                add::wp_script( 'jquery-ui-slider' );
                
                add::script( true, self::$plugin_slug.'admin-script', self::$folder.'/'.self::$assets.'/js/admin.js' );
                add::script( true, self::$plugin_slug.'sort-script', self::$folder.'/'.self::$assets.'/js/sort.js' );
                
                add::script( true, self::$plugin_slug.'ajax_handler', self::$folder.'/'.self::$assets.'/js/ajax.js' );
                add::localize_script( true, self::$plugin_slug.'ajax_handler', 'ajax_script', self::get_localize_script_arrays() );
                add::admin_scripts( array( $this, 'admin_scripts_handler' ) );
                
                add::action_submit( 1, array( $this, 'form_submit_handler' ) );
                add::action_submit( 1, array( $this, 'form_submit_update_handler' ) );
                add::action_submit( 1, array( $this, 'form_delete_handler' ) );
                add::action_submit( 1, array( $this, 'form_delete_multi_handler' ) );

                /** frontend script  **/
                
                add::script( false, self::$plugin_slug.'front-script', self::$folder.'/'.self::$assets.'/js/front.js' );
                
                /** actions option ( callback ) **/
                
                add::action_loaded( array( $this,'update_db_check' ) );
                
                /** actions shortcode ( callback ) **/
                
                add::shortcode( self::$shortcode, array( $this, self::$shortcode.'_shortcode' ) );
                add_filter('widget_text','do_shortcode');
                
                /** actions ajax actions ( callback ) **/
              
                add::action_ajax( array( $this, 'ajaxs_handler' ) ); 

                /** actions widget ( create ) **/
                
                add::widget_init( array( $this, 'register_widgets' ) );
         }
         
         public static function get_localize_script_arrays () 
         {
                return array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'admin_url' => admin_url() );   
         }
         
         public static function install () 
         {
                global $wpdb;
                    
                $tbl = $wpdb->prefix . __( '_monitoring','wp-mvc' );
                    
                $charset_collate = $wpdb->get_charset_collate();
                    
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

                $sql_1 = "CREATE TABLE `{$tbl}` (
                  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                  `title` varchar(120) NOT NULL,
                  `image` text,
                  `sub_title` varchar(120) NOT NULL,
                  `sub_title_two` varchar(120) NOT NULL,
                  `status` varchar(120) NOT NULL,
                  `desc` text
                ) {$charset_collate};"; 

                $sqls = array( $sql_1 );
                
                if( isset( $sqls ) and is_array( $sqls ) ) foreach( $sqls as $sql ) : 
                        
                dbDelta( $sql ); 

                endforeach;
                
                self::dbDelta_alters( array( $tbl ) );
                
         }
         
        public static function dbDelta_alters ( $tbls=array() ) 
        {
            global $wpdb;
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            
            if( is_array( $tbls ) ) : foreach( $tbls as $tbls_keys => $tbls_res ) :
                $alts = null;  
                dbDelta( $alts ); 
            endforeach; 

            endif;  
        }

        public function admin_scripts_handler ( ) 
        {
            add::wp_media( true );   
        }

        public function form_submit_handler () 
        {
            action::form_action_insert();
        }

        public function form_submit_update_handler () 
         {
             action::form_action_update();
         }

        public function form_delete_handler () 
         {
             action::form_action_delete();
         }
         
        public function form_delete_multi_handler() 
         {
            action::form_action_delete_multi();
         }
         
         /**
            WP register widgtet
         **/
         
        public function register_widgets () 
        {
            register_widget( 'Add_Widget' );
        }

        // END
    }    
    
}
?>