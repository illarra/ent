<?php
use \Ent\VisualComposer\Field;

class WPBakeryShortCode_image_intro extends Ent\VisualComposer\ShortCode {
    public static $is_layout = true;

    protected function get_context_data(array $atts) {
        return [];
    }

    public static function get_fields() {
        return [
            Field::make('select', 'color', 'Variante')->set_options(['azul', 'gris']),
            Field::make('image', 'image', 'Imagen'),
            Field::make('text', 'video_link', 'Enlace a video'),
            Field::make('rich_text', 'content', 'Contenido'),
        ];
    }
}
