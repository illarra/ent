<?php
add_action('init', function() {
    vc_remove_param('vc_column', 'css');

    Ent::vc()->update_params('vc_column', [
        'as_parent' => ['only' => implode(',', Ent::vc()->get_layout_components())],
        'el_id'     => ['group' => 'Advanced'],
        'el_class'  => ['group' => 'Advanced'],
    ]);

    // Remove all controls
    Ent::vc()->set_controls('vc_column', '');
});
