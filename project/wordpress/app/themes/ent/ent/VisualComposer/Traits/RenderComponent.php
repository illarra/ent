<?php
namespace Ent\VisualComposer\Traits;

trait RenderComponent {
    protected function get_context_data(array $fields) {
        return [];
    }

    protected function content($atts, $content = null) {
        $definition = \WPBMap::getShortCode($this->shortcode);
        $reflector = new \ReflectionClass(get_class($this));

        $component = basename(dirname($reflector->getFileName()));
        $atts = array_merge(
            vc_map_get_attributes($this->getShortcode(), $atts),
            ['content' => do_shortcode($content)]
        );

        // Process VC attributes
        foreach ($definition['params'] as $param) {
            if ($param['type'] == 'vc_link' &&
                array_key_exists($param['param_name'], $atts) &&
                $atts[$param['param_name']] !== ''
            ) {
                $atts[$param['param_name']] = vc_build_link($atts[$param['param_name']]);
            }

            // Convert image attributes to Timber_Image type
            if ($param['type'] == 'attach_image' &&
                array_key_exists($param['param_name'], $atts) &&
                is_numeric($atts[$param['param_name']])
            ) {
                $atts[$param['param_name']] = new \TimberImage($atts[$param['param_name']]);
            }
        }

        // Inject context
        $atts['context'] = \Ent::timber()->get_context();

        // Add extra context data
        $atts = array_merge($atts, $this->get_context_data($atts));

        ob_start();
        \Timber::render($component . '/template.twig', $atts);

        return ob_get_clean();
    }
}
