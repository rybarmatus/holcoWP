<div class="container">
    <?php require(CONTENT.'/product-list-content.php') ?>
</div>

<?php if(isset($_GET['f'])) { ?>

<script>
    ajax_filter_products();
</script>    

<?php } ?> 