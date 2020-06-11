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
          <nav>
            <ul class="menu-items">
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
     </div>
   </div>
</nav>