<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Twitter extends \Ent\Widgets\Widget {
    protected function get_definition() {
        return [
            'title' => 'Twitter',
            'description' => 'Twitter embed widget. See: https://publish.twitter.com',
            'fields' => [
                Field::make('text', 'url', 'Twitter URL'),
                Field::make('text', 'width', 'Width'),
                Field::make('text', 'height', 'Height')->set_default_value(400),
                Field::make('color', 'link_color', 'Link color'),
                Field::make('checkbox', 'use_dark_theme', 'Use dark theme?'),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        return [
            'locale' => ICL_LANGUAGE_CODE,
            'width'  => empty($fields['width']) ? null : $fields['width'],
            'height' => empty($fields['height']) ? null : $fields['height'],
            'color'  => empty($fields['color']) ? null : $fields['color'],
            'theme'  => $fields['use_dark_theme'] ? 'dark' : null,
        ];
    }
}
