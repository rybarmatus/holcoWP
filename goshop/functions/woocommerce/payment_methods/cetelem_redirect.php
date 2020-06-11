<html>
  <head>
    <title>Cetelem redirect</title>
  </head>
  <body>
  
  <?php if(isset($_GET['redirect_to_cetelem']) and $_GET['redirect_to_cetelem']) { ?>
  
    <form action="https://online.cetelem.sk/eshop/ziadost.php" method="post" id="paymentForm">
      <?php
      foreach($_GET as $input_name=>$input_value){
        echo '<input type=hidden name="'.$input_name.'" value="'.$input_value.'"/>';                   
      }
      ?>
      <input style="display:none" type="submit" value="Submit"/>
    </form>
    <script type="text/javascript">
     document.getElementById("paymentForm").submit(); // SUBMIT FORM
    </script>
    
    <div style="text-align:center;margin-top:3em">
      <img style="" src="https://online.cetelem.sk/eshop/images/logo_cetelem.png" alt="cetelem">
      <br /><br />
      <h1>Presmeruvávam na stránku Cetelemu</h1>
      <br />
      <img alt="loader" src="/wp-content/themes/goshop/images/loader.gif">
    </div>
  
  <?php }else{
  
    if(isset($_GET['stav'])){
    
      $order = wc_get_order( $_GET['obj'] );
      
      if($_GET['stav'] == 1){   // ziadosť predbežne schválená
        
        $order->update_status( 'wc-on-hold', sprintf ( __( 'Žiadosť [%s] bola predbežne schválená.', 'goshop_admin' ), $_GET['numwrk'] ) );
        
      }else if( $_GET['stav'] == 2){  // žiadosť sa posudzuje
      
        $order->update_status( 'wc-on-hold', sprintf ( __( 'Žiadosť [%s] sa posudzuje.', 'goshop_admin' ), $_GET['numwrk'] ) );
      
      }else if( $_GET['stav'] == 3){  // zamietnutá
      
        $order->update_status( 'wc-on-hold', __( 'Žiadosť bola zamietnutá.', 'goshop_admin' ) );
        
      }else if( $_GET['stav'] == 5){  // nastala chyba pri spracovaní
    
        $order->update_status( 'wc-on-hold', __( 'Nastala chyba pri spracovaní.', 'goshop_admin' ) );
        
      }
      
      
      // https://goshop.goup.sk/kontrola-objednavky/order-received/619/?key=wc_order_xQIJCZafkuqeS
       
      wp_redirect( '/kontrola-objednavky/order-received/'. $_GET['obj'] .'/?key='.$order->get_order_key() );
      exit;
           
  
    } 
  } ?>

</body>
</html>