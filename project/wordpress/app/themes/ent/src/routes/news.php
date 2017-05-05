<?php
Ent::handle('archive.post-type.news', function (&$context) {
    $context['related_entries'] = Timber::get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'orderby'        => 'publish_date',
        'order'          => 'DESC',
        'posts_per_page' => 4,
    ]);
});
