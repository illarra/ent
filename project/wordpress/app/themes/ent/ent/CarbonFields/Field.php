<?php
namespace Ent\CarbonFields;

use Carbon_Fields\Field;

class Field {
    public static function media($title) {
        return Field::make('complex', 'media', $title)
            ->add_fields('image', 'Imatge', [
                Field::make('image', 'image', 'Imatge')->set_required(true),
                Field::make('text', 'description', 'Descripció'),
            ])->set_header_template('{{ image }} {{ description }}')
            ->add_fields('youtube', 'Video Youtube', [
                Field::make('text', 'video_url', 'Video')
                    ->set_required(true)
                    ->help_text('Dirección URL del video de YouTube. Ejemplo: <code>https://www.youtube.com/watch?v=kfoJUeyMsOE</code>'),
                Field::make('image', 'image', 'Fotograma'),
            ])->set_header_template('{{ image }} <a href="{{ video_url }}" target="_blank">{{ video_url }}</a>');
    }

    public static function attachments($title) {
        return Field::make('complex', 'attachments', $title)->add_fields([
            Field::make('text', 'title', 'Nom')->set_required(true),
            Field::make('file', 'file', 'Arxiu')->set_required(true),
        ])->set_header_template('{{ title }}');
    }

    public static function links($title) {
        return Field::make('complex', 'links', $title)->add_fields([
            Field::make('text', 'title', 'Nom')->set_required(true),
            Field::make('text', 'url', 'URL')->set_required(true),
        ])->set_header_template('{{ title }}');
    }
}

/*
public static function cf_collapse_complex_fields($field) {
    add_action('in_admin_footer', function () use ($field) {
        ?>
        <script type="text/javascript">
            jQuery(function () {
                var counter = 0; // Tries counter
                var tries   = 10;
                var delay   = 250;
                var query   = '#carbon-_<?php echo $field; ?>-complex-container .carbon-btn-collapse';

                function check() {
                    var els = jQuery(query);

                    if (els.length) {
                        els.click();
                    } else if (counter < tries) {
                        counter++;
                        setTimeout(check, delay);
                    }
                }

                check();
            });
        </script>
        <?php
    });
}
*/
