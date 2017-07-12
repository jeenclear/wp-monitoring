<?php if( ! class_exists( 'action' ) ) 
{
    
     class action extends db_action
     {
          
          // action event submit - tickets
          // user the querys at the top
          
          public static function form_action_insert () 
          {
              global $wpdb;

              $prefix = $wpdb->prefix;

              $inputs = input::post_is_object();
              
              $title = $inputs->title;
              $image= $inputs->image;
              $sub_title = $inputs->sub_title;
              $sub_two = $inputs->sub_two;
              $status = $inputs->status;
              $desc = $inputs->desc;

              
              $validate[] = self::form_action_empty_validate( 'title', 'empty' );
              $validate[] = self::form_action_empty_validate( 'image', 'empty' );
              $validate[] = self::form_action_empty_validate( 'sub_title', 'empty' );
              $validate[] = self::form_action_empty_validate( 'sub_two', 'empty' );
              $validate[] = self::form_action_empty_validate( 'status', 'empty' );

              if( isset( $inputs->submit_monitor ) ) 
              {
                
                if( ! in_array( false, $validate ) ) 
                {
                
                  self::inserts( config::$tbls['table1'],  
                                     array( 'title' => $title, 'image' => $image, 'sub_title' => $sub_title, 'sub_title_two' => $sub_two, 'status' => $status, 'desc' => $desc  ), 
                                     array( '%s', '%s', '%s', '%s', '%s', '%s' ) 
                  );

                  $page = page_rounter::url( 'manage_wp_monitoring', false );

                  redirect::filter( $page );

                }
              }
          }

        public static function form_action_update () 
          {
              global $wpdb;

              $prefix = $wpdb->prefix;
              $inputs = input::post_is_object();
              $get = input::get_is_object();
              
             $title = $inputs->title;
              $image= $inputs->image;
              $sub_title = $inputs->sub_title;
              $sub_two = $inputs->sub_two;
              $status = $inputs->status;
              $desc = $inputs->desc;
              
              $validate[] = self::form_action_empty_validate( 'title', 'empty' );
              $validate[] = self::form_action_empty_validate( 'image', 'empty' );
              $validate[] = self::form_action_empty_validate( 'sub_title', 'empty' );
              $validate[] = self::form_action_empty_validate( 'sub_two', 'empty' );
              $validate[] = self::form_action_empty_validate( 'status', 'empty' );

              if( isset( $inputs->submit_update_monitor ) ) 
              {
                
                if( ! in_array( false, $validate ) ) 
                {
                
                  self::updates( config::$tbls['table1'],  
                                     array( 'title' => $title, 'image' => $image, 'sub_title' => $sub_title, 'sub_title_two' => $sub_two, 'status' => $status, 'desc' => $desc  ), 
                                     array( 'id' => $get->modify ), 
                                     array( '%s', '%s', '%s', '%s', '%s', '%s' ), 
                                     array( '%d' )
                  );

                  $page = page_rounter::url( 'manage_wp_monitoring', false );

                  redirect::filter( $page );

                }
              }
          }

          public static function form_action_empty_validate ( $key=null, $type=null )
          {
              $inputs = input::post_is_array();

              if( isset( $inputs[$key] ) AND $type == 'empty' ) 
              {
                 $value = ! empty( $inputs[$key] ) ? true : false;
              } else {
                 $value = null; 
              }

              return $value;        
          }

           public static function form_action_delete () 
          {
              $get = input::get_is_object();
              
              self::deletes( config::$tbls['table1'], array( 'id' => $get->delete ), array( '%d' ));
          } 

          public static function form_action_delete_multi () 
          {
              $inputs = input::post_is_object();
             
             if( isset( $inputs->delete_pl_pd_opp ) ) 
              { 
                if( is_array( $inputs->delete_selected ) ) 
                {

                  $check_selected = $inputs->delete_selected;
                  
                  foreach( $check_selected as $checked) {
                    
                    self::deletes(config::$tbls['table1'], array( 'id' => $checked ), array( '%d' ));

                  }

                } 

              }
               
          } 
          
     }
}
?>