<?php
namespace Ent;

class MenuManager {
    public function __construct($menus) {
        if (count($menus)) {
            add_action('after_setup_theme', function () use ($menus) {
                register_nav_menus($menus);
            });

            add_filter('timber/context', function ($data) use ($menus) {
                foreach ($menus as $id => $name) {
                    $data[$id] = new \TimberMenu($id);
                }

                return $data;
            });
        }
    }
}
