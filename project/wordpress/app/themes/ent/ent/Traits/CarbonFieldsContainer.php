<?php
namespace Ent\Traits;

trait CarbonFieldsContainer {
    public $field = [];
    protected static $container;

    abstract protected function get_cf_container($id, $label);
    abstract protected static function define_custom_fields($container);

    protected static function get_cf_name($id) {
        $labels = get_post_type_object($id)->labels;

        if ($labels->singular_name) {
            $name = $labels->singular_name;
        } elseif ($labels->name) {
            $name = $labels->name;
        } else {
            $name = str_replace('_', ' ', $id);
        }

        return 'Form: '. ucFirst($name);
    }

    public static function init_carbon_fields() {
        $class = get_called_class();
        $reflector = new \ReflectionClass(get_called_class());
        $id = str_replace('-', '_', basename($reflector->getFileName(), '.php'));
        $label = self::get_cf_name($id);

        $class::$container = $class::get_cf_container($id, $label);
        $class::define_custom_fields($class::$container);
    }

    protected function load_container_values() {
        $transformer = \Ent\CarbonFields\Factory::create_transformer();

        $get_fn = self::$cf_get_function;
        $post_id = $this->id;

        $values = $transformer->transform(self::$container, function ($name, $type) use ($get_fn, $post_id) {
            return $get_fn($post_id, $name, $type);
        });

        foreach ($values as $key => $value) {
            $this->field[$key] = $value;
        }
    }
}
