<?php
namespace Ent;

class CPT extends \Timber\Post {
    public function __construct($tid = null) {
        parent::__construct($tid);
        //Helpers::getPostMeta('fa_area', $this);
    }

    public static function register() {}
    public static function define_custom_fields($container) {}
}
