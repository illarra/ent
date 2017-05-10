<?php
namespace Ent\Term;

use Carbon_Fields\Field;
use Ent\CarbonFields\Field as EntField;

class Area extends \Ent\Term {
    public static function register() {
        // See: https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
        return [
            'post_types' => ['post', 'news'],
            'labels' => [
                'name' => 'Àrees',
            ],
            'rewrite' => ['slug' => 'area'],
            'show_ui' => true,
            'show_tagcloud' => true,
            'show_in_menus' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'has_archive' => false,
        ];
    }

    protected static function define_custom_fields($container) {
        $container->add_fields([
        ]);
    }
}
