<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Test_Widget extends \Ent\Widgets\Widget {
    protected function get_definition() {
        return [
            'title' => 'Theme Widget - Example',
            'description' => 'Displays a block with title/text',
            'fields' => [
                Field::make('text', 'title', 'Title')->set_default_value('Hello World!'),
                Field::make('textarea', 'content', 'Content')->set_default_value('Lorem Ipsum dolor sit amet')
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        return [
            'prueba' => 'iepe!!',
        ];
    }
}
