<?php
$args = array(
    'taxonomy' => 'product_cat',
    'current_category' => $cur_cat->term_id,
    // 'depth' => 99,
    'title_li' => false,
    'orderby' => 'menu_order',
    'exclude' => 15,
    'order' => 'ASC',
    'echo' => false,
    'show_count' => false
);
?>

<div class="sidebar-header d-mobile-none">
    <?= __('Kategórie','goshop'); ?>
</div>

<nav class="sidebar-categories d-mobile-none">
    <?= wp_list_categories($args); ?>
</nav>
