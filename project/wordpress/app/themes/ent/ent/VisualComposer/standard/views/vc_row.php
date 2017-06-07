<?php
extract(shortcode_atts(array(
    'el_id'    => '',
    'el_class' => '',
), $atts));

$content = do_shortcode($content);

if (strpos($content, '<section') === false) {
    echo
    '<section',
        ($el_id ? ' id="'. $el_id .'" ' : ''),
        ($el_class ? ' class="'. $el_class .'" ': ''),
        '>',
        $content,
    '</section>';
} else {
    echo $content;
}
