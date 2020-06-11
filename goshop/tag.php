<?php get_header(); ?>
<section class="tags">    
   
 
 <div class="container">
    <h1 class="archive-title"><?php printf( __( 'Post tag: %s', 'pietergoosen' ), single_tag_title( '', false ) ); ?></h1>
    <div class="row">
        <?php if ( have_posts() ) : ?>

           <?php
                // Show an optional term description.
                $term_description = term_description();
                if ( ! empty( $term_description ) ) :
                    printf( '<div class="taxonomy-description">%s</div>', $term_description );
                endif;
            ?>
        

        <?php
        while ( have_posts() ) : the_post();
        
            getListPost($post, 'col-md-6');

        endwhile;
        else :
        echo 'No content';
        endif;
        ?>
    </div>        
   </div> 
</section>
<?php get_footer(); ?>