const fs = require('fs');

module.exports.getComponents = function (config, inquirer) {
    let choices = [];

    config.forEach(entry => {
        const [title, path] = entry;

        choices.push(new inquirer.Separator(title));

        fs.readdirSync(path).forEach(file => {
            choices.push({
                value: file,
                checked: false,
            });
        });
    });

    return choices;
};
