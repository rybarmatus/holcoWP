<script>
jQuery(document).ready(function($){
    var custom_uploader,
        target = jQuery('input[name="option_logo"]'),
        image = jQuery('.logo');
      
    $('.upload_logo').click(function(e) {
        
        var dis = $(this);
        var type =  dis.attr('data');
        
        $('#helper').val(type);
        
        e.preventDefault();
        
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?= __('Choose Image') ?>',
            button: {
                text: '<?= __('Choose Image') ?>'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
           
            attachment = custom_uploader.state().get('selection').first().toJSON();
            type = $('#helper').val();
            $('input.option_logo[data="'+ type +'"]').val(attachment.url);
            $('img.logo[data="'+ type +'"]').attr('src', attachment.url);
        });
        custom_uploader.open();
    });
});
</script>