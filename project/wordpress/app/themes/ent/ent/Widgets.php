<?php
namespace Ent;

class Widgets {
    public function __construct() {
        $this->unregister_widgets();
    }

    public function load_widgets($folder) {
        add_action('widgets_init', function () use ($folder) {
            foreach (glob($folder .'/*') as $filename) {
                require_once($filename .'/widget.php');
                register_widget('Ent\\Widget\\'. str_replace('-', '_', basename($filename)));
            }
        });
    }

    protected function unregister_widgets() {
        add_action('widgets_init', function () {
            unregister_widget('WP_Widget_Pages');           // Pages Widget
            unregister_widget('WP_Widget_Calendar');        // Calendar Widget
            unregister_widget('WP_Widget_Archives');        // Archives Widget
            unregister_widget('WP_Widget_Links');           // Links Widget
            unregister_widget('WP_Widget_Meta');            // Meta Widget
            unregister_widget('WP_Widget_Search');          // Search Widget
            //unregister_widget('WP_Widget_Text');            // Text Widget
            unregister_widget('WP_Widget_Categories');      // Categories Widget
            unregister_widget('WP_Widget_Recent_Posts');    // Recent Posts Widget
            unregister_widget('WP_Widget_Recent_Comments'); // Recent Comments Widget
            unregister_widget('WP_Widget_RSS');             // RSS Widget
            unregister_widget('WP_Widget_Tag_Cloud');       // Tag Cloud Widget
            unregister_widget('WP_Nav_Menu_Widget');        // Menus Widget
        });
    }
}
