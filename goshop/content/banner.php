<?php 

$banners = get_transient( 'banners' );

if( false === $banners ) {

  $today = date('Ymd');
  $args = array(
  'post_type' => 'banner',
  'post_status' => 'publish',
  'orderby' => 'menu_order',
  'order' => 'ASC',
  'numberposts' => -1,
  'meta_query' => array(
  	    'relation' => 'AND',
        array(
      		'relation' => 'OR',
      		array(
      			'key'     => 'zobrazit_od',
      			'compare' => '=',
                'value' => ''
            ),
              array(
      		   'key'		=> 'zobrazit_od',
  	           'compare'	=> '<=',
  	           'value'		=> $today,
      		)
       ),
       array(
      		'relation' => 'OR',
      		array(
      			'key'     => 'zobrazit_do',
      			'compare' => '=',
                'value' => ''
            ),
            array(
      		    'key'		=> 'zobrazit_do',
      	        'compare'	=> '>=',
      	        'value'		=> $today,
      		)
       ),
  	),
  );
  
  $banners = get_posts( $args );
  
  if( ! empty( $banners ) ) {
      set_transient( 'banners', $banners, 6000 );
  }

} 
?>

<div class="slick-homepage-banner">
  <?php
  foreach($banners as $post){
  ?>
    <div class="slick-item" title="<?= $post->post_title ?>">
      <?php
      if(isset($post->ID)){ 
        if(isset($post->ID) and $href = get_field('preklik',$post->ID)) { ?>
          <a href="<?= $href ?>" <?php if(get_field('otvorit_na_novej_karte',$post->ID)){ echo 'target="_blank"'; } ?>>
        <?php } ?>
        <?php if($thumb_id = get_post_thumbnail_id($post->ID)){ ?>
          <img class="d-block w-100" src="<?= wp_get_attachment_url( $thumb_id ) ?>" alt="<?= $post->post_title ?>">
        <?php } ?>
        <?php if(isset($post->ID) and $href){ ?>
          </a>
        <?php } ?>
        <?php
        } 
        ?>
    </div>
    <?php
    }
    ?>
</div>