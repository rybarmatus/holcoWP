<div class="top_nav d-mobile-none">
  <div class="container">
    <div class="row">
      <div class="col-md-5 social">
         <?php show_socials(); ?>
      </div>
      <div class="col-md-7 text-right info">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" class="svg-inline--fa fa-phone fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"/></svg>
         <?= get_option('option_tel_kontakt'); ?>
        &nbsp;&nbsp;&nbsp;
        <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="map-marker-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-map-marker-alt fa-w-12 fa-3x"><g class="fa-group"><path fill="currentColor" d="M192 0C86 0 0 86 0 192c0 77.41 27 99 172.27 309.67a24 24 0 0 0 39.46 0C357 291 384 269.41 384 192 384 86 298 0 192 0zm0 288a96 96 0 1 1 96-96 96 96 0 0 1-96 96z" class="fa-secondary"></path><path fill="currentColor" d="M192 256a64 64 0 1 1 64-64 64 64 0 0 1-64 64z" class="fa-primary"></path></g></svg>
         <?= get_option('option_adresa'); ?>
      </div>
   </div>    
  </div>
</div>