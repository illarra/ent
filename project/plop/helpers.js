var crypto = require('crypto');
var changeCase = require('change-case');

module.exports = function (plop) {
    plop.addHelper('concat', function (...args) {
        return args.splice(0, args.length - 1).join('');
    });

    plop.addHelper('properSnakeCase', function (str) {
        return changeCase.snake(str).split('_').map(changeCase.ucFirst).join('_');
    });

    plop.addHelper('randomKey', function () {
        return crypto.randomBytes(32).toString('hex');
    });
};