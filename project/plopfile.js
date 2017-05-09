module.exports = function (plop) {
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
};
