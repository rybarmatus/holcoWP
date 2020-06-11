<?php
add_filter( 'manage_edit-poradca_columns', 'edit_poradca_columns' ) ;
  
  function edit_poradca_columns( $columns ) {
  
  	$columns = array(
  		'cb' => '<input type="checkbox" />',
  		'title' => __( 'Názov banneru' ),
  		'image' => __( 'Image' ),  
  		'tel_cislo' => __( 'Tel. číslo' ),
      'e_mail' => __( 'E-mail' ),
  		'date' => __( 'Date' )
  	);         
  
  	return $columns;
  }
  
  add_action( 'manage_poradca_posts_custom_column', 'edit_poradca_columns_content', 10, 2 );
  
  function edit_poradca_columns_content( $column, $post_id ) {
  	global $post;
  
  	switch( $column ) {
  
  		case 'image' :
              $image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail-80' );
              echo '<img style="width:60px;" src="'.$image[0].'" />';
              break;
              
          case 'tel_cislo' :
              if($tel_cislo = get_field('tel_cislo', $post_id)){
                  echo $tel_cislo;
              }else{
                  echo '--';
              }	
  			break;
          case 'e_mail' :
          	if($email = get_field('e-mail', $post_id)){
                  echo $email;
            }else{
                echo '--';
            }
           break;
                   		
  		default :
  			break;
  	}
  }
  