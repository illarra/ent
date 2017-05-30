var crypto = require('crypto');
var changeCase = require('change-case');
var slug = require('slug');

module.exports = function (plop) {
    plop.addHelper('concat', function (...args) {
        return args.splice(0, args.length - 1).join('');
    });

    plop.addHelper('phpBool', function (value) {
        return value ? 'true' : 'false';
    });

    plop.addHelper('phpArray', function (value) {
        return JSON.stringify(value).replace(/","/g, '", "').replace(/"/g, "'");
    });

    plop.addHelper('properSnakeCase', function (str) {
        return changeCase.snake(str).split('_').map(changeCase.ucFirst).join('_');
    });

    plop.addHelper('randomKey', function () {
        return crypto.randomBytes(32).toString('hex');
    });

    plop.addHelper('slug', function (str) {
        return slug(str, { lower: true });
    });

    plop.addHelper('ucFirst', function (str) {
        return changeCase.ucFirst(str);
    });
};