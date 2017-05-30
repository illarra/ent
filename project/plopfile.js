module.exports = function (plop) {
    // Load helpers
    require('./plop/helpers')(plop);

    plop.setGenerator('component', {
        description: 'Generate VisualComposer (VC) component',
        prompts: [],
        actions: [],
    });

    plop.setGenerator('component-tpls', {
        description: 'Generate VC component templates (twig & admin) based on the defined fields',
        prompts: [],
        actions: [],
    });

    plop.setGenerator('widget', {
        description: 'Generate WordPress widget',
        prompts: [{
            type: 'input',
            name: 'name',
            message: 'Name:',
            validate: function (value) {
                if ((/.+/).test(value)) { return true; }
                return 'Name is required.';
            }
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
        description: 'Generate WordPress wp-config.php with random keys/salt',
        prompts: [],
        actions: [{
            type: 'modify',
            path: 'wordpress/wp-config.php',
            pattern: /([\s\S]*)/,
            templateFile: 'plop/wp-config/wp-config.hbs'
        }]
    });
};
