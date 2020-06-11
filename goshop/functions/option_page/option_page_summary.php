<?php
global $goshop_config;
$on_icon = '<svg style="width:20px;float: left;color: green;margin-right: 14px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check-circle fa-w-16 fa-3x"><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z" class=""></path></svg>';
$off_icon = '<svg style="width:20px;float: left;color: red;margin-right: 14px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-times-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" class=""></path></svg>';
global $wp_query;
?>

<div class="wrap">
    <h1>Prehľad nastavení</h1>
    <br><br>
    <div style="margin-bottom:9px;">
    <?php
    if(get_option('blog_public')){
        echo $on_icon;
    }else {
        echo $off_icon;
    }
    ?>
    Indexovanie vašej stránky vyhľadávačmi
    </div>
    <div class="clear"></div>
    <div style="margin-bottom:9px;">
      <?php
      if (!empty($_SERVER['HTTPS'])) {
          echo $on_icon;
      }else {
          echo $off_icon;
      }
      ?>
      HTTPS
    </div>
    <div class="clear"></div>
    <div style="margin-bottom:9px;">
      <?php
      $head_text = get_option('option_head_end');
      if (strpos($head_text, 'gtag') !== false) {
         $typ = 'Google Analytics';
         $icon = $on_icon;   
      }else if (strpos($head_text, 'GTM-') !== false) {
        $typ = 'Google Tag Manager';
        $icon = $on_icon;
      }else{
        $icon = $off_icon;
        $typ = 'Google Analytics/Google Tag Manager';
      }
      echo $icon;
      echo $typ;
      
      ?>
    </div>
    <div class="clear"></div>
    <div style="margin-bottom:9px;">
        <?php
        $php_version = phpversion();
        if($php_version[0] == 7){
            echo $on_icon;
        }else{
            echo $off_icon;
        }
        ?>
        
        
        PHP verzia <strong><?= phpversion();?></strong>
    </div>
    <div class="clear"></div>
    <div style="margin-bottom:9px;">
      <?php
      if(!$goshop_config['migrator']){
          echo $on_icon;
      }else {
          echo $off_icon;
      }
      ?>
      Migrátor
   </div>
   <div style="margin-bottom:9px;">
      <?php
      if($url_privacy = get_privacy_policy_url()){
          echo $on_icon;
      }else {
          echo $off_icon;
      }
      ?>
      Definovaná stránka pre <a title="Zásady ochrany osobných údajov" target="_blank" href="<?= $url_privacy ?>">Zásady ochrany osobných údajov</a>
      <?php if(!get_privacy_policy_url()){ ?>
      <a title="Nastaviť" href="/wp-admin/options-privacy.php">Nastaviť</a>
      <?php } ?>
      
   </div>
   <div class="clear"></div>
    <br /><br />
    <div>     
        Počet publikovaných článkov <strong><?= wp_count_posts()->publish; ?></strong>
    </div>
    <div>     
        Počet publikovaných stránok <strong><?= wp_count_posts('page')->publish; ?></strong>
    </div>
    <?php if($goshop_config['woocommerce']){ ?>
    <div>     
        Počet produktov <strong><?= wp_count_posts('product')->publish; ?></strong>
    </div>
    <?php } ?>
    
    <h3>Robots.txt</h3>
    <pre><?php
    echo file_get_contents('https://goshop.goup.sk/robots.txt');
    ?>
    </pre>
        
    
</div>