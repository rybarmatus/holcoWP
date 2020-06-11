<?php 
get_header();
$scheme_post = $post;
$clanok_id = get_the_ID();
$kategoria = get_the_category()[0];
$schema_image = $image = wp_get_attachment_image_src( get_post_thumbnail_id($clanok_id), 'large' );
$content = $scheme_post->post_content;

require(CHILD_CONTENT.'/single.php');

addPostOpenCount($clanok_id);

$comments = get_comments();

?>
<script type="application/ld+json">
{ 
 "@context": "https://schema.org", 
 "@type": "Article",
 "@id": "<?= THIS_PAGE_URL ?>",
 "headline": "<?= $scheme_post->post_title ?>",
 "description": "<?= DESC ?>",
 "isAccessibleForFree": "True",
 "articleBody": "<?= str_replace('"', '', strip_shortcodes(wp_strip_all_tags($content))); ?>",
 "image": {
    "@type": "ImageObject",
    "url": "<?= $schema_image[0] ?>",
    "width": "<?= $schema_image[1] ?>",
    "height": "<?= $schema_image[2] ?>" 
 },
 "author": {
    "@type": "Organization",
    "name": "<?= $_SERVER['HTTP_HOST']; ?>"
 },
 "genre": "<?= $kategoria->name ?>", 
 "wordCount": "<?= str_word_count( strip_tags( $content ) ) ?>",
 "inLanguage": "<?= LANG; ?>",
 "commentCount" : <?= $scheme_post->comment_count; ?>,
 "comment" : [
    <?php foreach($comments as $key=>$item){ ?>
    {
      <?php if($item->comment_karma >= 0) { ?>
      "upvoteCount" : "<?= $item->comment_karma?>",
      "downvoteCount" : "0",
      <?php } else { ?>
      "upvoteCount" : "0",
      "downvoteCount" : "<?= $item->comment_karma?>",
      <?php } ?>
      "text" : "<?= $item->comment_content ?>",
      "author" : {
          "@type": "Person",
          "name": "<?= $item->comment_author ?>"
      }
    }<?php if(isset($comments[$key+1])) { echo ','; } ?>   
    <?php } ?>
 ],
 "aggregateRating" : {
    "@type": "AggregateRating",
    "ratingValue": "<?= get_post_meta($clanok_id, 'post_rating_score', true) ?>",
    "ratingCount": "<?= get_post_meta($clanok_id, 'post_rating_count', true) ?>"
 },
 "publisher": {
    "@type": "Organization",
    "name": "<?= $_SERVER['HTTP_HOST']; ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?= get_option('option_header_logo'); ?>"
     
    }
 },
 "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?= get_site_url() ?>"
 },
 "url": "<?= THIS_PAGE_URL ?>",
 "datePublished": "<?= date('Y-m-d', strtotime($scheme_post->post_date)); ?>",
 "dateCreated": "<?= date('Y-m-d', strtotime($scheme_post->post_date)); ?>",
 "dateModified": "<?= get_the_modified_date( 'Y-m-d' ); ?>"
 }
</script>
<?php get_footer(); ?>
<script>
add_post_view_count(<?= $clanok_id; ?>);
</script>
