<?php
/**                                                                                                                                                               
* Template Name: Vyrobcovia
*/

get_header(); ?>


<?php $manufacturers = get_terms( 'manufacturers', array(
    'hide_empty' => false,
));
?>
<div class="container">
  <div class="row">
    <?php if($manufacturers) { ?>
      <?php foreach($manufacturers as $manufacturer){ ?>
          <div class="col-md-2 text-center">
              <a href="<?= get_term_link($manufacturer) ?>" title="<?= __('Zobraziť výrobcu'); ?>">
                <?php $image = wp_get_attachment_image_src( get_field('image', $manufacturer), 'thumbnail');?>
                <img class="lazy" src="<?= LOADER ?>" data-src="<?= $image[0] ?>" width="<?= $image[1] ?>" height="<?= $image[2] ?>" alt="<?= $manufacturer->name ?>">
                <div><?= $manufacturer->name ?></div>
              </a>  
          </div>
      <?php } ?>
    <?php } ?>  
  </div>
</div>
    
    
https://www.hudysport.sk/znacky

<?php get_footer();
