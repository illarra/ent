<?php
namespace Ent;

class VisualComposer {
    protected $loader;
    protected $layout_components = ['vc_row'];
    protected $enabled_cpts = [];

    public function __construct() {
        $this->loader = new VisualComposer\ComponentsLoader($this);

        $this->configure();
        $this->clean();
        $this->admin_assets();
    }

    public function add_layout_component($component) {
        $this->layout_components[] = $component;
    }

    protected function admin_assets() {
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_script(
                'ent-vc-backend',
                get_template_directory_uri() . '/ent/VisualComposer/Assets/backend.js',
                array(),
                null,
                true
            );

            wp_enqueue_style(
                'ent-vc-backend-css',
                get_template_directory_uri() . '/ent/VisualComposer/Assets/backend.css',
                array('js_composer')
            );
        }, 9999);

        add_action('wp_ajax_ent_img_src', function () {
            $img = wp_get_attachment_image_src($_POST['id'], $_POST['size']);

            echo json_encode([
                'id'   => $_POST['id'],
                'size' => $_POST['size'],
                'url'  => $img[0],
            ]);

            wp_die();
        });
    }

    protected function configure() {
        // Change standard VC templates path
        vc_set_shortcodes_templates_dir(__DIR__ . '/VisualComposer/Standard/views');
        vc_disable_frontend();

        add_action('vc_before_init', function () {
            // Remove help tips
            remove_action('admin_enqueue_scripts', 'vc_pointer_load');

            // Enable VC for CPTs
            vc_set_default_editor_post_types(Ent::vc()->get_enabled_cpts());
        });

        // Remove VC Frontend assets
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style('js_composer_front');
            wp_deregister_style('js_composer_front');
            wp_dequeue_script('wpb_composer_front_js');
            wp_deregister_script('wpb_composer_front_js');
        }, 9999);
    }

    protected function clean() {
        // Remove components
        //vc_remove_element('vc_row');
        //vc_remove_element('vc_column');
        vc_remove_element('vc_separator');
        vc_remove_element('vc_column_text');
        vc_remove_element('vc_icon');
        vc_remove_element('vc_text_separator');
        vc_remove_element('vc_message');
        vc_remove_element('vc_facebook');
        vc_remove_element('vc_tweetmeme');
        vc_remove_element('vc_googleplus');
        vc_remove_element('vc_pinterest');
        vc_remove_element('vc_toggle');
        vc_remove_element('vc_single_image');
        vc_remove_element('vc_gallery');
        vc_remove_element('vc_images_carousel');
        vc_remove_element('vc_tta_tabs');
        vc_remove_element('vc_tta_tour');
        vc_remove_element('vc_tta_accordion');
        vc_remove_element('vc_tta_pageable');
        vc_remove_element('vc_tta_section');
        vc_remove_element('vc_custom_heading');
        vc_remove_element('vc_btn');
        vc_remove_element('vc_cta');
        vc_remove_element('vc_widget_sidebar');
        vc_remove_element('vc_posts_slider');
        vc_remove_element('vc_video');
        vc_remove_element('vc_gmaps');
        vc_remove_element('vc_raw_html');
        vc_remove_element('vc_raw_js');
        vc_remove_element('vc_flickr');
        vc_remove_element('vc_progress_bar');
        vc_remove_element('vc_pie');
        vc_remove_element('vc_round_chart');
        vc_remove_element('vc_line_chart');
        vc_remove_element('vc_empty_space');
        vc_remove_element('vc_basic_grid');
        vc_remove_element('vc_media_grid');
        vc_remove_element('vc_masonry_grid');
        vc_remove_element('vc_masonry_media_grid');
        vc_remove_element('vc_tabs');
        vc_remove_element('vc_tour');
        vc_remove_element('vc_accordion');
        vc_remove_element('vc_button');
        vc_remove_element('vc_button2');
        vc_remove_element('vc_cta_button');
        vc_remove_element('vc_cta_button2');
        vc_remove_element('vc_wp_search');
        vc_remove_element('vc_wp_meta');
        vc_remove_element('vc_wp_recentcomments');
        vc_remove_element('vc_wp_calendar');
        vc_remove_element('vc_wp_pages');
        vc_remove_element('vc_wp_tagcloud');
        vc_remove_element('vc_wp_custommenu');
        vc_remove_element('vc_wp_text');
        vc_remove_element('vc_wp_posts');
        vc_remove_element('vc_wp_categories');
        vc_remove_element('vc_wp_archives');
        vc_remove_element('vc_wp_rss');
    }

    public function enable_cpt($cpt) {
        $this->enabled_cpts[] = $cpt;
    }

    public function get_asset_url($path) {
        return get_template_directory_uri() .'/ent/VisualComposer/Assets/'. $path;
    }

    public function get_enabled_cpts() {
        return $this->enabled_cpts;
    }

    public function get_icon_url($img) {
        return self::get_asset_url('icons/'. $img .'.png');
    }

    public function get_backend_css() {
        return self::get_asset_url('backend.css');
    }

    public function get_backend_js() {
        return self::get_asset_url('backend.js');
    }

    public function get_layout_components() {
        return $this->layout_components;
    }

    public function load_components($folder) {
        $this->loader->load_components($folder);
    }

    public function set_controls($tag, $controls = '') {
        $instance = visual_composer()->getShortCode($tag)->shortcodeClass();
        $instance->setSettings('controls', $controls);
    }

    public function standard_tweaks() {
        require_once 'VisualComposer/standard/vc_column_inner.php';
        require_once 'VisualComposer/standard/vc_column.php';
        require_once 'VisualComposer/standard/vc_row_inner.php';
        require_once 'VisualComposer/standard/vc_row.php';
    }

    // See: https://snippets.khromov.se/changing-settings-of-built-in-visual-composer-elements/
    public function update_params($tag, $params = []) {
        $shortcode = \WPBMap::getShortCode($tag);

        // Update parameters
        foreach ($shortcode['params'] as $i => $arr) {
            if (array_key_exists($arr['param_name'], $params)) {
                $shortcode['params'][$i] = array_merge($arr, $params[$arr['param_name']]);
            }
        }

        // VC doesn't like even the thought of you changing the shortcode base, and errors out, so we unset it.
        unset($shortcode['base']);

        vc_map_update($tag, $shortcode);
    }
}
