<?php
Ent::handle('home', function (&$context) {
    $context['related_entries'] = Timber::get_posts([
        'post_type'      => 'news',
        'post_status'    => 'publish',
        'orderby'        => 'publish_date',
        'order'          => 'DESC',
        'posts_per_page' => 4,
    ]);
});

Ent::handle('post-type.post', function (&$context) {
});
