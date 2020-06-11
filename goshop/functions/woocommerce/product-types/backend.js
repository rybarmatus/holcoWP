jQuery( document ).ready( function($) {

  jQuery(document).on('click', '.woocommerce_variation', function(){
      bundle_arrange();
   })

    var bundle_timeout = null;
    
    
    if( jQuery('#product-type').val() == 'bundle'   ){
      $('.product_data_tabs .general_options').show();
      $('.product_data_tabs .general_options a').click();
    }
    jQuery( '.options_group.pricing' ).removeClass('hidden').addClass( 'show_if_bundle' ).show();
    jQuery( '._manage_stock_field' ).removeClass('hidden').addClass( 'show_if_bundle' ).show();
    
    
    jQuery('#product-type').change(function(){
        
        if($(this).val() == 'gift' ){
            $('#_regular_price').val(0);
        }
    })
    
    
    
    // change qty of each item
  $(document).on('keyup change', '.bundle_selected .qty input', function() {
    
    var parent = $(this).closest('.bundle-wrapper');
    bundle_get_ids();
    /* woosb_change_regular_price(); */
    return false;
  });
 
    
  
   $(document).on('keyup focus', '.bundle_search', function() {
        
    if ($(this).val() != '' && $(this).val().length > 2) {
      
      $('.bundle_loading').show();
      if (bundle_timeout != null) {
        clearTimeout(bundle_timeout);
      }
      bundle_timeout = setTimeout(bundle_ajax_get_data($(this)), 300);
      return false;
    }else{
        var parent = $(this).closest('.bundle-wrapper');
        $('.bundle_results', parent).hide();
    }
  
  });
  
  $(document).on('click', '.bundle_selected span.remove', function() {
    var parent = $(this).parents('.bundle-wrapper');
    
    $(this).parent('li').remove();
    
    
    bundle_get_ids();
    bundle_arrange();
    /*
    bundle_change_regular_price();
    */
    return false;
  });
  
  
// actions on search result items
  $(document).on('click', '.bundle_results li', function() {
    
    $(this).children('span.remove').attr('aria-label', 'Remove').html('×');
    var parent = $(this).closest('.bundle-wrapper');
    
    $('.bundle_selected ul', parent).append($(this));
    $('.bundle_results', parent).hide();
    // $('.bundle_keyword', parent).val('');
    bundle_get_ids();
    bundle_arrange();  
    
    /*
    bundle_change_regular_price();
    */ 
    return false;
  });
    
   
    
});

 jQuery(document).on('bundle_drag_event', function() {
    bundle_get_ids();
  });

function bundle_arrange() {
    jQuery('.bundle_selected li').arrangeable({
      dragEndEvent: 'bundle_drag_event',
      dragSelector: '.move',
    });
  }



function bundle_ajax_get_data(this_search_input) {
  
  var parent = this_search_input.closest('.bundle-wrapper');
  
  // ajax search product
  bundle_timeout = null;
  var data = {
    action: 'bundle_get_search_results',
    keyword: this_search_input.val(),
    ids: jQuery('.bundle_ids', parent).val(),
  };
  jQuery.post(ajaxurl, data, function(response) {
    jQuery('.bundle_results', parent).show();
    jQuery('.bundle_results', parent).html(response);
    jQuery('.bundle_loading', parent).hide();
  });
}

  function bundle_get_ids() {
    
    jQuery('.bundle-wrapper').each(function(){
        var parent = jQuery(this);
        var listId = new Array();
        jQuery('.bundle_selected li', parent).each(function() {
          listId.push(jQuery(this).data('id') + '/' + jQuery(this).find('input').val());
        });
        if (listId.length > 0) {
          jQuery('.bundle_ids', parent).val(listId.join(','));
        } else {
          jQuery('.bundle_ids', parent).val('');
        }
        
    
    })
  }