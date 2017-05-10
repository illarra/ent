<?php
namespace Ent\Loader;

class CPT extends Base {
    protected $namespace = 'Ent\\CPT\\';

    protected function register($id, $definition) {
        add_action('init', function () use ($id, $definition) {
            if (!post_type_exists($id)) {
                register_post_type($id, $definition);
            }

            if (count($definition['add_support'])) {
                foreach ($definition['add_support'] as $feature) {
                    add_post_type_support($id, $feature);
                }
            }

            if (count($definition['remove_support'])) {
                foreach ($definition['remove_support'] as $feature) {
                    remove_post_type_support($id, $feature);
                }
            }
        }, 0);
    }
}
