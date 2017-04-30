<?php
namespace Ent\ThemeOptions;

use \Carbon_Fields\Field;

class Options extends \Ent\ThemeOptions {
    protected function define_custom_fields($container) {
        $container->add_fields([
            Field::make('text', 'random', 'Random thing'),
            Field::make('checkbox', 'checkbox', 'Checkbox'),
            Field::make('image', 'logo', 'Logo'),
            Field::make('complex', 'complex', 'Complex')->add_fields([
                Field::make('text', 'title', 'Title'),
                Field::make('checkbox', 'checkbox', 'Checkbox'),
            ]),
        ]);
    }
}
