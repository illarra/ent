<?php
namespace Ent\Widgets;

use Carbon_Fields\Widget as CF_Widget;

class Widget extends CF_Widget {
    function front_end($args, $instance) {
        $reflector = new \ReflectionClass(get_class($this));
        $template = dirname($reflector->getFileName()) . '/template.twig';

        // Add extra context data
        $instance = array_merge($instance, $this->get_context_data($instance, $args), ['config' => $args]);

        \Timber::render($template, $instance);
    }

    protected function get_context_data($fields, $config) {
        return [];
    }
}
