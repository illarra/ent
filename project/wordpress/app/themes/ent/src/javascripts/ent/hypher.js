import $ from 'jquery';

const lang = $('html').attr('lang');

try {
    require('hypher/dist/jquery.hypher.js');
    require(`./hypher/${lang}`);
    $('[data-hyphenate], [data-hyphenate] *').hyphenate(lang);
} catch (e) {}
