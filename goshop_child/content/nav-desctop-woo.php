<?php
global $goshop_config; 
?>
<nav class="desctop-navbar d-mobile-none">
    <div class="container">
      <div class="row">
        <div class="col-md-2 logo_wrapper">
          <a class="navbar-brand d-inline-block" title="<?= __( 'Domov', 'goshop' ); ?>" href="<?= home_url(); ?>">
            <?php if($logo = get_option('option_header_logo')) { ?>
              <img src="<?= $logo ?>" class="w-max-100" alt="<?= get_site_url(); ?> logo">
            <?php } ?>
          </a>
        </div>  
        <div class="col-md-10 text-right menu_wrapper">
            <div class="row">
                <div class="col-md-4 col-lg-5 col-xl-5">
                  <form class="search-form" method="get" action="/">
                      <div class="input-group">
                        <input value="<?php if( is_search() and isset($_GET['s']) ) { echo $_GET['s']; } ?>"
                               name="s" 
                               placeholder="<?= __('Hladaj produkty, kategórie, značky alebo články','goshop'); ?>"
                               type="search" 
                               autocomplete="off" 
                               class="form-control js-product_search" 
                               pattern=".{3,}" title="Pre hladanie zadajte aspon 3 znaky" 
                               required
                        >
                        <button id="search_button" class="search-button btn btn-primary btn-small" data-default_html="fas fa-search">
                          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
                        </button>
                      </div>
                      <div class="search-suggest-wrapper"></div>
                  </form>
              </div>
              <div class="col-md-8 col-lg-7 col-xl-6">
                  <div class="menu-items float-left">
                    <nav>
                      <ul>
                        <li class="menu-item">
                        <?php if(is_user_logged_in()){ ?>
                          <a href="/moj-ucet/" title="<?= __( 'Môj účet','goshop' ); ?>">
                            <?= __( 'Môj účet','goshop' ); ?>
                          </a> 
                        <?php } else { ?>
                          <span class="js-modal pointer" data-modal=".login"> <?= __( 'Prihlásiť','goshop' ); ?></span>
                        <?php } ?>
                        </li>
                      <?php $defaults = array(             
                          'menu'            => 16, 
                          'echo'            => false,                    
                          'container'       => false,
                          'items_wrap'      => '%3$s',                    
                          'fallback_cb'     => 'wp_page_menu',
                          'items_wrap'      => '%3$s',                                                   
                        );
                      echo wp_nav_menu( $defaults );  ?>
                     </ul>
                   </nav> 
                </div>
                
                <div class="float-right header-basket-section">
                  
                  
                  <div class="basket_wrapper <?php if($goshop_config['minicart']){ ?>has_minicart<?php } ?> d-inline-block">
                    <a class="relative basket_icon_wrapper cart-contents d-inline-block" href="<?= wc_get_cart_url(); ?>" title="<?= __( 'Zobraz nákupný košík' ); ?>">
                      <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path></svg>
                      <?php if($cart_count = WC()->cart->cart_contents_count) { ?>
                            <div class="count cart-contents-count"><?= $cart_count ?></div>
                      <?php } ?>
                      
                    </a>
                    <?php if($goshop_config['minicart']){ ?>
                      <div id="mini-cart">
                          <div class="minicart-content">
                            <?php woocommerce_mini_cart(); ?>
                          </div>
                      </div>
                    <?php } ?>
                  </div>
                  <a class="d-inline-block" href="/porovanie-produktov" title="<?= __('Porovnanie produktov','goshop'); ?>">
                    <div class="product-compare-header-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M96 464v32c0 8.84 7.16 16 16 16h224c8.84 0 16-7.16 16-16V153.25c4.56-2 8.92-4.35 12.99-7.12l142.05 47.63c8.38 2.81 17.45-1.71 20.26-10.08l10.17-30.34c2.81-8.38-1.71-17.45-10.08-20.26l-128.4-43.05c.42-3.32 1.01-6.6 1.01-10.03 0-44.18-35.82-80-80-80-29.69 0-55.3 16.36-69.11 40.37L132.96.83c-8.38-2.81-17.45 1.71-20.26 10.08l-10.17 30.34c-2.81 8.38 1.71 17.45 10.08 20.26l132 44.26c7.28 21.25 22.96 38.54 43.38 47.47V448H112c-8.84 0-16 7.16-16 16zM0 304c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0C-1.32 295.27.02 287.82.02 304H0zm56-16l72-144 72 144H56zm328.02 144H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0-86.38 172.78-85.04 165.33-85.04 181.51zM440 416l72-144 72 144H440z"/></svg>
                        <?php if($comp_count = countProductsInCompare()) { ?>
                            <div class="count"><?= $comp_count ?></div>
                        <?php } ?>
                    </div>
                  </a>
                  
                  <a class="d-inline-block" href="/oblubene-produkty" title="<?= __('Obľúbené produkty','goshop'); ?>">
                    <div class="product-favourite-header-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"></path></svg>
                        <?php if($fav_count = countProductsInFavourite()) { ?>
                            <div class="count"><?= $fav_count ?></div>
                        <?php } ?>
                    </div>
                  </a>
                
                </div>
                <div class="clear"></div> 
              </div>
          </div>
      </div>
    </div>
  </div>
</nav>

<div class="category-nav d-mobile-none">
  <div class="container">
  <nav>
    <ul>
    <?php
    $defaults = array(             
      'menu'            => 17,                
      'echo'            => false,                    
      'container'       => false,
      'items_wrap'      => '%3$s',                    
      'fallback_cb'     => 'wp_page_menu',
      'items_wrap'      => '%3$s',                                                   
    );
    echo wp_nav_menu( $defaults );
    ?>
    </ul>
  </nav> 
  <div class="clear"></div>
 </div>      
</div>  

