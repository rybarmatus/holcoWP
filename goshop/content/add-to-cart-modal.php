<div class="modal add-to-cart">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <?= __('Úspešne si pridal produkt do košíka', 'goshop') ?>
          <button type="button" class="close js-modal-close pointer">
            <span aria-hidden="true">×</span>
          </button>    
      </div>
      <div class="modal-body pt-0">
          <div class="row">
            <div class="col-md-6 pt-3 pb-3">
              <div class="row">
                <div class="col-5">
                   <img src="" class="product-image w-max-100">
                </div>  
                <div class="col-7 pl-0">
                  <div class="product-title"></div>
                  <span class="product-quantity"></span>
                  <span class="product-price"></span>
                </div>
              </div>  
            </div>
            <div class="col-md-6 pt-3 pb-3 js-modal-add-to-cart-data">
              <?= __('V košíku máte', 'goshop'); ?>
              <span class="cart-quantity">
                <?= $pocet_v_kosiku = WC()->cart->get_cart_contents_count(); ?>
              </span>
              <?= _n( 'produkt', 'produktov', $pocet_v_kosiku, 'goshop' ); ?>
              <br>
              <?= __('v celkovej hodnote', 'goshop'); ?>
              <span class="cart-sum">
                <?= WC()->cart->get_cart_subtotal(); ?>
              </span>
            </div>
          </div>
          <div class="row border-top">
            <div class="col-md-6">
              <button class="btn btn-primary btn-small btn-icon-left js-modal-close">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg>
                Pokračovať v nákupe
              </button>
            </div>
            <div class="col-md-6 text-right">
              <a href="<?= wc_get_cart_url(); ?>" class="btn btn-small btn-primary btn-icon-right">
                Prejsť do košíka
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" class="svg-inline--fa fa-arrow-right fa-w-14" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg>
              </a>
            </div>
          </div>      
      </div>
    </div>
  </div>    
</div>

<style>
  .modal.add-to-cart .product-image img{
  height:auto;
  }
  .modal.add-to-cart .border-top{
  border-top:1px solid #e9ecef;
  padding-top: 15px;
  }
  .js-modal-add-to-cart-data{
  background-color:#e9ecef;
  }
  .add-to-cart .modal-body{
  padding-top:0;
  }
</style>