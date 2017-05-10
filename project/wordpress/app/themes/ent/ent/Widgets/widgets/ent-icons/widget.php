<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Icons extends \Ent\Widgets\Widget {
    protected function get_definition() {
        return [
            'title' => 'Icons',
            'description' => 'Icons. Useful for social media icons.',
            'fields' => [
                Field::make('textarea', 'icons', 'Icons')->help_text('Format, per row: <code>icon-name: URL</code>.'),
            ],
        ];
    }

    protected function parse_icons_field($text) {
        $rows = explode("\n", $text);
        $icons = array_map(function ($row) {
            $icon = explode(':', $row);

            return [
                'name' => array_shift($icon),
                'url'  => trim(implode(':', $icon)),
            ];
        }, $rows);

        return $icons;
    }

    protected function get_context_data($fields, $config) {
        return [
            'icons' => $this->parse_icons_field($fields['icons']),
        ];
    }
}
