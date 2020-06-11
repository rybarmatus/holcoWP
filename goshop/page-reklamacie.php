<?php
/**                                                                                                                                                               
Template Name: Reklamacie
*/

get_header();
?>

<div class="container">
    <h1><?= get_the_title(); ?></h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        the_content();
        endwhile; endif;
    ?>

    <div class="row mt-5">
        <div class="col-md-6 col-xl-5">
            <h2><?= __('Reklamačný formulár', 'goshop'); ?></h2>
            <?= do_shortcode('[contact-form-7 id="184" title="Reklamačný formulár"]'); ?>
        </div>
        <div class="col-md-6 col-xl-7 kontakt_page">
            <h2><?= __('Kontaktné informácie', 'goshop'); ?></h2>
                <div class="kontaktne_info">
                  <?php if($adresa = get_option('option_adresa')){ ?>
                    <div class="item">
                        <span>
                            <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="map-marker-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><g><path fill="currentColor" d="M192 0C86 0 0 86 0 192c0 77.41 27 99 172.27 309.67a24 24 0 0 0 39.46 0C357 291 384 269.41 384 192 384 86 298 0 192 0zm0 288a96 96 0 1 1 96-96 96 96 0 0 1-96 96z" class="fa-secondary"></path><path fill="currentColor" d="M192 256a64 64 0 1 1 64-64 64 64 0 0 1-64 64z" class="fa-primary"></path></g></svg>
                        </span>
                        <strong><?= __('Adresa','goshop') ?>:</strong> <?= $adresa; ?>
                    </div>
                  <?php } ?>
                  <div class="item">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"/></svg>
                    </span>    
                    <strong><?= __('Tel. kontakt', 'goshop') ?>:</strong> <a href="tel:<?= get_option('option_tel_kontakt'); ?>"><?= get_option('option_tel_kontakt'); ?></a>
                  </div>
                  <div class="item">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"/></svg>
                    </span>      
                    <strong><?= __('E-mail', 'goshop') ?>:</strong> <a href="mailto:<?= get_option('option_e_mail'); ?>"><?= get_option('option_e_mail'); ?></a>
                  </div>
                </div>
                <?php if($company = get_option('option_company')) { ?>
                    <div class="row mt-3">
                      <div class="col-md-6">
                          <h4><?= __('Fakturačné údaje'); ?></h4>
                          <div><?= $company; ?></div>  
                          <div><?= get_option('option_adresa'); ?></div>   
                          <?php if($ico = get_option('option_ico')) { ?>
                          <div>IČO: <?= $ico; ?></div>
                          <?php } ?>   
                          <?php if($dic = get_option('option_dic')) { ?>
                          <div>DIČ: <?= $dic; ?></div>   
                          <?php } ?>
                          <?php if($ic_dph = get_option('option_ic_dph')) { ?>
                          <div>IČ DPH: <?= $ic_dph; ?></div>
                          <?php } ?>
                      </div>
                   </div>   
                  <?php } ?>
              </div>
            </div>
        </div>
    </div>        

</div>

<?php get_footer(); 
