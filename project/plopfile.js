let validate = require('./plop/validate');

module.exports = function (plop) {
    // Load helpers
    require('./plop/helpers')(plop);

    plop.setGenerator('component', {
        description: 'VisualComposer (VC) component',
        prompts: [],
        actions: [],
    });

    /*
    plop.setGenerator('component-tpls', {
        description: 'VC component templates (twig & admin) based on the defined fields',
        prompts: [],
        actions: [],
    });
    */

    plop.setGenerator('post-type', {
        description: 'WordPress post type',
        prompts: [{
            type: 'input',
            name: 'name',
            message: 'Name:',
            validate: validate(['required', 'Name is required.']),
        }, {
            type: 'input',
            name: 'plural',
            message: 'Plural label:',
            validate: validate(['required', '"Plural label" is required.']),
        }, {
            type: 'input',
            name: 'singular',
            message: 'Singular label:',
            validate: validate(['required', '"Singular label" is required.']),
        }, {
            type: 'confirm',
            name: 'enable_vc',
            message: 'Enable VisualComposer:',
            default: false,
        }, {
            type: 'checkbox',
            name: 'supports',
            message: 'Select supported post type features:',
            // Avaliable supports: 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'
            // Default supports: 'title', 'editor'
            choices: [
                { name: 'title',     checked: true },
                { name: 'editor',    checked: true },
                { name: 'thumbnail', checked: false },
                { name: 'excerpt',   checked: false },
                { name: 'revisions', checked: false },
            ]
        }],
        actions: [{
            type: 'add',
            path: 'wordpress/app/themes/ent/src/post-types/{{ dashCase name }}.php',
            templateFile: 'plop/post-type/post-type.hbs'
        }],
    });

    plop.setGenerator('post-type:news', {
        description: 'WordPress News post type. Useful when blog posts and news need to be separated.',
        prompts: [],
        actions: [{
            type: 'add',
            path: 'wordpress/app/themes/ent/src/post-types/news.php',
            templateFile: 'plop/post-type-news/news.hbs'
        }]
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
