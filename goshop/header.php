<?php
global $goshop_config;
?>
<!doctype html>
<html lang="<?= HEADER_LANG ?>">
<head>
  <?= get_seo_component(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="author" content="Ing. Martin Holek" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="sitemap" href="<?= 'https://' . $_SERVER[ 'HTTP_HOST' ]; ?>/sitemap.xml" />
<link rel="stylesheet" href="<?= CHILD_DIR_URI ?>/style.css" type="text/css" />
<link rel="shortcut icon" href="<?= get_site_icon_url(); ?>" type="image/x-icon">
  
  <?= get_fonts(); ?>
  
<!-- WP_HEAD -->
<?php 
if( IS_CHECKOUT ){
wp_head();
}
?>
<!-- END WP_HEAD -->
  <?= get_option('option_head_end'); ?>
  
  <?php if($goshop_config['glami_feed']) { ?>
    <!-- Glami piXel -->
    <script>
    (function(f, a, s, h, i, o, n) {f['GlamiTrackerObject'] = i;
    f[i]=f[i]||function(){(f[i].q=f[i].q||[]).push(arguments)};o=a.createElement(s),
    n=a.getElementsByTagName(s)[0];o.async=1;o.src=h;n.parentNode.insertBefore(o,n)
    })(window, document, 'script', '//www.glami.sk/js/compiled/pt.js', 'glami');
    
    glami('create', '<?= $goshop_config['glami'] ?>', 'sk');
    glami('track', 'PageView');
    </script>
    <!-- End Glami piXel -->
  <?php } ?>

</head>
<body <?php body_class(); ?>>
  <?= get_option('option_body_start'); ?>
  
  <header>
    <?php
    if($goshop_config['nav_top']){ 
        include_once(CHILD_CONTENT.'/nav-top.php');
    }
    if($goshop_config['woocommerce']){
        if(!$goshop_config['checkout_simple_header'] or (!IS_CART and !IS_CHECKOUT)) { 
            include_once(CHILD_CONTENT.'/nav-desctop-woo.php');
            include_once(CHILD_CONTENT.'/nav-mobile-woo.php');
        }else {
            include_once(CONTENT.'/nav-desctop-checkout.php');
            include_once(CONTENT.'/nav-mobile-checkout.php');
        }
    }else {
        include_once(CHILD_CONTENT.'/nav-desctop.php');
        include_once(CHILD_CONTENT.'/nav-mobile.php');
    }
    ?>
  </header>
  <main>
    <?php
    if($goshop_config['breadcrumbs'] and !is_front_page() and !isset($_GET['s']) and !IS_CHECKOUT and !IS_CART){
        include_once(CONTENT.'/breadcrumbs.php');
    } 
