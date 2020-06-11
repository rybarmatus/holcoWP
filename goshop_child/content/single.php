<section class="single-blog">
  <div class="container mt-2">    
    <div class="row">
      <div class="col-md-9 pb-5">
          <article class="single-content mt-1">
            <?php if($image) { ?>
                <figure>
                  <img class="blog-single-main-img w-100" src="<?= $image[0] ?>" alt="<?= $post->post_title; ?>" />
                </figure>  
            <?php } ?>
            <div class="meta mb-2">
                <span title="<?= __('Počet zobrazení článku', 'goshop'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="eye" class="svg-inline--fa fa-eye fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z"></path></svg>
                    <?= get_post_meta($clanok_id, 'post_open_count', true); ?>x</span>
                &nbsp;&nbsp;&nbsp;
                <span title="<?= __('Čítanosť článku', 'goshop'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="users" class="svg-inline--fa fa-users fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"></path></svg>
                    <?= getPostViews($clanok_id); ?>x</span>
                &nbsp;&nbsp;&nbsp;
                <span data-target=".comments" title="<?= __('Počet komentárov', 'goshop'); ?>" class="scrollTo pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="comments" class="svg-inline--fa fa-comments fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M532 386.2c27.5-27.1 44-61.1 44-98.2 0-80-76.5-146.1-176.2-157.9C368.3 72.5 294.3 32 208 32 93.1 32 0 103.6 0 192c0 37 16.5 71 44 98.2-15.3 30.7-37.3 54.5-37.7 54.9-6.3 6.7-8.1 16.5-4.4 25 3.6 8.5 12 14 21.2 14 53.5 0 96.7-20.2 125.2-38.8 9.2 2.1 18.7 3.7 28.4 4.9C208.1 407.6 281.8 448 368 448c20.8 0 40.8-2.4 59.8-6.8C456.3 459.7 499.4 480 553 480c9.2 0 17.5-5.5 21.2-14 3.6-8.5 1.9-18.3-4.4-25-.4-.3-22.5-24.1-37.8-54.8zm-392.8-92.3L122.1 305c-14.1 9.1-28.5 16.3-43.1 21.4 2.7-4.7 5.4-9.7 8-14.8l15.5-31.1L77.7 256C64.2 242.6 48 220.7 48 192c0-60.7 73.3-112 160-112s160 51.3 160 112-73.3 112-160 112c-16.5 0-33-1.9-49-5.6l-19.8-4.5zM498.3 352l-24.7 24.4 15.5 31.1c2.6 5.1 5.3 10.1 8 14.8-14.6-5.1-29-12.3-43.1-21.4l-17.1-11.1-19.9 4.6c-16 3.7-32.5 5.6-49 5.6-54 0-102.2-20.1-131.3-49.7C338 339.5 416 272.9 416 192c0-3.4-.4-6.7-.7-10C479.7 196.5 528 238.8 528 288c0 28.7-16.2 50.6-29.7 64z"></path></svg>
                  <?= $post->comment_count; ?>x</span>
                &nbsp;&nbsp;&nbsp;
                <div class="d-inline-block scrollTo pointer" data-target="#commentform">
                <?= getPostStars($clanok_id); ?>
                </div>
                <div class="float-right">
                    <time datetime="<?= $post->post_date ?>">
                        <?= date('d.m.Y', strtotime($post->post_date)); ?>
                    </time>
                </div>
                <div class="clear"></div>
            </div>
            <h1 class="text-center mb-0"><?= $post->post_title ?></h1>
            <div class="kategoria mb-2 text-center">
            
              <?php
              $kategorie = get_the_category($post->ID);
               foreach($kategorie as $cat) { ?>
                <span>
                <a target="" href="<?= get_category_link($cat->term_id); ?>" rel="category tag">
                  <?= $cat->name; ?>
                </a>
                </span>
                
              <?php } ?>
              
            </div> 
            <div class="article-content mb-2">
                <?php
                if (have_posts()) {
                    while (have_posts()) : the_post();
                    the_content();
                    endwhile;
                } 
                ?>
            </div>
            
            <h3><?= __('Páčil sa Vám článok?', 'goshop'); ?></h3>
            <div class="row">
                <div class="col-4">
                  <div class="post-share-wrapper">
                    <h5><?= __('Zdielajte', 'goshop'); ?>..</h5>
                    <a rel="nofollow" target="_blank" aria-label="Facebook share" title="Facebook share" href="https://www.facebook.com/sharer.php?u=<?= THIS_PAGE_URL ?>">
                      <svg class="facebook" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-square" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>
                    </a>
                     &nbsp;
                     <a rel="nofollow" target="_blank" aria-label="Twitter share" title="Twitter share" href="https://twitter.com/intent/tweet?&url=<?= THIS_PAGE_URL ?>&via=<?= get_bloginfo() ?>">
                      <svg class="twitter" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" viewBox="0 0 512 512"><title>Facebook share</title><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                     </a>
                  </div>
                </div>
            </div>      
            <input type="hidden" id="post_id" value="<?= $clanok_id ?>">
          </article>
          <h3 class="mt-3"><?= __('Ďalšie články z kategórie', 'goshop'); ?> <a href="<?= get_category_link($kategoria->cat_ID); ?>" title="<?= $kategoria->name ?>"><?= $kategoria->name ?></a></h3>
        <div class="row blog-list">
        <?php
        $blog_articles = get_posts( [
          'orderby' => 'post_date',
          'order' => 'DESC',
          'post_type' => 'post',
          'numberposts' => 3,
          'exclude' => $clanok_id,
          'category' => $kategoria->cat_ID,
          'post_status' => 'publish',
          'suppress_filters' => true
        ] ); 
      
        if(!empty($blog_articles)){
          foreach( $blog_articles as $post ){ 
            getListPost($post, 'col-md-4');
          } 
        } ?>
         </div>
         <div>
          <?php
          if($goshop_config['clanok_komentare']){
           comments_template(); 
          }
          ?>
        </div>
        </div>    
       
      <div class="col-md-3 blog-sidebar">
         <?php require(CHILD_CONTENT. '/blog-aside.php'); ?>
      </div>
    </div>
  </div>
</section>