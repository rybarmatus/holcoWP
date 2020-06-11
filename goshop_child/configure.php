<?php
define('PRODUCTS_PER_PAGE', 12);
define('BLOG_POST_PER_PAGE', 12);
define('NEWS_DAYS', 15);
define('MIN_PASSWORD_LENGTH', 8);
define('FB_APP', 1670071983136314);

$goshop_config['woocommerce'] = 1;
$goshop_config['woo_export_pre_slovensku_postu'] = 1;
$goshop_config['woo-stock-list'] = 1;
$goshop_config['woo-bundle-products'] = 1;
$goshop_config['woo-discounts'] = 1;
$goshop_config['woo-gifts'] = 1;

$goshop_config['sliders'] = true;

/* admin */


$goshop_config['dragAndDropOrder']  = true;
$goshop_config['dragAndDropPosts']  = array('banner', 'referencie', 'team');

$goshop_config['cookies'] = true;  /* potrebne pre favourite, compare, watch dog, last seen */
$goshop_config['migrator'] = true;
$goshop_config['socials'] = true;
$goshop_config['tooltip'] = true;
$goshop_config['mailpoet'] = true;
$goshop_config['login'] = true;
$goshop_config['social_login'] = true;
$goshop_config['cpt_banners'] = true;
$goshop_config['cpt_referencie'] = true;
$goshop_config['cpt_manufacturers'] = true;
$goshop_config['cpt_poradca'] = true;
$goshop_config['cpt_eventy'] = true;
$goshop_config['cpt_team'] = true;
$goshop_config['events_calendar'] = true;
$goshop_config['random_password'] = 'Ne8octrVbZGKJZnf7jUH';
$goshop_config['opening_hours'] = true;

/* kontakt page */

$goshop_config['contact_show_opening_hours'] = true;
$goshop_config['contact_show_map'] = true;

/* header */

$goshop_config['minicart'] = true;
$goshop_config['nav_top'] = true;
$goshop_config['breadcrumbs'] = true;

/* footer */

$goshop_config['footer_logo'] = true;
$goshop_config['copyright'] = 1;  // goup 1, pixel 2

/* single product */

$goshop_config['add_to_cart_modal'] = true;
$goshop_config['fb_share_post'] = false;
$goshop_config['last_seen'] = true;
$goshop_config['product-compare'] = true;
$goshop_config['product-favourite'] = true;
$goshop_config['product-rating'] = true;
$goshop_config['product-watch-dog'] = true;
$goshop_config['product-download'] = true;
$goshop_config['product-technology'] = true;
$goshop_config['technicke-parametre'] = true;

/* listing */
$goshop_config['product_list_sidebar'] = true;  // čí má listing sidebar
$goshop_config['product_list_categories'] = true;  // či má listing kategórie vypísané
$goshop_config['product_filter'] = true;  // či má listing filer - treba aj na radenie produktov
$goshop_config['product_filter_news'] = true;
$goshop_config['product_filter_stock'] = true;
$goshop_config['product_filter_sale'] = true;
$goshop_config['product_list_display_options'] = true;
$goshop_config['product_list_cat_image'] = true;
$goshop_config['product_list_cat_text'] = true;
$goshop_config['product_list_cat_childrens'] = true;
$goshop_config['product_list_sale_percent'] = true;

/* blog */
$goshop_config['blog'] = true;
$goshop_config['page_for_posts'] = 49;
$goshop_config['blog_categories'] = true;  /* redirect z kategórií na /blog */
$goshop_config['clanok_komentare'] = true;
$goshop_config['clanok_rating'] = true;

/* order process */
$goshop_config['dobierka'] = true;
$goshop_config['hotovost'] = true;
$goshop_config['cetelem'] = true;
$goshop_config['ZBOZI_CZ_ID_PROVOZOVNY'] = false;
$goshop_config['zasielkovna_api'] = '77cf44016b8d0855';
$goshop_config['zasielkovna_password'] = false;
$goshop_config['checkout_simple_header'] = true;
$goshop_config['checkout_company'] = true;   /* možnost dat fakturacnú adresu na firmu */
$goshop_config['bacs_payment'] = true;  /* existuje možnost platby prevodom na ucet */

/* feedy */

$goshop_config['product_feeds'] = 1;
$goshop_config['glami_feed'] = false;
$goshop_config['glami_track'] = false;
$goshop_config['heureka_feed'] = 1;
$goshop_config['google_feed'] = false;

