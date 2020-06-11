<?php
/**                                                                                                                                                               
* Template Name: Homepage
*/

get_header(); ?>



<div class="container">
  <?php require(CONTENT. '/banner.php'); ?>
</div>






<?php if($last_seen = getCookieValue('viewed_products', 2, true)){ ?>
<section class="mt-5">
    <div class="container">
        <h2>Naposledy zobrazené produkty</h2>
        <?= do_shortcode('[products ids="'.$last_seen.'" orderby="post__in" limit="4"]'); ?>
    </div>
</section>
<?php } ?>

<section class="mt-5">
    <div class="container">
        <h2><?= __('Najpredávanejšie produkty', 'goshop'); ?></h2>
        <?= do_shortcode('[products best_selling="true" limit="4"]'); ?>
    </div>
</section>

<section class="mt-5">
    <div class="container">
        <h2><?= __('Produkty v zľave', 'goshop'); ?></h2>
        <?= do_shortcode('[products on_sale="true" limit="4"]'); ?>
    </div>
</section>

<section class="mt-5">
    <div class="container">
        <h2><?= __('Novinky', 'goshop'); ?></h2>
        <?= do_shortcode('[products orderby="date" limit="4"]'); ?>
    </div>
</section>


<section class="mt-5">
    <div class="container">
        <h2><?= __('Výrobcovia', 'goshop'); ?></h2>
        <?php $manufacturers = get_terms( 'manufacturers', array(
            'hide_empty' => false,
        ));
        ?>
        <div class="row">
            <div class="col-md-2 mt-mobile-1 text-center order-mobile-2">
                <a title="<?= __('Zobraz všetkých výrobcov', 'goshop'); ?>" href="/vyrobcovia"><?= __('Zobraz všetkých výrobcov', 'goshop'); ?></a>
            </div>
            <?php if($manufacturers) { ?>
              <?php foreach($manufacturers as $manufacturer){ ?>
                  <div class="col-2 mb-1 text-center order-mobile-1">
                      <a href="<?= get_term_link($manufacturer) ?>" title="<?= __('Zobraziť výrobcu'); ?>">
                        <?php $image = wp_get_attachment_image_src( get_field('image', $manufacturer), 'thumbnail-50');?>
                        <img class="lazy" src="<?= NO_IMAGE; ?>" data-src="<?= $image[0] ?>" width="50" alt="<?= $manufacturer->name ?>">
                        <div><?= $manufacturer->name ?></div>
                      </a>
                  </div>
              <?php } ?>
            <?php } ?>
        </div>
        
    </div>   
</section>

<?php get_footer();
