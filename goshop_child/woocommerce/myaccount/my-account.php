<?php
/**
 * My Account page
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;   


?>
<div class="row">
  <nav class="myacc-nav col-md-3">
  	  <?php wc_get_template( 'myaccount/navigation.php' ); ?>
  </nav>

  <div class="myacc-content col-md-9">
  	<?php do_action( 'woocommerce_account_content' ); ?>
  </div>
</div>
