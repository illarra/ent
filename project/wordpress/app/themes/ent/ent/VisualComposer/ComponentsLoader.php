<?php
namespace Ent\VisualComposer;

class ComponentsLoader {
    protected $vc;

    public function __construct($vc) {
        $this->vc = $vc;
    }

    public function get_admin_markup($path) {
        $admin = $path . '/admin.html';

        if (file_exists($admin)) {
            // Admin templates sugar
            $markup = strtr(file_get_contents($admin), [
                '<row>'        => '<div class="ent-row">',
                '</row>'       => '</div>',
                '<column>'     => '<div class="ent-column">',
                '</column>'    => '</div>',
                '<column-1>'   => '<div class="ent-column">',
                '</column-1>'  => '</div>',
                '<column-2>'   => '<div class="ent-column-2">',
                '</column-2>'  => '</div>',
                '<column-3>'   => '<div class="ent-column-3">',
                '</column-3>'  => '</div>',
                '<box>'        => '<div class="ent-user-component"><span>',
                '</box>'       => '</span></div>',
                '<container/>' => '<div class="ent-container wpb_column_container vc_container_for_children vc_clearfix ui-droppable ui-sortable"></div>',
            ]);

            return '<div data-ent-custom-view>' . $markup . '</div>';
        }

        throw new \Exception('`admin.html` not found for `' . basename($path) . '` component');
    }

    public function get_base($component) {
        return str_replace('-', '_', $component);
    }

    public function get_component_class($component) {
        return 'WPBakeryShortCode_' . $this->get_base($component);
    }

    public function get_name($component) {
        return ucFirst(str_replace('-', ' ', $component));
    }

    public function load_components($folder) {
        foreach (glob($folder .'/*') as $path) {
            require_once($path .'/component.php');

            $component = basename($path);
            $class = $this->get_component_class($component);

            // Construct configuration for vc_map
            $config = [
                'base'          => $this->get_base($component),
                'name'          => $this->get_name($component),
                'js_view'       => 'EntCustomView',
                'custom_markup' => $this->get_admin_markup($path),
                'icon'          => $this->vc->get_icon_url('user-component'),
                'params'        => [],
            ];

            // Save to layout components array
            // This is used by vc_column to limit which components can be its child
            if ($class::$is_layout) {
                $config['as_child'] = ['only' => 'vc_column'];
                $this->vc->add_layout_component($config['base']);
            }

            foreach ($class::get_fields() as $field) {
                $config['params'][] = $field->get_parameters();
            }

            // Register component
            vc_lean_map($config['base'], function () use ($config) {
                return $config;
            });
        }
    }
}
