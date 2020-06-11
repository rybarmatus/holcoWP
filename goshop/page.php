<?php get_header(); ?>

<?php if( IS_CHECKOUT ){ ?>

     <div class="checkout_wrapper pt-2 pb-2">
       <div class="container">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              the_content();
              endwhile; endif;
          ?>
      </div>
    </div>

    <?php if($goshop_config['zasielkovna_api']){ ?>
        <div class="packeta-selector-open"></div>
        <script>
        var packetaCountry = 'sk';
        var packetaWidgetLanguage = 'sk';
        </script>
        <script src="https://widget.packeta.com/www/js/packetaWidget.js" data-api-key="<?= $goshop_config['zasielkovna_api'] ?>"></script>
    <?php } ?>

    <?php
    if($goshop_config['cetelem']){
        include( CONTENT . '/cetelem-modal.php');
    }
    ?>

<?php }else if(IS_CART) { ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
    the_content();
    endwhile; endif;
    ?>
    
<?php }else{ ?>
    
  <div class="container">
      <h1><?= get_the_title(); ?></h1>
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
          the_content();
          endwhile; endif;
      ?>
  </div>

<?php } ?>

<?php
get_footer(); 
