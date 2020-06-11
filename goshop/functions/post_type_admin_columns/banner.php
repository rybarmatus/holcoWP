<?php
add_filter( 'manage_edit-banner_columns', 'edit_banner_columns' ) ;
  
  function edit_banner_columns( $columns ) {
  
  	$columns = array(
  		'cb' => '<input type="checkbox" />',
  		'title' => __( 'Názov banneru' ),
  		'image' => __( 'Image' ),
  		'zobrazit_od' => __( 'Zobraziť od' ),
      'zobrazit_do' => __( 'Zobraziť do' ),
  		'status' => __( 'Status' ),
      'date' => __( 'Date' )
  	);         
  
  	return $columns;
  }
  
  add_action( 'manage_banner_posts_custom_column', 'my_manage_banner_columns', 10, 2 );
  
  function my_manage_banner_columns( $column, $post_id ) {
  	global $post;
  
  	switch( $column ) {
  
  		case 'image' :
              $image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail-80' );
              if($image){
                echo '<img style="width:80px;" src="'.$image[0].'" />';
              }
              break;
              
          case 'zobrazit_od' :
              if($zobrazit_od = get_field('zobrazit_od', $post_id)){
                  echo date('d.m.Y', strtotime($zobrazit_od));
              }else{
                  echo '--';
              }	
  			break;
          case 'zobrazit_do' :
          	if($zobrazit_do = get_field('zobrazit_do', $post_id)){
                  echo date('d.m.Y', strtotime($zobrazit_do));
              }else{
                  echo '--';
              }
            	break;
          case 'status' :
              $status = true;
              $today = strtotime('today');
              if($zobrazit_od = get_field('zobrazit_od', $post_id)){
                 if(strtotime($zobrazit_od) >= $today){
                      $status = false;
                 } 
              }
              if($zobrazit_do = get_field('zobrazit_do', $post_id)){
                  if(strtotime($zobrazit_do) <= $today){
                      $status = false;
                  }
              }
              if($status){
                  echo '<span style="background-color:green;padding:5px;color:white;margin-top:25px;display:inline-block">ON</span>';
              }else{
                  echo '<span style="background-color:red;padding:5px;color:white;margin-top:25px;display:inline-block">OFF</span>';
              }
                    	
            	break;
          		
  		default :
  			break;
  	}
  }
  