<?php
namespace Ent;

use Carbon_Fields\Container;
use Ent\Traits\CarbonFieldsContainer;

abstract class CPT extends \Timber\Post {
    use CarbonFieldsContainer;

    protected static $cf_get_function = 'carbon_get_post_meta';
    public static $enable_vc = false;

    public static function register() {}

    public function __construct($tid = null) {
        parent::__construct($tid);
        self::init_carbon_fields();
        $this->load_container_values();
    }

    protected static function get_cf_container($id, $label) {
        return Container::make('post_meta', $label)
            ->show_on_post_type($id);
    }
}
