<?php
namespace Ent;

use Symfony\Component\Translation;

class i18n {
    public function __construct($theme_dir) {
        add_action('wp', function () use ($theme_dir) {
            global $sitepress;

            // Get data from WPML
            $default_locale = $sitepress->get_default_language();
            $locales = icl_get_languages('skip_missing=0');

            // Init Symfony Translation component and load resources
            $translator = new Translation\Translator(ICL_LANGUAGE_CODE, new Translation\MessageSelector());
            $translator->setFallbackLocale($default_locale);
            $translator->addLoader('yaml', new Translation\Loader\YamlFileLoader());
            $translator->addResource('yaml', __DIR__ .'/locales/'. ICL_LANGUAGE_CODE .'.yml', ICL_LANGUAGE_CODE);
            $translator->addResource('yaml', $theme_dir .'/src/locales/'. ICL_LANGUAGE_CODE .'.yml', ICL_LANGUAGE_CODE);

            // Load also the default locale if we're not in the default one
            if (ICL_LANGUAGE_CODE != $default_locale) {
                $translator->addResource('yaml', __DIR__ .'/locales/'. $default_locale .'.yml', $default_locale);
                $translator->addResource('yaml', $theme_dir .'/src/locales/'. $default_locale .'.yml', $default_locale);
            }

            // WordPress integration
            add_filter('gettext', function ($str, $str_key, $domain) use ($translator) {
                if (($domain == 'ent' || $domain == 'default') && $str == $str_key) {
                    $str = $translator->trans($str_key);
                }

                return $str;
            }, 20, 3);

            // Load locales in Timber
            add_filter('timber/context', function ($data) use ($locales) {
                $data['locales'] = [
                    'current' => $locales[ICL_LANGUAGE_CODE],
                    'alt'     => array_filter($locales, function ($l) {
                        return $l['code'] !== ICL_LANGUAGE_CODE;
                    }),
                ];

                return $data;
            });
        });
    }
}
