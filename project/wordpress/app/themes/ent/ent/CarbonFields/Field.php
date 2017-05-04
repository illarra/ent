<?php
namespace Ent\CarbonFields;

use Carbon_Fields\Field;

class Field {
    public static function media_gallery($title, $id = 'media_gallery') {
        return Field::make('complex', $id, $title)
            ->set_collapsed(true)
            ->add_fields('image', 'Imatge', [
                Field::make('image', 'image', 'Imatge')->set_required(true),
                Field::make('text', 'description', 'Descripció'),
            ])
            ->set_header_template('{{ image }} {{ description }}')
            ->add_fields('youtube', 'Video Youtube', [
                Field::make('text', 'video_url', 'Video')
                    ->set_required(true)
                    ->help_text('Dirección URL del video de YouTube. Ejemplo: <code>https://www.youtube.com/watch?v=kfoJUeyMsOE</code>'),
                Field::make('image', 'image', 'Fotograma'),
            ])
            ->set_header_template('{{ image }} <a href="{{ video_url }}" target="_blank">{{ video_url }}</a>');
    }

    public static function attachments($title, $id = 'attachments') {
        return Field::make('complex', $id, $title)
            ->set_collapsed(true)
            ->add_fields([
                Field::make('text', 'title', 'Nom')->set_required(true),
                Field::make('file', 'file', 'Arxiu')->set_required(true),
            ])->set_header_template('{{ title }}');
    }

    public static function links($title, $id) {
        return Field::make('complex', $id, $title)
            ->set_collapsed(true)
            ->add_fields([
                Field::make('text', 'title', 'Nom')->set_required(true),
                Field::make('text', 'url', 'URL')->set_required(true),
            ])
            ->set_header_template('{{ title }}');
    }
}
