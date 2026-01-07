/**
 * Main Theme JS
 * Banner Slider & Video Slider
 */
jQuery(document).ready(function($) {
    
    // ========================================
    // BANNER SLIDER
    // ========================================
    var $bannerSlider = $('.banner-slider');
    
    if ($bannerSlider.length) {
        var $slides = $bannerSlider.find('.slide');
        var $dots = $bannerSlider.find('.dot');
        var $prevBtn = $bannerSlider.find('.slider-prev');
        var $nextBtn = $bannerSlider.find('.slider-next');
        var currentIndex = 0;
        var slideCount = $slides.length;
        var autoPlayInterval;
        
        function goToSlide(index) {
            if (index < 0) index = slideCount - 1;
            if (index >= slideCount) index = 0;
            
            currentIndex = index;
            
            $slides.removeClass('active');
            $slides.eq(currentIndex).addClass('active');
            
            $dots.removeClass('active');
            $dots.eq(currentIndex).addClass('active');
        }
        
        function nextSlide() {
            goToSlide(currentIndex + 1);
        }
        
        function prevSlide() {
            goToSlide(currentIndex - 1);
        }
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 5000);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        $nextBtn.on('click', function() {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
        
        $prevBtn.on('click', function() {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
        
        $dots.on('click', function() {
            stopAutoPlay();
            goToSlide($(this).data('index'));
            startAutoPlay();
        });
        
        if (slideCount > 1) {
            startAutoPlay();
        }
        
        $bannerSlider.on('mouseenter', stopAutoPlay);
        $bannerSlider.on('mouseleave', function() {
            if (slideCount > 1) startAutoPlay();
        });
    }
    
    // ========================================
    // VIDEO SLIDER - Trượt từng 1 item
    // ========================================
    var $videoSlider = $('.video-slider');
    
    if ($videoSlider.length) {
        var $track = $videoSlider.find('.video-track');
        var $items = $track.find('.video-item');
        var $prevBtn = $('.video-prev');
        var $nextBtn = $('.video-next');
        var itemCount = $items.length;
        var currentPos = 0;
        var visibleItems = 3; // Hiện 3 items
        
        // Tính số items hiển thị dựa vào màn hình
        function getVisibleItems() {
            var width = $(window).width();
            if (width <= 768) {
                return 1;
            } else if (width <= 1024) {
                return 2;
            }
            return 3;
        }
        
        // Tính width của 1 item (bao gồm gap)
        function getItemWidth() {
            var item = $items.first();
            return item.outerWidth(true);
        }
        
        // Move slider - chỉ trượt 1 item mỗi lần
        function moveSlider(direction) {
            visibleItems = getVisibleItems();
            var maxPos = Math.max(0, itemCount - visibleItems);
            
            if (direction === 'next' && currentPos < maxPos) {
                currentPos++;
            } else if (direction === 'prev' && currentPos > 0) {
                currentPos--;
            }
            
            var offset = -currentPos * getItemWidth();
            $track.css('transform', 'translateX(' + offset + 'px)');
            
            // Update nav button styles
            $prevBtn.css('opacity', currentPos === 0 ? 0.3 : 1);
            $nextBtn.css('opacity', currentPos >= maxPos ? 0.3 : 1);
        }
        
        $nextBtn.on('click', function() {
            moveSlider('next');
        });
        
        $prevBtn.on('click', function() {
            moveSlider('prev');
        });
        
        // Initialize
        visibleItems = getVisibleItems();
        $prevBtn.css('opacity', 0.3);
        if (itemCount <= visibleItems) {
            $nextBtn.css('opacity', 0.3);
        }
        
        // Reset on resize
        $(window).on('resize', function() {
            visibleItems = getVisibleItems();
            var maxPos = Math.max(0, itemCount - visibleItems);
            if (currentPos > maxPos) {
                currentPos = maxPos;
            }
            var offset = -currentPos * getItemWidth();
            $track.css('transform', 'translateX(' + offset + 'px)');
            
            $prevBtn.css('opacity', currentPos === 0 ? 0.3 : 1);
            $nextBtn.css('opacity', currentPos >= maxPos ? 0.3 : 1);
        });
    }
    
});
