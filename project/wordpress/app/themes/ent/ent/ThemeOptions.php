<?php
namespace Ent;

use \Carbon_Fields\Container;
use \Carbon_Fields\Field;

class ThemeOptions {
    protected $container;
    protected $transformer;

    public function __construct() {
        $this->transformer = CarbonFields\Factory::create_transformer();
        $this->init_container();
        $this->init_twig();
    }

    private function init_container() {
        $this->container = Container::make('theme_options', 'Theme');

        // Add commont properties
        $this->container->add_fields([
            Field::make('text', 'analytics_id', 'Google Analytics tracking ID'),
            Field::make('text', 'maps_api_key', 'Google Maps API Key'),
        ]);

        // Add user defined fields
        $this->define_custom_fields($this->container);
    }

    private function init_twig() {
        $options = $this->transformer->transform($this->container, function ($name, $type) {
            return carbon_get_theme_option($name, $type);
        });

        add_filter('timber/context', function ($data) use ($options) {
            $data['_options'] = $options;

            return $data;
        });
    }

    protected function define_custom_fields($container) {}
}
