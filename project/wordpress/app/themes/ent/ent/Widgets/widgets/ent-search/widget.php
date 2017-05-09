<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class ent_search extends \Ent\Widgets\Widget {
    protected function get_definition() {
        return [
            'title' => 'Search',
            'description' => 'Compact search form.',
            'fields' => [
                Field::make('checkbox', 'show_placeholder_text', 'Show placeholder text'),
                Field::make('checkbox', 'show_search_button', 'Show search button'),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        return [
            'show_placeholder_text' => $fields['show_placeholder_text'] == 'yes',
            'show_search_button'    => $fields['show_search_button'] == 'yes',
        ];
    }
}
