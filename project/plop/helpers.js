var crypto = require('crypto');

module.exports = function (plop) {
	plop.addHelper('concat', function (...args) {
        return args.splice(0, args.length - 1).join('');
    });

    plop.addHelper('randomKey', function () {
        return crypto.randomBytes(32).toString('hex');
    });
};