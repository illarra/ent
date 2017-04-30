<?php
namespace Ent;

use Carbon_Fields\Container;
use Ent\Traits\CarbonFieldsContainer;

abstract class Term extends \Timber\Term {
    use CarbonFieldsContainer;

    protected static $cf_get_function = 'carbon_get_term_meta';
    public static $enable_vc = false;

    public static function register() {}

    public function __construct($tid = null, $tax = '') {
        parent::__construct($tid, $tax);
        self::init_carbon_fields();
        $this->load_container_values();
    }

    protected static function get_cf_container($id, $label) {
        return Container::make('term_meta', $label)
            ->show_on_taxonomy($id);
    }
}
