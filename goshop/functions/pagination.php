<?php

function custom_pagination($current, $count_pages){
    if($count_pages <= 1) { return false; };
    ?>
     <div class="pagination w-100 text-center mt-2">
        <button type="1" class="btn btn-primary float-right js-move-page-button" page="<?= ($current+1); ?>" <?= ($current == $count_pages) ? 'disabled' : '' ?>>
            <?= __('Nasledujúca', 'goshop'); ?>
            <!-- <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="arrow-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M218.101 38.101L198.302 57.9c-4.686 4.686-4.686 12.284 0 16.971L353.432 230H12c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h341.432l-155.13 155.13c-4.686 4.686-4.686 12.284 0 16.971l19.799 19.799c4.686 4.686 12.284 4.686 16.971 0l209.414-209.414c4.686-4.686 4.686-12.284 0-16.971L235.071 38.101c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg> -->
        </button>
        <button type="0" class="btn btn-primary float-left js-move-page-button" page="<?= ($current-1); ?>"  <?= ($current == 1) ? 'disabled' : '' ?>>
            <!-- <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M229.9 473.899l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L94.569 282H436c6.627 0 12-5.373 12-12v-28c0-6.627-5.373-12-12-12H94.569l155.13-155.13c4.686-4.686 4.686-12.284 0-16.971L229.9 38.101c-4.686-4.686-12.284-4.686-16.971 0L3.515 247.515c-4.686 4.686-4.686 12.284 0 16.971L212.929 473.9c4.686 4.686 12.284 4.686 16.971-.001z" class=""></path></svg> -->
            <?= __('Predošlá', 'goshop'); ?>
        </button>
        <div class="pages">
            <?php for($i=1;$i<=$count_pages;$i++) { ?>
                
                <span page="<?= $i; ?>" class="page-number <?= ($current == $i) ? 'active' : '' ?>"><?= $i; ?></span>
            <?php } ?>
        </div>
        <div class="clear"></div>
        <?php if($current != $count_pages and false) { ?>
            <button class="mt-1 btn btn-block btn-primary js-show-more-products"><?php printf( __( 'Zobraziť ďaľších %d položiek', 'goshop' ), POSTS_PER_PAGE ); ?></button>
        <?php } ?>
        <input type="hidden" value="<?= (isset($_GET['page_num'])) ? $_GET['page_num'] : 1; ?>" id="page_num">
        <input type="hidden" value="<?= $count_pages ?>" id="pages_count">
     </div>
<?php }