<?php
namespace Ent\Loader;

use Carbon_Fields\Container;

class Term extends Base {
    protected $namespace = 'Ent\\Term\\';

    protected function get_cf_container($id) {
        return Container::make('term_meta', $this->get_cf_name($id))
            ->show_on_taxonomy($id);
    }

    protected function register($id, $definition) {
        //var_dump('Term Loader: ' . $class);
    }
}
