<?php
namespace Ent;

class Timber {
    protected $context = null;

    public function __construct($theme_dir, $config) {
        // Init
        new \Timber\Timber();

        // Assets JSON
        $assets = new AssetsJSON($theme_dir . '/assets/assets.json', get_template_directory_uri());

        // Twig locations
        \Timber::$locations = [
            $theme_dir . '/src/views',              // User templates
            $theme_dir . '/src/components',         // User components
            __DIR__ . '/views',                     // Ent templates
            __DIR__ . '/VisualComposer/components', // Ent components
        ];

        // Save Context for VC Components
        add_filter('timber/loader/render_data', function ($data) {
            // Only save context on first call per request
            // This should be the legit WordPress Timber::render
            if (!Ent::timber()->context_isset()) {
                Ent::timber()->save_context($data);
            }

            return $data;
        }, 99999);

        // Tweak Twig
        add_filter('get_twig', function ($twig) use ($assets, $config) {
            $twig->addFunction(new \Twig_SimpleFunction('asset', function ($file) use ($assets) {
                return $assets->get($file);
            }));

            // TODO: Zertako dek hau?
            $twig->addFunction(new \Twig_SimpleFunction('get_permalink', function ($id) {
                if (function_exists('icl_object_id')) {
                    $id = apply_filters('wpml_object_id', $id);
                }

                return get_permalink($id);
            }));

            // Google Maps API
            if (!empty($config['google_maps_api_key'])) {
                $twig->addGlobal('google_maps_api_key', $config['google_maps_api_key']);
            }

            return $twig;
        });
    }

    public function get_context() {
        return $this->context;
    }

    public function context_isset() {
        return !is_null($this->context);
    }

    public function save_context($context) {
        $this->context = $context;
    }
}
