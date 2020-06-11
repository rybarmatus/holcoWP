<nav class="mobile-fixed-menu d-desctop-none checkout-mobile-nav">
  <div class="mobile_menu">
    <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <a class="navbar-brand d-inline-block" title="<?= __( 'Domov', 'goshop' ); ?>" href="<?= home_url(); ?>">
              <?php if($logo = get_option('option_header_logo')) { ?>
                <img src="<?= $logo ?>"  alt="<?= get_site_url(); ?> logo">
              <?php } ?>
            </a>
          </div>
          <div class="col-6 text-right menu-items">
              <?= __('Nákupný proces', 'goshop'); ?>
              <?php
              if(is_order_received_page()){
                 echo '3/3';
              }else if(IS_CART) { 
                  echo '1/3';
              }else if(IS_CHECKOUT) {  
                  echo '2/3';
              } ?>
          </div>
      </div>    
    </div>
  </div>    
</nav>