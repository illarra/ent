<?php
namespace Ent\CarbonFields;

class Factory {
    public static function create_transformer() {
        $transformer = new Transformer();

        $transformer->add_mapper('Carbon_Fields\Field\Checkbox_Field', function ($value) {
            return $value === 'yes';
        });

        $transformer->add_mapper('Carbon_Fields\Field\Date_Field', function ($value) {
            if (!empty($value)) {
                $value = new \Datetime($value);
            }

            return $value;
        });

        $transformer->add_mapper('Carbon_Fields\Field\Image_Field', function ($value) {
            return new \TimberImage($value);
        });

        return $transformer;
    }
}
