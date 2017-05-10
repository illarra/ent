<?php
namespace Ent\Widget;

use Carbon_Fields\Field;

class Ent_Terms_List extends \Ent\Widgets\Widget {
    protected function get_definition() {
        $options = $this->get_taxonomies();
        $default = $this->get_default_taxonomy($options);

        return [
            'title' => 'Terms List',
            'description' => 'Taxonomy terms list.',
            'fields' => [
                Field::make('select', 'taxonomy', 'Taxonomy')
                    ->set_default_value($default)
                    ->set_options($options),
                Field::make('checkbox', 'show_count', 'Show post count'),
                Field::make('checkbox', 'only_root', 'Show only root terms'),
                Field::make('checkbox', 'hierarchical', 'Show hierarchy')
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        ['field' => 'only_root', 'value' => 'yes', 'compare' => '!=']
                    ]),
            ],
        ];
    }

    protected function get_context_data($fields, $config) {
        $show_count      = $fields['show_count'] == 'yes';
        $hierarchical    = $fields['hierarchical'] == 'yes';
        $only_root       = $fields['only_root'] == 'yes';
        $taxonomy_exists = $this->taxonomy_exists($fields['taxonomy']);
        $terms_tree      = $this->get_terms_tree($fields['taxonomy'], $hierarchical);

        return [
            'show_count'      => $show_count,
            'hierarchical'    => $hierarchical,
            'only_root'       => $only_root,
            'terms_tree'      => $terms_tree,
            'taxonomy_exists' => $taxonomy_exists,
        ];
    }

    protected function get_default_taxonomy($taxonomies) {
        if (array_key_exists('category', $taxonomies)) {
            return 'category';
        } else {
            return current(array_keys($taxonomies));
        }
    }

    protected function get_terms_tree($taxonomy, $hierarchical) {
        $term_id_map = [];
        $terms_tree  = [];

        $terms = get_terms([
            'taxonomy'     => $taxonomy,
            'orderby'      => 'name',
            'hierarchical' => $hierarchical,
        ]);

        // Save ID => OBJECT relation
        foreach ($terms as $term) {
            $term_id_map[$term->term_id] = $term;
            $term->children = [];
        }
        
        // Create the actual TREE
        foreach ($terms as $term) {
            if ($term->parent != 0) {
                $term_id_map[$term->parent]->children[] = $term;
            } else {
                $terms_tree[] = $term;
            }
        }

        return $terms_tree;
    }

    protected function get_taxonomies() {
        $taxonomies = get_taxonomies(['public' => true], 'object');
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
