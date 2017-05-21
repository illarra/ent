var $ = require('jquery');

require('magnific-popup');

$('[data-media-popup]').magnificPopup({ type: 'image' });
$('[data-media-gallery]').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true,
        }
    });
});
