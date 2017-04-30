<?php
namespace Ent\CPT;

use Carbon_Fields\Field;
use Ent\CarbonFields\Field as EntField;

class Post extends \Ent\CPT {
    protected static function define_custom_fields($container) {
        $container->add_fields([
        ]);
    }
}
