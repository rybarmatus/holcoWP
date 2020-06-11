<?php if( !isset($_COOKIE['cookie_bar'])){ ?>
  <div class="cookie_wrapper">
    <button class="btn btn-primary btn-small js-accept_cookie float-right"><?= __('Súhlasím', 'goshop'); ?></button>
    <p class="cookie_msg"><?= __('Na našej webovej stránke používame rôzne súbory cookies za účelom zabezpečenia jej ľahšieho používania a vyhodnocovania. Viac o používaných súboroch cookies a možnostiach ich deaktivácie sa dozviete v našej','goshop'); ?> 
      <a target="_blank" href="/ochrana-osobnych-udajov/"><?= __('Ochrane osobných údajov', 'goshop'); ?></a>
    </p>
  </div>
<?php } 
