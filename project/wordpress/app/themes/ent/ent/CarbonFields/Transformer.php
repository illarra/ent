<?php
namespace Ent\CarbonFields;

class Transformer {
    protected $mappers = [];

    public function add_mapper($class, $fn) {
        $this->mappers[$class] = $fn;
    }

    protected function map($values, $classes) {
        $data = [];

        foreach ($classes as $field_name => $field) {
            if (count($field['children'])) {
                // Complex field
                // Create empty array
                $data[$field_name] = [];

                // Map each complex field entry
                foreach ($values[$field_name] as $complex_entry) {
                    $data[$field_name][] = $this->map($complex_entry, $field['children']);
                }
            } else {
                // Regular field
                foreach ($this->mappers as $mapper_class => $mapper_fn) {
                    if ($field['class'] == $mapper_class) {
                        $data[$field_name] = $mapper_fn($values[$field_name]);

                        // Continue with outter most foreach
                        continue 2;
                    }
                }

                // There are no mappers so set the value without casting
                $data[$field_name] = $values[$field_name];
            }
        }

        return $data;
    }

    protected function get_classes($container) {
        $data = [];

        foreach ($container->get_fields() as $field) {
            $field_name = $field->get_base_name();
            $field_class = get_class($field);

            $data[$field_name] = [
                'class'    => $field_class,
                'children' => [],
            ];

            if ($field_class == 'Carbon_Fields\Field\Complex_Field') {
                $data[$field_name]['children'] = $this->get_classes($field);
            }
        }

        return $data;
    }

    protected function get_values($container, $get_fn) {
        $data = [];

        foreach ($container->get_fields() as $field) {
            $field_name = $field->get_base_name();
            $field_class = get_class($field);

            if ($field_class == 'Carbon_Fields\Field\Complex_Field') {
                $type = 'complex';
            } else if ($field_class == 'Carbon_Fields\Field\Map_Field') {
                $type = 'map';
            } else {
                $type = null;
            }

            $data[$field_name] = $get_fn($field_name, $type);
        }

        return $data;
    }

    public function transform($container, $get_fn) {
        $values = $this->get_values($container, $get_fn);
        $classes = $this->get_classes($container);

        return $this->map($values, $classes);
    }
}
