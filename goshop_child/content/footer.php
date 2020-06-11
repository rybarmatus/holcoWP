<footer>
  <div class="container pt-1 pb-1">
    <div class="row">
      <div class="col-md-3">
        <?php if($logo = get_option('option_footer_logo')) { ?>
            <img class="footer_logo" src="<?= $logo ?>" title="<?= __( 'Domov' ); ?>" alt="<?= get_site_url(); ?> logo">
        <?php } ?>
        
        <h5><?= __( 'Sociálne siete' ); ?></h5>
        <div class="footer-column-content socialne_siete">
          <?php show_socials(); ?>
        </div>
      </div>
      <div class="col-md-3 kontakt">
        <h5><?= __( 'Kontakt' ); ?></h5>
        <div class="footer-column-content">
          <div class="kontakt_nadpis">ADRESA</div>
          <div class="kontakt_text">
            <?= get_option('option_adresa_ulica'); ?>
            <?= get_option('option_adresa_psc'); ?>
            <?= get_option('option_adresa_mesto'); ?>
          </div>
          <div class="kontakt_nadpis">TEL. KONTAKT</div>
          <div class="kontakt_text">
            <a href="tel:<?= $tel_kontakt = get_option('option_tel_kontakt'); ?>" title="Telefónny kontakt">
                <?= $tel_kontakt; ?>
            </a>
          </div>
          <div class="kontakt_nadpis">E-MAIL</div>
          <div class="kontakt_text">
            <a href="mailto:<?= $email_kontakt = get_option('option_e_mail'); ?>" title="Emailový kontakt">
              <?= $email_kontakt; ?>
            </a>
          </div>
        </div>
          
      </div>
      <div class="col-md-3">
        <h5><?= __( 'Kategórie', 'goshop' ); ?></h5>
        <div class="footer-column-content">
          <ul class="footer-menu">
            <?php $defaults = array(             
                    'theme_location'  => '',
                    'menu'            => 47,
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => '',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '%3$s',                                                   
                    'depth'           => 0,
                    'walker'          => ''
                  );
  
            wp_nav_menu( $defaults );  ?>
          </ul>
        </div>
      </div>
      
      
      <div class="col-md-3 mt-mobile-1">
          <h5>Newsletter</h5>
          <div class="footer-column-content">
            <?= do_shortcode('[mailpoet_form id="1"]'); ?>
          </div>
      </div>
    </div>
      
  </div>
</footer>