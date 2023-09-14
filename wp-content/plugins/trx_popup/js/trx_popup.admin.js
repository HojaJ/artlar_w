jQuery(document).ready(function(){
    'use strict';

    var trx_popup_form = jQuery('.trx_popup_options_form');
    trx_popup_form.find('form .form-table').each( function(e) {
        jQuery(this).wrap('<div class="form-table-wrap"></div>');
    });

    trx_popup_form.find('form h2').on( 'click', function(e) {
        jQuery(this).find('+ .form-table-wrap').slideToggle('500');
    });

    trx_popup_form.find('.upload_image_button').on( 'click', function(e) {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = jQuery(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            button.parent().prev().attr('src', attachment.url);
            button.prev().val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open(button);
        trx_popup_form.find('.upload > img').removeClass('hide').show();
        e.preventDefault();
        return false;
    });

    trx_popup_form.find('.remove_image_button').on( 'click', function(e) {
        var button = jQuery(this);
        trx_popup_form.find('.upload > img').hide();
        trx_popup_form.find('#trx_popup_options_image').val('');
        e.preventDefault();
        return false;
    });

     trx_popup_form.find('[type="checkbox"]').on( 'change', function(e) {
        if ( jQuery(this).prop('checked') ) {
            jQuery(this).val('checked');
        } else {
            jQuery(this).val('');
        }
    });

    trx_popup_form.find('input[type="range"]').on( 'change', function(e) {
        trx_popup_range_runner_pos(jQuery(this));
    });

    trx_popup_form.find('input[type="range"]').each( function(e) {
        trx_popup_range_runner_pos(jQuery(this));
    });
});

function trx_popup_range_runner_pos(container) {
    'use strict';

    var val = container.val();
    var max = container.attr('max');
    var x = val * 100 / max;
    var y = x / (-10);
    container.next().css({'left': x + '%', 'margin-left': y + '%'});
    container.next().text(val);
}