var $ = require('jquery');

require('slick-carousel');
require('foundation-sites');

$(function () {
    // Init Foundation
    $(document).foundation();

    // Load Ent modules
    require('./fixed.js');
    require('./hypher.js');
    require('./mobile-menu.js');
    require('./media.js');
    require('./unorphan.js');
});
