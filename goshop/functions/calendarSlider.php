<?php  // rovno transienty ukladat podla nazvu
// slidesToShow -> kolko itemov je v jednom slider
function getCalendarSlider(int $pocetMesiacov = 3, array $posts, int $slidesToShow = 1, bool $indicators = false, bool $arrows){
  global $mesiace_start;  
  global $mesiace_end;
  $arrays_continue = array();
  $poradie = 0;
  $mesiace_start = 0;
  $mesiace_end = 1;
?>

<div id="calendar-carousel" class="carousel<?= ($slidesToShow > 1) ? ' carousel-multiple' : ' carousel-simple' ?>">
  <div class="carousel-inner">
    <?php 
    for($f=0; $f < ($pocetMesiacov/$slidesToShow); $f++){ ?>
    
         <div data-key="<?= $poradie ?>" class="carousel-item <?php if(!$poradie){ echo 'active'; }else if($poradie == 1){ echo 'next'; } ?>">
          
          <?php
          echo '<div class="row">'; 
            for($x=1;$x <= $slidesToShow;$x++){
                
                require(CONTENT.'/calendar.php');
                $mesiace_start += 1;
                $mesiace_end = $mesiace_start + 1;
                  
            }     
          echo '</div>';   
          $poradie++; 
          ?>
                              
        </div>
        
    <?php } ?>
  </div>
  <?php if($indicators) { ?>
    <ol class="carousel-indicators">
    <?php for($x=0; $x < ($pocetMesiacov/$slidesToShow); $x++){ ?>    
        <li data-target="#calendar-carousel" data-slide-to="<?= $x ?>" <?php if(!$x){ echo 'class="active"'; } ?>></li>
    <?php } ?>    
    </ol>
  <?php } ?>
  
  <?php if($arrows) { ?>
  <a class="carousel-control-prev pointer" title="<?= _('Predchádzajúci'); ?>" role="button" data-target="#calendar-carousel">
    <span class="carousel-control-prev-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left"  role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>
    </span>
  </a>
  <a class="carousel-control-next pointer" title="<?= _('Nasledujúci'); ?>" role="button" data-target="#calendar-carousel">
    <span class="carousel-control-next-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>
    </span>
  </a>
  <?php } ?>
</div>

<?php } ?>