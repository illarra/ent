var $ = require('jquery');
var fixedEls = $('[data-fixed]');

// Functions
function init() {
    fixedEls.each(function () {
        var breakpoints = $(this).data('fixed').split(' ');
        
        // If "large" is defined as target then add also XL and XXL
        if (breakpoints.indexOf('large') != -1 && breakpoints.indexOf('xlarge') == -1) {
            breakpoints.push('xlarge');
        }
        
        if (breakpoints.indexOf('large') != -1 && breakpoints.indexOf('xxlarge') == -1) {    
            breakpoints.push('xxlarge');
        }
        
        $(this).data('fixed', breakpoints.join(' '));
        $(this).data('fixed-top', $(this).offset().top);
        
        $(this).removeClass('fixed__element');
    });
    
    removeClasses();
    checkScroll();
}

function removeClasses() {
    $('body').removeClass('fixed fixed--small fixed--medium fixed--large fixed--xlarge fixed--xxlarge');
}

function getFixedEl() {
    var fixed = null;
    
    fixedEls.each(function () {
        var breakpoints = $(this).data('fixed').split(' ');

        if (breakpoints.indexOf(Foundation.MediaQuery.current) != -1) {
            fixed = $(this);
        }
    });
    
    return fixed;
}

function checkScroll() {
    var el = getFixedEl();
    
    if (!el) {
        return;
    }
    
    if ($(window).scrollTop() > +el.data('fixed-top')) {
        $('body').addClass('fixed').addClass('fixed--'+ Foundation.MediaQuery.current);

        // Add large class also for xlarge & xxlarge
        if (Foundation.MediaQuery.atLeast('large')) {
            $('body').addClass('fixed--large');
        }
        
        el.addClass('fixed__element');
        $('main').css('marginTop', el.outerHeight());
    } else {
        removeClasses();
        el.removeClass('fixed__element');
        $('main').css('marginTop', '0');
    }
}

// Events
// Re-initialize on breakpoint change
$(window).on('changed.zf.mediaquery', function () {
    $(window).scrollTop(0);
    init();
});

$(window).on('scroll', checkScroll);

// Init
// Wait the event loop/repaint/whatever: http://stackoverflow.com/a/23254061/379923
// Otherwise Foundation.MediaQuery.current is not available
$(window).on('load', function () {
    window.requestAnimationFrame(init);
});
