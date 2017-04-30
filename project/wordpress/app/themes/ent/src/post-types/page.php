<?php
namespace Ent\CPT;

use Carbon_Fields\Field;
use Ent\CarbonFields\Field as EntField;

class Page extends \Ent\CPT {
    protected static function define_custom_fields($container) {
        $container->add_fields([
            Field::make('text', 'test', 'Prueba'),
        ]);
    }

    public function hello() {
        return 'Custom class for pages! It\'s working!';
    }
}
