<?php
add_filter( 'manage_edit-post_columns', 'edit_post_columns' ) ;
  
  function edit_post_columns( $columns ) {
  
  	$columns = array(
  		'cb' => '<input type="checkbox" />',
  		'title' => __( 'Názov' ),
  		'excerpt' => __( 'Zhrnutie' ),
        'image' => __( 'Image' ),
        'stars' => __( 'Hodnotenie' ),
        'categories' => __( 'Kategórie' ),
        'views' => '<span class="dashicons dashicons-visibility"></span>',
        'comments' => '<span class="comment-grey-bubble"></span>', //__( 'Počet komentárov' ),
  		'date' => __( 'Date' )
  	);         
  
  	return $columns;
  }
  
 add_action( 'manage_post_posts_custom_column', 'edit_post_columns_content', 10, 2 );
  
  function edit_post_columns_content( $column, $post_id ) {
  	global $post;
  
  	switch( $column ) {
  
  		case 'image' :
              $image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail-50' );
              echo '<img style="width:60px;" src="'.$image[0].'" />';
              break;
              
        case 'excerpt' :
              echo $post->post_excerpt;
              break;
        
        case 'views' :
              echo getPostViews($post_id);
              echo 'x';
              break;
  		
        case 'stars' :
            echo getPostStars($post_id);
            break;
                   		
  		default :
  			break;
  	}
  }
  
  add_action('admin_head', 'my_custom_fonts');

  function my_custom_fonts() { ?>
    <style>
      .star-rating svg{
      width:15px;
      }
      .star-rating svg.full, .star-rating svg.half-star{
      color:#ffd300;
      }
      .star-rating svg.empty{
      color:#cdcdcd;
      }
      .star-rating svg.empty:nth-of-type(1){
      margin-left: -3px;
      }
    </style>
  <?php } ?>
