<?php
namespace Ent\CPT;

use Carbon_Fields\Field;
use Ent\CarbonFields\Field as EntField;

class Page extends \Ent\CPT {
    public static function define_custom_fields($container) {
        $container->add_fields([
        ]);
    }

    public function hello() {
        return 'Custom class for pages! It\'s working!';
    }
}
