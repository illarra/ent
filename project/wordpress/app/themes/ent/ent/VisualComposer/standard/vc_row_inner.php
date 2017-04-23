<?php
add_action('init', function() {
    vc_remove_param('vc_row_inner', 'equal_height');
    vc_remove_param('vc_row_inner', 'content_placement');
    vc_remove_param('vc_row_inner', 'gap');
    vc_remove_param('vc_row_inner', 'css');

    Ent::vc()->update_params('vc_row_inner', [
        'el_id'           => ['group' => 'Advanced'],
        'disable_element' => ['group' => 'Advanced'],
        'el_class'        => ['group' => 'Advanced'],
    ]);
});
