var $           = require('jquery');
var unorphan    = require('unorphan');
var selector    = 'h1, h2, h3, h4, h5, h6, blockquote, [data-unorphan], [data-unorphan] *';
var notSelector = '[data-dont-unorphan]';

// Unorphan en medium o más
if (Foundation.MediaQuery.atLeast('medium')) {
    unorphan($(selector).not(notSelector));
}
