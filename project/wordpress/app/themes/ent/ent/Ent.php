<?php
namespace Ent;

class Ent {
    public static $timber;
    public static $vc;

    public static function init($theme_dir, $config) {
        // Create alias so that Ent class can be accessed typing `Ent::` without namespace backslash
        class_alias(get_class($this), 'Ent');

        // Load CPT & Taxonomy definitions
        foreach (['/src/post-types', '/src/taxonomies'] as $folder) {
            foreach (glob($theme_dir . $folder .'/*.php') as $filename) {
                require_once($filename);
            }
        }

        // Init VisualComposer integration
        self::$vc = new VisualComposer();
        self::$vc->load_components(__DIR__ . '/VisualComposer/components');
        self::$vc->load_components($theme_dir .'/src/components');

        // This must go after `load_components` so that $layout_components is populated for `vc_column`
        self::$vc->standard_tweaks();

        // Init Timber/Twig
        self::$timber = new Timber($theme_dir, $config);

        // Menus & Sidebars
        new MenuManager($config['menus']);
        new SidebarManager($config['sidebars']);

        // Timezone
        date_default_timezone_set($config['timezone']);

        // Add more mime types
        add_filter('upload_mimes', function ($mimes) {
            $mimes['svg'] = 'image/svg+xml';

            return $mimes;
        });

        // Enable features from Soil when plugin is activated
        // https://roots.io/plugins/soil/
        add_action('after_setup_theme', function () {
            add_theme_support('soil-clean-up');
            add_theme_support('soil-nice-search');
            add_theme_support('soil-jquery-cdn');
            add_theme_support('soil-relative-urls');
        });
    }

    public static function handle_request() {
        $context = \Timber::get_context();
        $context['page'] = new \Timber\Post();
        \Timber::render('index.twig', $context);
    }

    public static function timber() {
        return self::$timber;
    }

    public static function vc() {
        return self::$vc;
    }
}
