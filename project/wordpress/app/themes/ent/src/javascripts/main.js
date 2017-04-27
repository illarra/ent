var $ = require('jquery');

require('magnific-popup');
//require('munger');
require('foundation-sites');

$(function () {
    // Init Foundation
    $(document).foundation();

    // Unorphan en medium o más
    if (Foundation.MediaQuery.atLeast('medium')) {
        unorphan($('h1, h2, h3, h4, blockquote, [data-unorphan]').not('[data-dont-unorphan]'));
    }

    // Resources
    if (!!$('[data-res-view]').length) {
        console.log('whatever');
        //require('js/resources.js');
    }

    require('test.js');
});
