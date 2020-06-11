<?php
/**                                                                                                                                                               
* Template Name: Fotogaleria
*/

get_header(); ?>

<div class="container">
    <?php 
    $photos = get_field('photos'); 
    
    
     foreach($photos as $item){ ?>
        
          <div class="karta">  
            <div class="predok">
              <img alt="<?= $item['alt']; ?>" title="<?= $item['caption']; ?>" src="<?= $item['sizes']['medium']; ?>">
            </div>               
            
            <div class="zadok">
              <a title="Fotku zvačšíš kliknutím" href="<?= $item['url']; ?>">
                <div class="popis"><?= $item['description']; ?></div>
              </a>
            </div>
          </div>  
    <?php } ?>
  
</div>
<?php get_footer(); 
