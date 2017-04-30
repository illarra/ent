<?php
namespace Ent\CPT;

use Carbon_Fields\Field;
use Ent\CarbonFields\Field as EntField;

class Article extends \Ent\CPT {
    public static function register() {
        // See: https://codex.wordpress.org/Function_Reference/register_post_type#Arguments
        return [
            'labels' => [
                'name'          => 'Notícies',
                'singular_name' => 'Notícia',
            ],
            'add_support'    => ['thumbnail'],
            'remove_support' => [],
            'taxonomies'     => ['category', 'post_tag', 'fa_area'],
            'rewrite'        => ['slug' => 'noticies'],
            'public'         => true,
            'has_archive'    => true,
            'menu_position'  => 4,
        ];
    }

    protected static function define_custom_fields($container) {
        $container->add_fields([
            Field::make('text', 'author', 'Autor'),
        ]);
    }
}
