const validate = require('./plop/validate');
const utils = require('./plop/utils');
const path = require('path');
const componentPaths = [
    ['Theme components:', path.resolve('./wordpress/app/themes/ent/src/components')],
    ['Ent components:',   path.resolve('./wordpress/app/themes/ent/ent/VisualComposer/components')],
];

module.exports = function (plop) {
    // Load helpers
    require('./plop/helpers')(plop);

    plop.setGenerator('component', {
        description: 'VisualComposer (VC) component',
        prompts: [{
            type: 'input',
            name: 'name',
            message: 'Name:',
            validate: validate(['required', 'Name is required.']),
        }, {
            type: 'list',
            name: 'type',
            message: 'Select component type:',
            choices: [
                { name: 'Regular',            value: 'regular' },
                { name: 'Container (parent)', value: 'container' },
                { name: 'Container (child)',  value: 'child' },
            ]
        }, {
            type: 'confirm',
            name: 'is_layout',
            message: 'Is a layout component? (top level row component)',
            default: true,
            when: function (answers) {
                return answers.type !== 'child';
            }
        }, {
            type: 'checkbox',
            name: 'relatives',
            choices: utils.getComponents(componentPaths, plop.inquirer),
            message: function (answers) {
                if (answers.type == 'container') {
                    return 'Select allowed child components:';
                } else {
                    return 'Select allowed parent components:';
                }
            },
            when: function (answers) {
                return answers.type !== 'regular';
            }
        }],
        actions: [{
            type: 'add',
            path: 'wordpress/app/themes/ent/src/components/{{ dashCase name }}/admin.html',
            templateFile: 'plop/component/admin.hbs'
        }, {
            type: 'add',
            path: 'wordpress/app/themes/ent/src/components/{{ dashCase name }}/component.php',
            templateFile: 'plop/component/component.hbs'
        }, {
            type: 'add',
            path: 'wordpress/app/themes/ent/src/components/{{ dashCase name }}/style.scss',
            templateFile: 'plop/component/style.hbs'
        }, {
            type: 'add',
            path: 'wordpress/app/themes/ent/src/components/{{ dashCase name }}/template.twig',
            templateFile: 'plop/component/template.hbs'
        }, {
            type: 'append',
            path: 'wordpress/app/themes/ent/src/scss/_components.scss',
            template: "@import '../components/{{ dashCase name }}/style';",
            sort: true,
            append: function (fileData, answers, config, plop) {
                let name = plop.renderString('components/{{ dashCase name }}/style', answers);

                return !(new RegExp(name, 'gi')).test(fileData);
            }
        }, {
            type: 'message',
            message: function (answers) {
                switch (answers.type) {
                    case 'regular':
                        return '';
                    case 'container':
                        return 'Remember to update child components $parents array';
                    case 'child':
                        return 'Remember to update parent components $children array';
                }
            }
        }]
    });

    /*
    plop.setGenerator('component-tpls', {
        description: 'VC component templates (twig & admin) based on the defined fields',
        prompts: [],
        actions: [],
    });
    */

    plop.setGenerator('post-type', {
        description: 'WordPress custom post type',
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
                { name: 'Title',          value: 'title',     checked: true },
                { name: 'Content',        value: 'editor',    checked: true },
                { name: 'Featured image', value: 'thumbnail', checked: false },
                { name: 'Excerpt',        value: 'excerpt',   checked: false },
                { name: 'Revisions',      value: 'revisions', checked: false },
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

    plop.setGenerator('taxonomy', {
        description: 'WordPress taxonomy term.',
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
