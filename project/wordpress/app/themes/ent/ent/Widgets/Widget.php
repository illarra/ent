<?php
namespace Ent\Widgets;

use Carbon_Fields\Widget as CF_Widget;
use Carbon_Fields\Field;

class Widget extends CF_Widget {
    function __construct() {
        $definition = $this->get_definition();

        // Add locale field
        $locales = ['' => 'Todos'] + \Ent::i18n()->get_locales();
        $definition['fields'][] = Field::make('select', '__locale', 'Mostrar en idioma:')->set_options($locales);

        $this->setup($definition['title'], $definition['description'], $definition['fields']);
    }

    function front_end($args, $instance) {
        $reflector = new \ReflectionClass(get_class($this));
        $template = dirname($reflector->getFileName()) . '/template.twig';

        // Add extra context data
        $instance = array_merge($instance, $this->get_context_data($instance, $args), ['config' => $args]);

        // Render only if it's for all the languages or equals to current locale
        if (empty($instance['_locale']) || $instance['_locale'] == ICL_LANGUAGE_CODE) {
            \Timber::render($template, $instance);
        }
    }

    protected function get_context_data($fields, $config) {
        return [];
    }
}
