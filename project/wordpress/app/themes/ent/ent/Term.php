<?php
namespace Ent;

class Term extends \Timber\Term {
    public function __construct($tid = null, $tax = '') {
        parent::__construct($tid, $tax);
        //Helpers::getTermMeta('fa_area', $this);
    }

    public static function register() {}
    public static function define_custom_fields($container) {}
}
