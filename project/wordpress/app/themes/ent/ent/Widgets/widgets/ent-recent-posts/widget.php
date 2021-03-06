<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Recent_Posts extends \Ent\Widgets\Widget {
    protected $post_count = 5;

    protected function get_definition() {
        $options = $this->get_post_types();
        $default = $this->get_default_post_type($options);

        return [
            'title' => 'Recent Posts',
            'description' => 'Recent posts list.',
            'fields' => [
                Field::make('select', 'post_type', 'Post type')
                    ->set_default_value($default)
                    ->set_options($options),
                Field::make('text', 'number', 'Number of posts to show')->set_default_value($this->post_count),
                Field::make('checkbox', 'show_date', 'Display post date?'),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        $number = trim($fields['number']);
        $number = empty($number) ? $this->post_count : (int) $number;

        $posts = \Timber::get_posts([
            'post_type'           => $fields['post_type'],
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ]);

        return [
            'posts' => $posts,
            'show_date' => $fields['show_date'] == 'yes',
        ];
    }

    protected function get_default_post_type($post_types) {
        if (array_key_exists('post', $post_types)) {
            return 'post';
        } else {
            return current(array_keys($post_types));
        }
    }

    protected function get_post_types() {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];

        foreach ($post_types as $type => $entry) {
            $options[$type] = $entry->label;
        }

        return $options;
    }
}
