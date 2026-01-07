/**
 * Admin Theme Options Script
 */
jQuery(document).ready(function($) {
    
    // ========================================
    // IMAGE UPLOAD
    // ========================================
    $(document).on('click', '.upload-image-btn', function(e) {
        e.preventDefault();
        
        // Support both .image-upload-wrap and .image-upload-field classes
        var $wrap = $(this).closest('.image-upload-wrap, .image-upload-field');
        var $input = $wrap.find('.image-id-input');
        var $preview = $wrap.find('.image-preview');
        var $removeBtn = $wrap.find('.remove-image-btn');
        
        var mediaUploader = wp.media({
            title: 'Chọn hình ảnh',
            button: {
                text: 'Chọn'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $input.val(attachment.id);
            $preview.html('<img src="' + attachment.url + '" alt="" style="max-width:200px;">').css({
                'border-style': 'solid',
                'border-color': '#2271b1'
            });
            $removeBtn.show();
        });
        
        mediaUploader.open();
    });
    
    // Remove Image
    $(document).on('click', '.remove-image-btn', function(e) {
        e.preventDefault();
        
        // Support both .image-upload-wrap and .image-upload-field classes
        var $wrap = $(this).closest('.image-upload-wrap, .image-upload-field');
        var $input = $wrap.find('.image-id-input');
        var $preview = $wrap.find('.image-preview');
        
        $input.val('');
        $preview.html('').css({
            'border-style': 'dashed',
            'border-color': '#c3c4c7'
        });
        $(this).hide();
    });
    
    // ========================================
    // REPEATER (Generic)
    // ========================================
    var repeaterIndexes = {};
    
    // Initialize indexes for each container
    $('[id$="-container"]').each(function() {
        var containerId = $(this).attr('id');
        repeaterIndexes[containerId] = $(this).find('.repeater-item').length;
    });
    
    // Add new repeater item
    $(document).on('click', '.add-repeater-btn', function() {
        var targetId = $(this).data('target');
        var templateId = $(this).data('template');
        var $container = $('#' + targetId);
        var $template = $('#' + templateId);
        
        if (!$container.length || !$template.length) return;
        
        // Get current index
        if (!repeaterIndexes[targetId]) {
            repeaterIndexes[targetId] = 0;
        }
        var index = repeaterIndexes[targetId];
        
        // Get template and replace placeholders
        var template = $template.html();
        template = template.replace(/\{\{INDEX\}\}/g, index);
        template = template.replace(/\{\{INDEX_DISPLAY\}\}/g, index + 1);
        
        $container.append(template);
        repeaterIndexes[targetId]++;
        
        updateRepeaterNumbers($container);
    });
    
    // Remove repeater item
    $(document).on('click', '.remove-repeater-btn', function() {
        if (confirm('Bạn có chắc muốn xóa mục này?')) {
            var $item = $(this).closest('.repeater-item');
            var $container = $item.parent();
            
            $item.fadeOut(300, function() {
                $(this).remove();
                updateRepeaterNumbers($container);
            });
        }
    });
    
    // Update numbers
    function updateRepeaterNumbers($container) {
        $container.find('.repeater-item').each(function(index) {
            var $numberSpan = $(this).find('.slide-number');
            var text = $numberSpan.text();
            // Extract prefix (Slide, Video, etc.)
            var prefix = text.replace(/#\d+/, '').trim();
            $numberSpan.text(prefix + '#' + (index + 1));
        });
    }
    
});
