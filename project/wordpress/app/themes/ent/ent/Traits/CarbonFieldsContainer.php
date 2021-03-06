<?php
namespace Ent\Traits;

trait CarbonFieldsContainer {
    public $fields = [];
    protected static $container;

    abstract protected function get_cf_container($id, $label);

    protected static function define_custom_fields($container) {
    }

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
        $methodDefinitionPath = $reflector->getMethod('define_custom_fields')->getFileName();

        // Create the container only if the class has it's own 'define_custom_fields' definition
        // This is to avoid errors in the admin when there is a container without fields.
        // It's not a full solution since the child class can define the method without adding fields.
        if (strpos($methodDefinitionPath, 'Traits/CarbonFieldsContainer') === false) {
            $class::$container = $class::get_cf_container($id, $label);
            $class::define_custom_fields($class::$container);
        }
    }

    protected function load_container_values() {
        $transformer = \Ent\CarbonFields\Factory::create_transformer();

        $get_fn = self::$cf_get_function;
        $post_id = $this->id;

        $values = $transformer->transform(self::$container, function ($name, $type) use ($get_fn, $post_id) {
            return $get_fn($post_id, $name, $type);
        });

        foreach ($values as $key => $value) {
            $this->fields[$key] = $value;
        }
    }
}
