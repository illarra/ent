<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Text extends \Ent\Widgets\Widget {
    protected function get_definition() {
        return [
            'title' => 'Text',
            'description' => 'Text or HTML.',
            'fields' => [
                Field::make('textarea', 'content', 'Content'),
                Field::make('checkbox', 'wpautop', 'Automatically add paragraphs'),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        return [];
    }
}
