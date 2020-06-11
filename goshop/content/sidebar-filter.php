<div class="filter_prepare_line"></div>
<div class="sidebar_content">

  <?php
  $cur_cat = get_queried_object();
  $filter_options = get_category_filter_options($cur_cat);
  ?>
  
  <?php if($filter_options['price_min'] != $filter_options['price_max']){ ?>
    <div class="mb-1">
      <h4><?= __('Cena do', 'goshop'); ?></h4>
      <?php get_price_filter($filter_options['price_min'], $filter_options['price_max']); ?>
    </div>
  <?php } ?>
  
  <?php if($filter_options['manufacturers']){ ?>
    <div class="mb-1">
    <h4><?= __('Značka', 'goshop'); ?></h4>
    <?php foreach($filter_options['manufacturers'] as $manufacturer){ ?>

      <div>
          <label for="manufacturer-<?= $manufacturer['term_id']; ?>">
              <input type="checkbox" class="filter-checkbox" term_type="manufacturer" term_name="<?= $manufacturer['name']; ?>" term_id="<?= $manufacturer['term_id']; ?>" id="manufacturer-<?= $manufacturer['term_id']; ?>" <?php if(isset($_GET['manufacturer']) and in_array($manufacturer['term_id'],$_GET['manufacturer']) ) echo 'checked'; ?>><?= $manufacturer['name']; ?>
          </label>
      </div>
  
    <?php } ?>
    </div>
  <?php } ?>
  
  
  <?php
  if($filter_options['product_attributes']){
   foreach($filter_options['product_attributes'] as $attr_slug=> $attribute){ ?>
  
    <div class="mb-1 filter-checkboxes">
      <h4><?= $attribute['label'] ?></h4>
      <?php foreach($attribute['values'] as $value_slug=>$value) { ?>
      <div>
        <label for="<?= $attr_slug;?>-<?= $value['attr_value_id']; ?>">
            <input type="checkbox" class="filter-checkbox" term_type="<?= $attr_slug ?>" term_name="<?= $value['attr_value']; ?>" term_id="<?= $value['attr_value_id']; ?>" id="<?= $attr_slug;?>-<?= $value['attr_value_id']; ?>" <?php if(isset($_GET[$attr_slug]) and in_array($value['attr_value_id'],$_GET[$attr_slug]) ) echo 'checked'; ?>><?= $value['attr_value']; ?> (<?= $value['attr_count'] ?>)
        </label>
      </div>
      <?php } ?>
    </div>
  
  <?php
      }
  }
  ?>

    <div class="js-remove-product-filter-options pointer"><small><?= __('Vymazať všetky filtre', 'goshop'); ?></small></div>

</div>
<div class="filter_prepare_line"></div>
