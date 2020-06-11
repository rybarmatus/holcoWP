<div class="container">
    <div class="row">
        <div class="col-md-3">
            <aside>
                <?php
                if($goshop_config['product_filter']){
                    include_once(CONTENT.'/sidebar-filter.php');
                }else if($goshop_config['product_list_categories']){
                    include_once(CONTENT.'/sidebar-categories.php');
                }
                ?>
            </aside>
        </div>
        <div class="col-md-9">
            <?php require(CONTENT.'/product-list-content.php') ?>
        </div>
    </div>
</div>