<nav class="desctop-navbar d-mobile-none">
  <div class="container">
    <div class="row">
        <div class="col-md-3">
          <a class="navbar-brand d-inline-block" href="<?= home_url(); ?>" title="<?= __('Domov', 'goshop'); ?>">
            <?php if($logo = get_option('option_header_logo')) { ?>
              <span class="logo-helper"></span>
              <img src="<?= $logo ?>" title="<?= __( 'Domov' ); ?>" alt="<?= get_site_url(); ?> logo">
            <?php } ?>
          </a>
        </div>
        <div class="col-md-6 text-center menu-items">
            <div class="h5"><?= __('Nakupný proces', 'goshop'); ?></div>
        </div>
        <?php if(!is_order_received_page()){ ?>
        <div class="col-md-3 text-right menu-items continue-shopping">
          <small>
            <a href="/" title="<?= __('pokračovať v nákupe', 'goshop'); ?>">
                <?= __('pokračovať v nákupe', 'goshop'); ?>
                <svg style="width: 17px;margin-top: 9px;position: relative;top: 5px;right: -7px;" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="arrow-alt-to-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-arrow-alt-to-right fa-w-14 fa-3x"><path fill="currentColor" d="M32 217.1c0-8.8 7.2-16 16-16h144v-93.9c0-7.1 8.6-10.7 13.6-5.7l143.5 143.1c6.3 6.3 6.3 16.4 0 22.7L205.6 410.4c-5 5-13.6 1.5-13.6-5.7v-93.9H48c-8.8 0-16-7.2-16-16v-77.7m-32 0v77.7c0 26.5 21.5 48 48 48h112v61.9c0 35.5 43 53.5 68.2 28.3l143.6-143c18.8-18.8 18.8-49.2 0-68L228.2 78.9c-25.1-25.1-68.2-7.3-68.2 28.3v61.9H48c-26.5 0-48 21.6-48 48zM436 64h-8c-6.6 0-12 5.4-12 12v360c0 6.6 5.4 12 12 12h8c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12z" class=""></path></svg>
            </a>
          </small>    
        </div>
        <?php } ?>
    </div>
  </div>
</nav>
  
<div class="checkout_steps text-center">
    <div class="container">
      <div class="checkout_steps_item cart d-inline-block <?php if(IS_CART){ echo 'active'; } ?>">
        <a class="d-block" title="<?= __('Nákupný košík','goshop'); ?>" href="<?= wc_get_cart_url(); ?>">
          <div class="circle">1</div>
          Košík
        </a>
      </div>
      <div class="checkout_steps_item checkout d-inline-block <?php if(IS_CHECKOUT and !is_order_received_page()){ echo 'active'; } ?>">
        <div class="circle">2</div>    
        <?= __('Pokladňa', 'goshop'); ?>
      </div>
      <div class="checkout_steps_item thankyou d-inline-block <?php if(is_order_received_page()){ echo 'active'; } ?>">
        <div class="circle">3</div>
        <?= __('Dokončenie', 'goshop'); ?>
        <span class="d-mobile-none">
            <?= __('objednávky', 'goshop'); ?>
        </span>
        
      </div>
      <div class="clear"></div>        
    </div>
</div>  
  
  
  <style>
    
  </style>