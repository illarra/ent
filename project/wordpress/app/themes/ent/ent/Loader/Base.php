<?php
namespace Ent\Loader;

abstract class Base {
    protected $namespace = '';
    protected $class_map = [];

    public function get_cf_name($id) {
        $labels = get_post_type_object($id)->labels;

        if ($labels->singular_name) {
            $name = $labels->singular_name;
        } elseif ($labels->name) {
            $name = $labels->name;
        } else {
            $name = $id;
        }

        return 'Form: ' . $name;
    }

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

            // Create CarbonFields container and pass it to the static object for configuration
            $container = $this->get_cf_container($id);
            $class::define_custom_fields($container);
        }
    }

    abstract protected function get_cf_container($id);
    abstract protected function register($id, $definition);

    /*
    static public $cf_containers = [];

    public static function getPostMeta($key, $obj) {
        self::getMeta($key, $obj, 'carbon_get_post_meta');
    }
    
    public static function getTermMeta($key, $obj) {
        self::getMeta($key, $obj, 'carbon_get_term_meta');
    }
    
    protected static function getMeta($key, $obj, $fn) {
        foreach (self::$cf_containers[$key]->get_fields() as $field) {
            $field_name = $field->get_base_name();

            if (get_class($field) == 'Carbon_Fields\Field\Complex_Field') {
                $type = 'complex';
            } else if (get_class($field) == 'Carbon_Fields\Field\Map_Field') {
                $type = 'map';
            } else {
                $type = null;
            }

            $obj->$field_name = $fn($obj->id, $field_name, $type);
            
            if (get_class($field) == 'Carbon_Fields\Field\Checkbox_Field') {
                $obj->$field_name = $obj->$field_name === 'yes';
            } else if (get_class($field) == 'Carbon_Fields\Field\Date_Field') {
                if (!empty($obj->$field_name)) {
                    $obj->$field_name = new \Datetime($obj->$field_name);
                }
            }
        }
    }
    
    public static function setMeta($key, $cb) {
        self::$cf_containers[$key] = $cb();
    }
    */
}
