let validate = require('./plop/validate');

module.exports = function (plop) {
    // Load helpers
    require('./plop/helpers')(plop);

    plop.setGenerator('component', {
        description: 'VisualComposer (VC) component',
        prompts: [],
        actions: [],
    });

    plop.setGenerator('component-tpls', {
        description: 'VC component templates (twig & admin) based on the defined fields',
        prompts: [],
        actions: [],
    });

    plop.setGenerator('widget', {
        description: 'WordPress widget',
        prompts: [{
            type: 'input',
            name: 'name',
            message: 'Name:',
            validate: validate(['required', 'Name is required.']),
        }],
        actions: [{
            type: 'add',
            path: 'wordpress/app/themes/ent/src/widgets/{{ dashCase name }}/widget.php',
            templateFile: 'plop/widget/widget.hbs'
        }, {
            type: 'add',
            path: 'wordpress/app/themes/ent/src/widgets/{{ dashCase name }}/template.twig',
            templateFile: 'plop/widget/template.hbs'
        }]
    });

    plop.setGenerator('wp-config', {
        description: 'WordPress wp-config.php with random keys/salt',
        prompts: [],
        actions: [{
            type: 'modify',
            path: 'wordpress/wp-config.php',
            pattern: /([\s\S]*)/,
            templateFile: 'plop/wp-config/wp-config.hbs'
        }]
    });
};
