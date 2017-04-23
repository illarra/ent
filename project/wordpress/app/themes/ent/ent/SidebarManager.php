<?php
namespace Ent;

class SidebarManager {
    public function __construct($sidebars) {
        if (count($sidebars)) {
            add_action('widgets_init', function () use ($sidebars) {
                foreach ($sidebars as $id => $name) {
                    register_sidebar([
                        'name'          => $name,
                        'id'            => $id,
                        'before_widget' => '<div class="ent-widget">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h4 class="ent-widget__title">',
                        'after_title'   => '</h4>',
                    ]);
                }
            });

            add_filter('timber/context', function ($data) use ($sidebars) {
                foreach ($sidebars as $id => $name) {
                    $data[$id] = \Timber::get_widgets($id);
                }

                return $data;
            });
        }
    }
}
