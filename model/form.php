<?php if( !class_exists( 'form' ) or die ( 'error found.' ) ) 
{    
    class form extends input
    {
          public static $tbls = array( 'table1' => '_monitoring' );   

          public function __construct() 
          {
               parent::__construct();
          }

          public static function custom_slider_form_holder ( $key=null ) 
          {
            $inputs = input::post_is_array();
            return isset ( $inputs[$key] ) ? $inputs[$key] : null;
          }

          public static function custom_slider_form_validate ( $key=null, $type=null )
          {
            $inputs = input::post_is_array();
            
            $error_image = array(
                      "title"  => array ( 
                          'empty' => "Empty fields detected. " . __( $key ) 
                        ),        
                      "image" => array ( 
                          'empty' => "Empty fields detected. " .__( $key )
                        ) ,
                      "sub_title" => array ( 
                          'empty' => "Empty fields detected. " .__( $key )
                        ),
                      "sub_two" => array ( 
                          'empty' => "Empty fields detected. " .__( $key )
                        ),
                      "status" => array ( 
                        'empty' => "Please choose status. " .__( $key )
                      )               
                    );
            
            if( isset( $error_image[$key][$type] ) AND $type == 'empty' ) 
            {
             $value = empty( $inputs[$key] ) ? $error_image[$key][$type] : null;
            } else {
             $value = false; 
            }

            return $value;    
          } 

          public static function wp_monitoring_form () 
          {
            $html = null;
            $inputs = input::post_is_array();
            $gets = input::get_is_object();
            
            $submit = empty( $gets->modify ) ? 'submit_monitor' : 'submit_update_monitor';
            $submit_value = empty( $gets->modify ) ? 'Save' : 'Update';

            if( isset( $inputs[ $submit ] ) ) :
              
            foreach( $inputs as $key => $value ) :

                $html .= "<p class='error'>";
                $html .= self::custom_slider_form_validate( $key, 'empty' );
                $html .= "</p>";
            
            endforeach;

            endif;

                $is_where = 'WHERE id=' . __( $gets->modify ) ;
                $select = db::query( config::$tbls['table1'], false, $is_where, false);

            if( !is_array( $select ) ) {

                $title = $select->title;
                $image = $select->image;
                $sub_title = $select->sub_title;
                $sub_two = $select->sub_title_two;
                $status = $select->status;
                $desc = $select->desc;

            }

            $title_con = empty( $gets->modify ) ? self::custom_slider_form_holder( 'title' ) : $title;
            $image_con = empty( $gets->modify ) ? self::custom_slider_form_holder( 'image' ) : $image;
            $sub_title = empty( $gets->modify ) ? self::custom_slider_form_holder( 'sub_title' ) : $sub_title;
            $sub_two = empty( $gets->modify ) ? self::custom_slider_form_holder( 'sub_two' ) : $sub_two; 
            $status = empty( $gets->modify ) ? self::custom_slider_form_holder( 'status' ) : $status;
            $desc_con = empty( $gets->modify ) ? self::custom_slider_form_holder( 'desc' ) : $desc;

            $html .= '<p>';
            $html .= html::label( array('text' => 'Title:') );
            $html .= self::text( array('name'=> 'title', 'value'=> $title_con, 'id'=> 'title', 'class'=>'' ) );
            $html .= '</p>';

            $html .= '<div class="form-uploadimage__wrap">';
            $html .= '<a href="#" id="upload-img">Upload</a><a href="#" id="remove-img">x</a>';
            $html .= '<img src="'. $image_con .'" id="images-src" />';

            $url = plugins_url('widget-gallery/assets/images/icon-image-64.png');
            $html .= '<div class="no-image"></div>';
            $html .= self::hidden( array('name'=> 'image', 'value'=> $image_con, 'id'=> 'images-input', 'class'=>'' ) );
            $html .= '</div>';

            $html .= '<p>';
            $html .= html::label( array('text' => 'Sub Title:') );
            $html .= self::text( array('name'=> 'sub_title', 'value'=> $sub_title, 'id'=> 'sub_title', 'class'=>'' ) );
            $html .= '</p>';

            $html .= '<p>';
            $html .= html::label( array('text' => 'Sub Title Two:') );
            $html .= self::text( array('name'=> 'sub_two', 'value'=> $sub_two, 'id'=> 'sub_two', 'class'=>'' ) );
            $html .= '</p>';

            $html .= '<p>';
            $html .= html::label( array('text' => 'Status:') );
            $html .= html::select( array('name'=> 'status', 'class'=>'' ), array( 1 => 'Ongoing', 2 => 'Complete'), $status );
            $html .= '</p>';

            $html .= '<p>';
            $html .= html::label( array('text' => 'Description:') );
            $html .= html::textarea( array('name'=> 'desc', 'text'=> $desc_con, 'class'=>'customslider-textarea' ) );
            $html .= '</p>';

            $html .= '<p>';
            $html .= self::submit( array('name'=> $submit, 'value'=> $submit_value, 'text'=> '', 'class'=>'' ) );
            $html .= '</p>';
            
            return $html;
          }

          public static function table_tr_label ( $label=array() ) {

            if( is_array($label)){
                    
                    $i = 0;
                    foreach($label as $label_key => $label_var ){
                    $i++;

                    if( is_string($label[$label_key]) ){  
                
                        $html .= '<th class="label label_counter'.$i.'"><label>'. $label[$label_key] . '</label></th>';
               
                    }
                 }
              }

              return $html;

          }

          public static function wp_monitoring_list ()
          {
              
              $checkbox = self::checkbox( array('name'=> 'delete_selected[]', 'value'=> intval( $list->id ), 'id'=> 'delete_selected', 'class'=>'delete_selected' ) );

              $html .= null;
              $html .= '<div class="wp-manage__wrap">';

              $html .= '<div class="wp-manage__option">';
              
              $html .= '<div class="wp-manage__deleteall">Check All'. self::checkbox( array('name'=> 'delete_all', 'value'=> '', 'id'=> 'delete_all', 'class'=>'delete_all' ) )  .'</div>';
              $html .= '<div class="wp-manage__deletesubmit">'. self::submit( array('name'=> 'delete_pl_pd_opp', 'value'=> 'Delete', 'id'=> 'delete_submit', 'class'=>'delete-by-checked' ) )  .'</div>';
              $html .= '<div class="wp-manage__addnew"><a href="'. page_rounter::url( 'wp_monitoring', '' ) .'" class="page-title-action">Add New</a></div>';
              
              $html .= '</div>';

              $html .= '<table id="list-table" class="wp-manage__list wp-list-table widefat fixed striped">';

              $html .= '<thead>';
              $html .= '<tr>';
              $html .= self::table_tr_label( array( 'Check', 'Title', 'Image', 'Sub Title', 'Sub Title Two', 'Status', '--', '--') );
              $html .= '</tr>';
              $html .= '</thead>';

              
              $select = db::query( config::$tbls['table1'], true, '', array( 'id' => 'DESC' ));

              $html .= '<tbody>';
            
              foreach( $select as $list ) {

                $html .= '<tr>';

                $html .= '<th class="manage-column column-cb check-column">'. self::checkbox( array('name'=> 'delete_selected[]', 'value'=> intval( $list->id ), 'id'=> 'delete_selected', 'class'=>'delete_selected' ) ) .'</th>';
                $html .= '<td class="title column-title has-row-actions column-primary">' . $list->title . '<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button></td>';
                $html .= '<td class="manage-image manage_entry"><img src="'. $list->image .'" height="50" width="50" alt="slider-image"/></td>';
                $html .= '<td class="manage-subtitle manage_entry">' . $list->sub_title . '</td>';
                $html .= '<td class="manage-subtitle manage_entry">' . $list->sub_title_two . '</td>';

                if( $list->status == '2' ) {
                  $status_label = 'Complete';
                  $status_color = 'status_green';
                }else{
                  $status_label = 'Ongoing';
                  $status_color = 'status_red';
                }

                $html .= '<td class="manage-status manage_entry"><span class="'. $status_color .'">' . $status_label . '</span></td>';

                $delete = page_rounter::url( 'manage_wp_monitoring', array( 'delete' => intval( $list->id ) ) ); 
                $html .= '<td class="manage_delete manage_entry"><a href="'. __( $delete ) .'">Delete</a></td>';

                $modify = page_rounter::url( 'wp_monitoring', array( 'modify' => intval( $list->id ) ) );  
                $html .= '<td class="manage_edit manage_entry"><a href="'. __( $modify ) .'">Edit</a></td>';

                $html .= '</tr>';

              }

              $html .= '</tbody>';
              $html .= '</table>';

              return $html;
          }

          public static function wp_monitoring_help () {

            $html .= null;
            $html .= '<p>Steps:</p>';
            $html .= '<p>1. To add data just go to this page <a href="'. page_rounter::url( 'wp_monitoring', '' ) .'">Click Here</a></p>';
            $html .= '<p>2. To Manage data just go to this page <a href="'. page_rounter::url( 'manage_wp_monitoring', '' ) .'">Click Here</a></p>';
            $html .= '<p>3. Add this code on your page content, text widget or any type of content display <code>[wp_monitoring]</code></p>';
            $html .= '';

            return $html;

          }
    }
}
?>