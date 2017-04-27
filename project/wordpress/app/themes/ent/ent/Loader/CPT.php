<?php
namespace Ent\Loader;

use Carbon_Fields\Container;

class CPT extends Base {
    protected $namespace = 'Ent\\CPT\\';

    protected function get_cf_container($id) {
        return Container::make('post_meta', $this->get_cf_name($id))
            ->show_on_post_type($id);
    }

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
        });
    }
}
