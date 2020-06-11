<?php  // rovno transienty ukladat podla nazvu

function getSlider(string $name, array $posts, int $slidesToShow = 1, int $seconds = 0, bool $indicators = false, bool $arrows, bool $progressBar = false, bool $links = false, $include = false){

if($slidesToShow > 1 and count($posts) == 1){
  $slidesToShow = 1;
}
$arrays_continue = array();
$poradie = 0;
?>

<div id="<?= $name ?>-carousel" class="carousel<?= ($slidesToShow > 1) ? ' carousel-multiple' : ' carousel-simple' ?>" <?= ($seconds) ? 'data-seconds="'.$seconds.'"' : '' ?>>
  <?php if($progressBar){ ?>
    <div class="banner-progress-bar"></div>
  <?php } ?>
    
  <div class="carousel-inner">
    <?php 
    foreach($posts as $key=>$post){ 
      if( in_array($key, $arrays_continue) ){
        continue;
      }
      ?>
         <div data-key="<?= $poradie ?>" class="carousel-item <?php if(!$poradie){ echo 'active'; }else if($poradie == 1){ echo 'next'; } ?>">
          <?php
          if($name != 'homepage'){
            echo '<div class="row">'; 
            for($x=0;$x < $slidesToShow;$x++){
                $keyX = ($key+$x);
                if(isset($posts[$keyX])){
                  $post = $posts[$keyX];
                  if($include){
                    require($include);
                  }else{
                    getSlideContent($post, $links, $slidesToShow);
                  }
                  
                  array_push($arrays_continue, $keyX);
                }
            }
            echo '</div>';   
          }else {
            getSlideContent($post, $links, $slidesToShow);
          } 
          $poradie++; 
          ?>
        </div>
    <?php } ?>
  </div>
  <?php if($indicators) { ?>
    <ol class="carousel-indicators">
    <?php foreach($posts as $key=>$item){ ?>
        <li data-target="#<?= $name ?>-carousel" title="<?= $item->post_title; ?>" data-slide-to="<?= $key ?>" <?php if(!$key){ echo 'class="active"'; } ?>></li>
    <?php } ?>
    </ol>
  <?php } ?>
  <?php if($arrows) { ?>
  <a class="carousel-control-prev pointer" title="<?= _('Predchádzajúci'); ?>" role="button" data-target="#<?= $name ?>-carousel">
    <span class="carousel-control-prev-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left"  role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>
    </span>
  </a>
  <a class="carousel-control-next pointer" title="<?= _('Nasledujúci'); ?>" role="button" data-target="#<?= $name ?>-carousel">
    <span class="carousel-control-next-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>
    </span>
  </a>
  <?php } ?>
</div>

<?php }


function getSliderItemWrapper($slidesToShow){

   if($slidesToShow == 1){
      $wrapper = '';
   }else if($slidesToShow == 2){
      $wrapper = 'col-md-6';
   }else if($slidesToShow == 3){
      $wrapper = 'col-md-4';
   }else{
      $wrapper = 'col-md-3';
   } 
   return $wrapper;
}

function getSlideContent($post, $links, $slidesToShow){ ?>
  
  <div class="<?= getSliderItemWrapper($slidesToShow) ?>">
  <?php
  if(isset($post->ID)){ 
    if($links and isset($post->ID) and $href = get_field('preklik',$post->ID)) { ?>
        <a href="<?= $href ?>" <?php if(get_field('otvorit_na_novej_karte',$post->ID)){ echo 'target="_blank"'; } ?>>                     
    <?php } ?>
    <?php if($thumb_id = get_post_thumbnail_id($post->ID)){ ?>
      <img class="d-block w-100" src="<?= wp_get_attachment_url( $thumb_id ) ?>" alt="<?= $post->post_title ?>">
    <?php } ?>
    <?php if($links and isset($post->ID) and $href){ ?>
      </a>
    <?php
    } ?>
    
    <?php
    }else {
      echo $post['text'];
    } 
    ?>
  </div>
<?php
}
