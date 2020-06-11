<?php
global $goshop_config;

if(!$goshop_config['woocommerce']){

  $navigation = array(
    ''        => __( 'Môj účet', 'goshop'),
    'upravit-ucet'     => __( 'Upraviť účet', 'goshop' )
  );


}else{

  $navigation = array(
    ''        => __( 'Môj účet', 'goshop'),
    'objednavky' => __( 'Objednávky', 'goshop' ),
    'zakupene-produkty' => __( 'Zakúpené produkty', 'goshop' ),
    'oblubene-produkty' => __( 'Obľúbené produkty', 'goshop' ),
    'sledovane-produkty' => __( 'Sledované produkty', 'goshop' ),
    'adresy' => __( 'Moje adresy', 'goshop' ),
    'upravit-ucet' => __( 'Upraviť účet', 'goshop' )
  );  

  if(!$goshop_config['product-watch-dog']){
    unset($navigation['sledovane-produkty']);
  }
  if(!$goshop_config['product-favourite']){
    unset($navigation['oblubene-produkty']);
  }
} 
?>

<ul>
  <?php
  foreach ( $navigation as $key => $label ) {
  $url = get_site_url().'/moj-ucet/'.$key;
  if(!empty($key)){
    $url .=  '/';  
  }
  if( $url == THIS_PAGE_URL ){ ?>
     <li class="is-active">
  <?php }else{ ?>
  <li>
  <?php } ?>
    <a class="d-block" title="<?= $label; ?>" href="<?= $url; ?>"><?= $label; ?> <?php if($key == 'oblubene-produkty' and $pocet_obl = countProductsInFavourite()){ ?> <div class="badge-circle badge-success"><?= $pocet_obl; ?></div> <?php } ?> </a>
  </li>
  <?php } ?>
  <li>
    <form method="post" title="<?= __( 'Odhlásiť sa', 'goshop' ); ?>">
        <button class="d-block no-btn pointer" type="submit" name="logout">
            <?= __( 'Odhlásiť sa', 'goshop' ); ?>
        </button>
    </form>
  
  </li>
</ul>

