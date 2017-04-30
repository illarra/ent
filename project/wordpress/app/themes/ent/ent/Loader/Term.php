<?php
namespace Ent\Loader;

class Term extends Base {
    protected $namespace = 'Ent\\Term\\';

    protected function register($id, $definition) {
        $post_types = $definition['post_types'];

        add_action('init', function () use ($id, $post_types, $definition) {
            if (!taxonomy_exists($id)) {
                register_taxonomy($id, $post_types, $definition);
            }
        });
    }
}
