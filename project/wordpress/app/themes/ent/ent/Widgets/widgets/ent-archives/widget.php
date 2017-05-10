<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Archives extends \Ent\Widgets\Widget {
    protected function get_definition() {
        return [
            'title' => 'Archives',
            'description' => 'Post archives.',
            'fields' => [
                Field::make('checkbox', 'count', 'Show post counts'),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        $count = $fields['count'] == 'yes';

        // Echo & capture archive list
        ob_start();

        wp_get_archives([
            'type'            => 'monthly',
            'show_post_count' => $count,
            'format'          => 'custom',
            'before'          => '<li>',
            'after'           => '</li>',
        ]);

        $li_html = ob_get_clean();

        return [
            'li_html' => $li_html,
        ];
    }
}
