<?php
namespace Ent;

class Ent {
    protected static $cpt_loader;
    protected static $i18n;
    protected static $router;
    protected static $term_loader;
    protected static $timber;
    protected static $vc;
    protected static $widgets;

    public static function init($theme_dir, $config) {
        // Create alias so that Ent class can be accessed typing `Ent::` without namespace backslash
        class_alias(get_class($this), 'Ent');

        self::init_timber($theme_dir, $config);
        self::init_cpts_terms($theme_dir);
        self::init_visualcomposer($theme_dir);
        self::init_menus_sidebars($config);
        self::init_i18n($theme_dir);
        self::init_widgets($theme_dir);
        self::init_misc($config);
        self::init_router();
    }

    public static function handle_request() {
        self::$router->handle_request();
    }

    protected static function init_cpts_terms($theme_dir) {
        self::$cpt_loader = new Loader\CPT();
        self::$cpt_loader->load_folder($theme_dir . '/src/post-types');

        self::$term_loader = new Loader\Term();
        self::$term_loader->load_folder($theme_dir . '/src/taxonomies');

        // Pass Timber cpt => class map
        $cpt_class_map = self::$cpt_loader->get_class_map();

        add_filter('Timber\PostClassMap', function () use ($cpt_class_map) {
            return $cpt_class_map;
        });
    }

    protected static function init_i18n($theme_dir) {
        self::$i18n = new i18n($theme_dir);
    }

    protected static function init_menus_sidebars($config) {
        new MenuManager($config['menus']);
        new SidebarManager($config['sidebars']);
    }

    protected static function init_misc($config) {
        // Add title-tag support
        add_theme_support('title-tag');

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

    protected static function init_router() {
        self::$router = new Router();
    }

    protected static function init_timber($theme_dir, $config) {
        self::$timber = new Timber($theme_dir, $config);
    }

    protected static function init_visualcomposer($theme_dir) {
        // Init VisualComposer integration
        self::$vc = new VisualComposer();
        self::$vc->load_components(__DIR__ . '/VisualComposer/components');
        self::$vc->load_components($theme_dir .'/src/components');

        // This must go after `load_components` so that $layout_components is populated for `vc_column`
        self::$vc->standard_tweaks();
    }

    protected static function init_widgets($theme_dir) {
        self::$widgets = new Widgets();
        self::$widgets->load_widgets(__DIR__ . '/Widgets/widgets');
        self::$widgets->load_widgets($theme_dir . '/src/widgets');
    }

    public static function router() {
        return self::$router;
    }

    public static function timber() {
        return self::$timber;
    }

    public static function vc() {
        return self::$vc;
    }
}
