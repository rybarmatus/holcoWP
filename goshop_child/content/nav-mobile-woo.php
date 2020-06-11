<nav class="mobile-fixed-menu d-desctop-none js-remove-to-scroll">
    <div class="mobile-fixed-logo">
      <a class="navbar-brand" title="<?= __( 'Domov', 'goshop' ); ?>" href="<?= home_url(); ?>">
        <?php if($logo = get_option('option_header_logo')) { ?>
          <img src="<?= $logo ?>"  alt="<?= get_site_url(); ?> logo">
        <?php } ?>
      </a>
    </div>
  <div class="mobile_menu">
    <div class="mobile-nav-item w-20 close mobile-menu-button" id="mobile_menu_button">
        <svg class="close" aria-hidden="true" focusable="false" data-prefix="far" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M436 124H12c-6.627 0-12-5.373-12-12V80c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12zm0 160H12c-6.627 0-12-5.373-12-12v-32c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12zm0 160H12c-6.627 0-12-5.373-12-12v-32c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12z"></path></svg>
        <svg class="open" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z" class=""></path></svg>
        <?= __( 'Produkty', 'goshop' ); ?>
    </div>
    <div class="mobile-nav-item w-20 close mobile-menu-button" id="mobile_search_button">
        <svg class="close" aria-hidden="true" focusable="false" data-prefix="far" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>
        <svg class="open" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z" class=""></path></svg>
        <?= __( 'Hľadať', 'goshop' ); ?>
    </div>
    <div class="mobile-nav-item w-20">
      
      <?php if(is_user_logged_in()){ ?>
        <a href="/moj-ucet/" title="<?= __( 'Môj účet','goshop' ); ?>">
          <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M313.6 288c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zM416 464c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16v-41.6C32 365.9 77.9 320 134.4 320c19.6 0 39.1 16 89.6 16 50.4 0 70-16 89.6-16 56.5 0 102.4 45.9 102.4 102.4V464zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm0-224c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" class=""></path></svg>
          <?= __( 'Môj účet','goshop' ); ?>
        </a> 
      <?php } else { ?>
        <span class="js-modal pointer" data-modal=".login">
            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M313.6 288c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zM416 464c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16v-41.6C32 365.9 77.9 320 134.4 320c19.6 0 39.1 16 89.6 16 50.4 0 70-16 89.6-16 56.5 0 102.4 45.9 102.4 102.4V464zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm0-224c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" class=""></path></svg>
            <?= __( 'Prihlásiť','goshop' ); ?>
        </span>
      <?php } ?>
    </div>
    <div id="mobile-kosik" class="mobile-nav-item w-20 relative-wrapper">
      <a title="" href="/kontakt">
      <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M487.8 24.1L387 .8c-14.7-3.4-29.8 4.2-35.8 18.1l-46.5 108.5c-5.5 12.7-1.8 27.7 8.9 36.5l53.9 44.1c-34 69.2-90.3 125.6-159.6 159.6l-44.1-53.9c-8.8-10.7-23.8-14.4-36.5-8.9L18.9 351.3C5 357.3-2.6 372.3.8 387L24 487.7C27.3 502 39.9 512 54.5 512 306.7 512 512 307.8 512 54.5c0-14.6-10-27.2-24.2-30.4zM55.1 480l-23-99.6 107.4-46 59.5 72.8c103.6-48.6 159.7-104.9 208.1-208.1l-72.8-59.5 46-107.4 99.6 23C479.7 289.7 289.6 479.7 55.1 480z" class=""></path></svg>
      <?= __( 'Kontakty', 'goshop' ); ?>
      </a>  
    </div>
    <div class="mobile-nav-item w-20">
      <a href="<?= wc_get_cart_url(); ?>" title="<?= __( 'Zobraz nákupný košík' ); ?>">
        <div class="kosik_wrapper">
            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M551.991 64H129.28l-8.329-44.423C118.822 8.226 108.911 0 97.362 0H12C5.373 0 0 5.373 0 12v8c0 6.627 5.373 12 12 12h78.72l69.927 372.946C150.305 416.314 144 431.42 144 448c0 35.346 28.654 64 64 64s64-28.654 64-64a63.681 63.681 0 0 0-8.583-32h145.167a63.681 63.681 0 0 0-8.583 32c0 35.346 28.654 64 64 64 35.346 0 64-28.654 64-64 0-17.993-7.435-34.24-19.388-45.868C506.022 391.891 496.76 384 485.328 384H189.28l-12-64h331.381c11.368 0 21.177-7.976 23.496-19.105l43.331-208C578.592 77.991 567.215 64 551.991 64zM240 448c0 17.645-14.355 32-32 32s-32-14.355-32-32 14.355-32 32-32 32 14.355 32 32zm224 32c-17.645 0-32-14.355-32-32s14.355-32 32-32 32 14.355 32 32-14.355 32-32 32zm38.156-192H171.28l-36-192h406.876l-40 192z" class=""></path></svg>
            <?= __( 'Košík', 'goshop' ); ?>
            <div class="mobil-kosik-pocet-badge">
                <?= WC()->cart->get_cart_contents_count(); ?>
            </div>
        </div>
      </a>
    </div>
  </div>
  </nav>

  <div class="mobile_menu_sidebar d-desctop-none" id="mobile-search-sidebar">
     <form class="mt-1 ml-1 mr-1" method="get" action="/">
          <div class="input-group">
            <input id="mobile-search-input" value="" name="s" placeholder="Hladaj produkty, kategórie, značky alebo články" type="text" autocomplete="off" class="form-control js-product_search" pattern=".{3,}" title="Pre hladanie zadajte aspon 3 znaky" required="">
            <button class="search-button btn btn-primary btn-small" data-default_html="fas fa-search">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
            </button>
          </div>
          <div class="search-suggest-wrapper"></div>
      </form>
  </div>


<div class="mobile_menu_sidebar woo d-desctop-none" id="mobile-menu-sidebar">
  
  <div class="container-fluid mt-1 mb-1">
    <div class="row icons-wrapper mb-2 text-center">
      <div class="col-4">
        <a class="" href="/porovanie-produktov" title="<?= __('Porovnanie produktov', 'goshop'); ?>">
          <div class="product-compare-header-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M96 464v32c0 8.84 7.16 16 16 16h224c8.84 0 16-7.16 16-16V153.25c4.56-2 8.92-4.35 12.99-7.12l142.05 47.63c8.38 2.81 17.45-1.71 20.26-10.08l10.17-30.34c2.81-8.38-1.71-17.45-10.08-20.26l-128.4-43.05c.42-3.32 1.01-6.6 1.01-10.03 0-44.18-35.82-80-80-80-29.69 0-55.3 16.36-69.11 40.37L132.96.83c-8.38-2.81-17.45 1.71-20.26 10.08l-10.17 30.34c-2.81 8.38 1.71 17.45 10.08 20.26l132 44.26c7.28 21.25 22.96 38.54 43.38 47.47V448H112c-8.84 0-16 7.16-16 16zM0 304c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0C-1.32 295.27.02 287.82.02 304H0zm56-16l72-144 72 144H56zm328.02 144H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0-86.38 172.78-85.04 165.33-85.04 181.51zM440 416l72-144 72 144H440z"/></svg>
              <div class="count"><?= countProductsInCompare() ?></div>
          </div>
        </a>
      </div>
      <div class="col-4">
        <a class="" href="/oblubene-produkty" title="<?= __('Obľúbené produkty', 'goshop'); ?>">
          <div class="product-favourite-header-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"></path></svg>
              <div class="count"><?= countProductsInFavourite() ?></div>
          </div>
        </a>
      </div>
      <div class="col-4">
          <a class="" href="/sledovane-produkty" title="<?= __('Sledované produkty', 'goshop'); ?>">
            <div class="product-favourite-header-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dog" class="svg-inline--fa fa-dog fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M496 96h-64l-7.16-14.31A32 32 0 0 0 396.22 64H342.6l-27.28-27.28C305.23 26.64 288 33.78 288 48.03v149.84l128 45.71V208h32c35.35 0 64-28.65 64-64v-32c0-8.84-7.16-16-16-16zm-112 48c-8.84 0-16-7.16-16-16s7.16-16 16-16 16 7.16 16 16-7.16 16-16 16zM96 224c-17.64 0-32-14.36-32-32 0-17.67-14.33-32-32-32S0 174.33 0 192c0 41.66 26.83 76.85 64 90.1V496c0 8.84 7.16 16 16 16h64c8.84 0 16-7.16 16-16V384h160v112c0 8.84 7.16 16 16 16h64c8.84 0 16-7.16 16-16V277.55L266.05 224H96z"></path></svg>
              <div class="count"><?= countProductsInFavourite() ?></div>
            </div>
          </a>
      </div>
   </div>
<div class="woo d-desctop-none" id="mobile-menu-sidebar">
  <div class="woo-mobile-categories mb-5">
    <?php
    wp_list_categories( 
        array(
          'taxonomy' => 'product_cat',
          'hide_empty' => 0,
          'title_li'  => '',
          'orderby' => 'menu_order',
          'exclude' => 15,
        )
    );
    ?>
  </div>
  
  
  <nav>
    <ul>
      <?php
      $defaults = array(             
        'menu'            => 34,                
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
</div>
  </div>
  
</div>
