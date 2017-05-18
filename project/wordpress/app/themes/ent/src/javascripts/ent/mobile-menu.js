var $             = require('jquery');
var header        = $('[data-header-mobile');
var mobileMenu    = $('[data-mobile-menu]');
var hamburger     = $('[data-hamburger]');
var hamburgerIcon = $('[data-hamburger-icon]');
var noScrollClass = 'mobile-menu__no-scroll';
var VISIBLE       = 1;
var HIDDEN        = 0;

function getIconClass($id) {
    return hamburger.data('hamburger').split(',')[$id];
}

function setTopPadding() {
    var height = header.outerHeight();
    mobileMenu.css('padding-top', height);
}

function show() {
    setTopPadding();
    $('body').addClass(noScrollClass);
    mobileMenu.show();
    hamburgerIcon.attr('class', getIconClass(VISIBLE));
}

function hide() {
    $('body').removeClass(noScrollClass);
    mobileMenu.hide();
    hamburgerIcon.attr('class', getIconClass(HIDDEN));
}

function toggle() {
    if (mobileMenu.is(':visible')) {
        hide();
    } else {
        show();
    }
}

// EVENTS
hamburger.click(toggle);

$(window).on('changed.zf.mediaquery', function (e, size) {
    if (Foundation.MediaQuery.atLeast('large')) {
        hide();
    }

    setTopPadding();
});
