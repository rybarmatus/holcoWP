<?php

$terms = get_the_terms( $product_id, 'product_cat' );
if(!empty($terms[0])){  
    $poradca = get_field('poradca',$terms[0]);
}

if($poradca) { ?>
<div class="product_advisor_wrapper mt-2">
  <div class="row">
      <div class="col-3 text-center border-right">
          <p><img class="w-max-100" src="<?= get_the_post_thumbnail_url($poradca); ?>" title="<?= $poradca->post_title; ?>" alt="<?= $poradca->post_title; ?>"></p>    
          <?= $poradca->post_title; ?>
      </div>
      <div class="col-9">
          <strong><?= __('Potrebujete poradiť?', 'goshop'); ?></strong>
          <p><?= __('Opýtajte sa priamo na tento produkt.', 'goshop'); ?></p>
          <div class="float-left">
            <a class="icon-wrapper" title="<?= __('Telefónne číslo', 'goshop'); ?>" href="tel:<?= get_field('tel_cislo', $poradca); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" class="svg-inline--fa fa-phone fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path></svg>
            <?= get_field('tel_cislo', $poradca); ?></a>
          </div>
          <div class="float-right icon-wrapper">
            <span class="js-modal pointer" data-modal=".ask_advisor">
              <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"></path></svg>
              <?= get_field('e-mail', $poradca); ?></a>
            </span>
          </div>
          <div class="clear"></div>
          <button class="mt-1 btn btn-small btn-primary js-modal" data-modal=".ask_advisor"><?= __('Spýtať sa na produkt', 'goshop'); ?></button>
      </div>
  </div>
</div>
<div class="modal ask_advisor">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <?= __('Potrebujete poradiť?', 'goshop') ?>
          <button type="button" class="close js-modal-close pointer">
            <span aria-hidden="true">×</span>
          </button>
      </div>
      <div class="modal-body">
         <?= do_shortcode('[contact-form-7 id="208" title="Spýtať sa na produkt"]'); ?>
      </div>
      <div class="modal-footer">
          <button class="js-modal-close pointer"><?= __('Zavrieť', 'goshop'); ?></button>
      </div>
    </div>
  </div>
</div>


<?php } ?>
