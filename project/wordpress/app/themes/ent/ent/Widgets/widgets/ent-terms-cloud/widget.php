<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Terms_Cloud extends \Ent\Widgets\Widget {
    protected function get_definition() {
        $options = $this->get_taxonomies();

        if (array_key_exists('post_tag', $options)) {
            $default = 'post_tag';
        } else {
            $default = current(array_keys($options));
        }

        return [
            'title' => 'Terms Cloud',
            'description' => 'Taxonomy terms cloud.',
            'fields' => [
                Field::make('select', 'taxonomy', 'Taxonomy')
                    ->set_default_value($default)
                    ->set_options($options),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        $taxonomy_exists = $this->taxonomy_exists($fields['taxonomy']);
        $terms_cloud = wp_tag_cloud([
            'taxonomy' => $fields['taxonomy'],
            'format'   => 'array',
            'echo'     => false,
            'smallest' => 1,
            'largest'  => 1.75,
            'unit'     => 'em',
        ]);

        return [
            'taxonomy_exists' => $taxonomy_exists,
            'terms_cloud'     => $terms_cloud,
        ];
    }

    protected function get_taxonomies() {
        $taxonomies = get_taxonomies(['show_tagcloud' => true], 'object');
        $options = [];

        foreach ($taxonomies as $taxonomy) {
            $options[$taxonomy->name] = $taxonomy->label;
        }

        return $options;
    }

    protected function taxonomy_exists($taxonomy) {
        if (empty(trim($taxonomy))) {
            return false;
        } else {
            return taxonomy_exists($taxonomy);
        }
    }
}
