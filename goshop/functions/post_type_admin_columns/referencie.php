<?php
add_filter( 'manage_edit-referencie_columns', 'edit_referencie_columns' ) ;
  
  function edit_referencie_columns( $columns ) {
  
  	$columns = array(
  		'cb' => '<input type="checkbox" />',
  		'title' => __( 'Názov' ),
  		'obsah' => __( 'Obsah' ),
       'image' => __( 'Image' ),  
  		'date' => __( 'Date' )
  	);         
  
  	return $columns;
  }
  
  add_action( 'manage_referencie_posts_custom_column', 'edit_referencie_columns_content', 10, 2 );
  
  function edit_referencie_columns_content( $column, $post_id ) {
  	global $post;
  
  	switch( $column ) {
  
  		case 'image' :
              $image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail-50' );
              echo '<img style="width:60px;" src="'.$image[0].'" />';
              break;
              
          case 'obsah' :
              echo $post->post_excerpt;
  		
                   		
  		default :
  			break;
  	}
  }