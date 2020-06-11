<?php
/**                                                                                                                                                               
* Template Name: Moj ucet
*/

$homepage = 'https://' . $_SERVER[ 'HTTP_HOST' ];
if(!is_user_logged_in()){
    header("Location: ".$homepage);
}

if(isset($_POST['logout'])){
    wp_logout();
    $_SESSION['notif'] = __('Bol si úspešne odhlásený', 'goshop');
    header("Location: ".$homepage);
    exit();
}

if(isset($_POST['save_account_details'])){
  if(!$edit_uset_error = edit_account($_POST)){
    $edit_user_success = true;  
  }
}

if(isset($_POST['save_address'])){
  if(!$error = edit_address($_POST, $_GET['address'])){
      $_SESSION['notif'] = __('Adresa bola úspešne upravená', 'goshop');
      header("Location: ".get_permalink(410));
      exit();
  }else{
      $edit_address_error = $error;  
  }
}

get_header();
?>

<div class="container">
  <div class="row">
    <nav class="myacc-nav col-md-3">
    	  <?php require(CONTENT. '/auth/navigation.php'); ?>
    </nav>
    <div class="myacc-content col-md-9">
    	 <?php
       if(THIS_PAGE_ID == 415) {   /* adresy edit */
          require(CONTENT. '/auth/addresses-edit.php');
       }else if(THIS_PAGE_ID == 410) {   /* adresy */
          require(CONTENT. '/auth/addresses.php');
       }else if(THIS_PAGE_ID == 355){  /* zakúpené produkty */
          require(CONTENT. '/auth/buyed.php');
       }else if(THIS_PAGE_ID == 408 and isset($_GET['orderID'])){ /* objednávky */
          require(CONTENT. '/auth/orders-single.php');
       }else if(THIS_PAGE_ID == 408){ /* objednávky */
          require(CONTENT. '/auth/orders.php');
       }else if(THIS_PAGE_ID == 400){ /* upraviť ucet */
          require(CONTENT. '/auth/edit-account.php');
       }else{
          require(CONTENT. '/auth/dashboard.php');
       }
       ?>
    </div>
  </div>
</div>

<?php get_footer();
