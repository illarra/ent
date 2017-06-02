var crypto = require('crypto');
var changeCase = require('change-case');
var slug = require('slug');
var fs = require('fs');

function isFunction(object) {
    var getType = {};
    return object && getType.toString.call(object) === '[object Function]';
}

module.exports = function (plop) {
    // Actions
    plop.setActionType('message', function (answers, config, plop) {
        let message;

        if (isFunction(config.message)) {
            message = config.message(answers, config, plop);
        } else {
            message = config.message;
        }

        if (message.length > 0) {
            console.log('');
            console.log('+'+ '-'.repeat(message.length + 2) + '+');
            console.log('| ' + message + ' |');
            console.log('+'+ '-'.repeat(message.length + 2) + '+');
            console.log('');
        }

        return '';
    });

    plop.setActionType('append', function (answers, config, plop) {
        let path = plop.renderString(config.path, answers);
        let template = plop.renderString(config.template, answers);
        let fileData = fs.readFileSync(path, { encoding: 'utf-8'});
        let append = config.append(fileData, answers, config, plop);
        
        if (append) {
            // Remove spaces & line-breaks from beggining and end of file
            fileData = fileData.replace(/^\s+|\s+$/g, '');

            if (config.sort || true) {
                // Split by lines, add new line & sort
                fileData = fileData.split(/\r?\n/g);
                fileData.push(template);
                fileData = fileData.sort();
                fileData = fileData.join("\n") +"\n";
            } else {
                fileData = fileData +"\n"+ template +"\n";
            }

            fs.writeFileSync(path, fileData);

            return '"'+ template +'" to '+ path;
        }

        return 'nothing to do';
    });

    // Handlebars
    plop.addHelper('concat', function (...args) {
        return args.splice(0, args.length - 1).join('');
    });

    plop.addHelper('not', function (a) {
        return !a;
    });

    plop.addHelper('equals', function (a, b) {
        return a === b;
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