(function() {
  'use strict';

  var globals = typeof global === 'undefined' ? self : global;
  if (typeof globals.require === 'function') return;

  var modules = {};
  var cache = {};
  var aliases = {};
  var has = {}.hasOwnProperty;

  var expRe = /^\.\.?(\/|$)/;
  var expand = function(root, name) {
    var results = [], part;
    var parts = (expRe.test(name) ? root + '/' + name : name).split('/');
    for (var i = 0, length = parts.length; i < length; i++) {
      part = parts[i];
      if (part === '..') {
        results.pop();
      } else if (part !== '.' && part !== '') {
        results.push(part);
      }
    }
    return results.join('/');
  };

  var dirname = function(path) {
    return path.split('/').slice(0, -1).join('/');
  };

  var localRequire = function(path) {
    return function expanded(name) {
      var absolute = expand(dirname(path), name);
      return globals.require(absolute, path);
    };
  };

  var initModule = function(name, definition) {
    var hot = hmr && hmr.createHot(name);
    var module = {id: name, exports: {}, hot: hot};
    cache[name] = module;
    definition(module.exports, localRequire(name), module);
    return module.exports;
  };

  var expandAlias = function(name) {
    return aliases[name] ? expandAlias(aliases[name]) : name;
  };

  var _resolve = function(name, dep) {
    return expandAlias(expand(dirname(name), dep));
  };

  var require = function(name, loaderPath) {
    if (loaderPath == null) loaderPath = '/';
    var path = expandAlias(name);

    if (has.call(cache, path)) return cache[path].exports;
    if (has.call(modules, path)) return initModule(path, modules[path]);

    throw new Error("Cannot find module '" + name + "' from '" + loaderPath + "'");
  };

  require.alias = function(from, to) {
    aliases[to] = from;
  };

  var extRe = /\.[^.\/]+$/;
  var indexRe = /\/index(\.[^\/]+)?$/;
  var addExtensions = function(bundle) {
    if (extRe.test(bundle)) {
      var alias = bundle.replace(extRe, '');
      if (!has.call(aliases, alias) || aliases[alias].replace(extRe, '') === alias + '/index') {
        aliases[alias] = bundle;
      }
    }

    if (indexRe.test(bundle)) {
      var iAlias = bundle.replace(indexRe, '');
      if (!has.call(aliases, iAlias)) {
        aliases[iAlias] = bundle;
      }
    }
  };

  require.register = require.define = function(bundle, fn) {
    if (bundle && typeof bundle === 'object') {
      for (var key in bundle) {
        if (has.call(bundle, key)) {
          require.register(key, bundle[key]);
        }
      }
    } else {
      modules[bundle] = fn;
      delete cache[bundle];
      addExtensions(bundle);
    }
  };

  require.list = function() {
    var list = [];
    for (var item in modules) {
      if (has.call(modules, item)) {
        list.push(item);
      }
    }
    return list;
  };

  var hmr = globals._hmr && new globals._hmr(_resolve, require, modules, cache);
  require._cache = cache;
  require.hmr = hmr && hmr.wrap;
  require.brunch = true;
  globals.require = require;
})();

(function() {
var global = typeof window === 'undefined' ? this : window;
var process;
var __makeRelativeRequire = function(require, mappings, pref) {
  var none = {};
  var tryReq = function(name, pref) {
    var val;
    try {
      val = require(pref + '/node_modules/' + name);
      return val;
    } catch (e) {
      if (e.toString().indexOf('Cannot find module') === -1) {
        throw e;
      }

      if (pref.indexOf('node_modules') !== -1) {
        var s = pref.split('/');
        var i = s.lastIndexOf('node_modules');
        var newPref = s.slice(0, i).join('/');
        return tryReq(name, newPref);
      }
    }
    return none;
  };
  return function(name) {
    if (name in mappings) name = mappings[name];
    if (!name) return;
    if (name[0] !== '.' && pref) {
      var val = tryReq(name, pref);
      if (val !== none) return val;
    }
    return require(name);
  }
};
require.register("ent/fixed.js", function(exports, require, module) {
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

});

require.register("ent/main.js", function(exports, require, module) {
var $ = require('jquery');

require('magnific-popup');
require('slick-carousel');
require('foundation-sites');

$(function () {
    // Init Foundation
    $(document).foundation();

    // Unorphan en medium o más
    if (Foundation.MediaQuery.atLeast('medium')) {
        unorphan($('h1, h2, h3, h4, blockquote, [data-unorphan]').not('[data-dont-unorphan]'));
    }

    // Load Ent modules
    require('./fixed.js');
    require('./mobile-menu.js');
    require('./media.js');
});

});

require.register("ent/media.js", function(exports, require, module) {
var $ = require('jquery');

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

});

require.register("ent/mobile-menu.js", function(exports, require, module) {
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

});

require.register("main.js", function(exports, require, module) {
var $ = require('jquery');

require('ent/main.js');

$(function () {
    //require('./foo.js');
});


});

require.alias("process/browser.js", "process");process = require('process');require.register("___globals___", function(exports, require, module) {
  

// Auto-loaded modules from config.npm.globals.
window.jQuery = require("jquery");
window.unorphan = require("unorphan");


});})();require('___globals___');


//# sourceMappingURL=main.js.map