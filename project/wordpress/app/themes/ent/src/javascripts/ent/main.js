var $ = require('jquery');
var unorphan = require('unorphan');

require('magnific-popup');
require('slick-carousel');
require('foundation-sites');

$(function () {
    // Init Foundation
    $(document).foundation();

    // Unorphan en medium o más
    if (Foundation.MediaQuery.atLeast('medium')) {
        unorphan($('h1, h2, h3, h4, h5, h6, blockquote, [data-unorphan]').not('[data-dont-unorphan]'));
    }

    // Load Ent modules
    require('./fixed.js');
    require('./mobile-menu.js');
    require('./media.js');
});
