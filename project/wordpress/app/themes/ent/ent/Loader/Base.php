<?php
namespace Ent\Loader;

abstract class Base {
    protected $namespace = '';
    protected $class_map = [];

    public function get_class_map() {
        return $this->class_map;
    }

    protected function get_class_name($file) {
        return $this->namespace . $this->get_id($file);
    }

    protected function get_id($file) {
        return str_replace('-', '_', basename($file, '.php'));
    }

    public function load_folder($folder) {
        foreach (glob($folder .'/*.php') as $file) {
            require_once($file);

            // Generate class & id
            $class = $this->get_class_name($file);
            $id = $this->get_id($file);

            // Save [cpt/term => class] map for Timber
            $this->class_map[$id] = $class;

            // Register
            $this->register($id, $class::register());

            // Init CarbonFields container & fields
            $class::init_carbon_fields();

            // Register in VisualComposer
            if ($class::$enable_vc) {
                \Ent::vc()->enable_cpt($id);
            }
        }
    }

    abstract protected function register($id, $definition);
}
