<?php if( !class_exists( 'events_objects' ) ) 
{    
    class page_objects 
    {
        public static function template () 
        {
            $html .= null;
            $html .= '<div class="wp-monitoring__wrap">';
            $html .= '<div class="wp-monitoring__pad">';

            $i = 1;
            $select = db::query( config::$tbls['table1'], true, '', array( 'id' => 'DESC' ));

            $html .= '<div class="wp-monitoring__column">';
            foreach( $select as $list ) {

            	if( $list->status == '2' ) {
            		$status_label = 'status_complete';
            	}else{
            		$status_label = 'status_label';
            	}
            	
            	$html .= '<div class="wp-monitoring__entry">';

            	$html .= '<div class="wp-monitoring__img">';
            	$html .= '<img src="'. $list->image .'" alt="'. $list->title .'" title="'. $list->title .'"/>';
            	$html .= '<div class="wp-monitoring__title">'. $list->title .'</div>';
            	$html .= '<div class="wp-monitoring__info '. $status_label .'"><span>'. $list->sub_title .'</span> - <span>'. $list->sub_title_two .'</span></div>';
            	$html .= '</div>';
      
            	$html .= '</div>';

            	if($i % 3 == 0) {  
            		$html .= '</div><div class="wp-monitoring__column">';
            	}

				$i++;

            }	

            $html .= '</div>';
            $html .= '</div>';
            
            return $html;
            
        }       
    }
}
?>