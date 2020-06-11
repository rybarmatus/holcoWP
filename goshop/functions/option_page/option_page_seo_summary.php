<?php
$blog_articles = new WP_Query([
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'suppress_filters' => true
]);
if ( $blog_articles->have_posts() ) {
    $posts = $blog_articles->posts;
    $keywords = '';
?>

<div class="wrap">
    <h1>SEO SUMMARY</h1>
    <br><br>
  <table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <th width="30px">#</th>
        <th style="width:100px;text-align:center;">Thumb</th>
        <th>Post Title</th>
        <th>SEO Title</th>
        <th>SEO Desc</th>
        <th>Excerpt</th>
        <th>Keywords</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($posts as $item){ 
      $keywords = '';
      ?>
        <tr>
          <td><?= $item->ID; ?></td>
          <td>
            <?php
            $image = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'thumbnail' );
            ?>
            <img src="<?= $image[0] ?>" style="width:50px;height:auto" alt="<?= $item->post_title; ?>" />
          </td>
          <td><?= $item->post_title; ?></td>
          <td><?= custom_get_title($item); ?></td>
          <td><?= custom_get_description($item); ?></td>
          <td><?= $item->post_excerpt; ?></td>
          <td><?php $keywords_array = get_the_tags($item->ID); if(!empty($keywords_array)) { foreach ( $keywords_array as $tag){ $keywords .= $tag->name.', '; } echo $keywords = substr_replace($keywords ,"", -2);  } ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php } ?>

<?php  

function custom_get_title($post){
    if($field = get_field('meta_tag_title', $post->ID)){
        $title = $field;
    }else{
        $title = $post->post_title;    
    }   
    return $title. ' | '.$_SERVER['HTTP_HOST']; 
}


function custom_get_description($post){
  if ($field = get_field('meta_tag_description', $post->ID)){    
      return $field;
  }else if( !empty($post->post_excerpt) ){
      return $post->post_excerpt;
  }else {    
      if($post and !empty($post->post_content)){
        $content = apply_filters('the_content', $post->post_content);
        return wp_trim_words($content, 26);
      }
      return ''; 	
  }
}