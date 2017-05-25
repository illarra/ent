# Appodera't

## Ent library
### Templates, macros & hooks (twig)
- [ ] Timber twig `|resize` no funciona…
- [/] `mobile_menu`

### Misc
- [ ] Instalar: un plugin bueno para compartir en redes sociales
    - Con más redes sociales...
    - Con URL shortener
    - Con via @xyz (twitter)
- [ ] Check si soil esta funcionando bien

---

## Infraestructura/Tooling
- [ ] Que hacer con los salts? Si se regenera `wp-config.php` el login peta? que pasos hay que seguir cuando se empieza un nuevo proyecto?
    - Añadir un script `init-project` que regenere wp-config y actualice la contraseña del usuario??

-------
-------
-------
-------

# Orizar

## Ent library
### Templates, macros & hooks (twig)
- [ ] Archive:
    - Title de content: primero calcular el string, guardarlo (set), y despues añadir un bloque con el html
    - [ ] search
    - [ ] year
    - [ ] month
    - [ ] day
    - [ ] author
    - [ ] term: category, tags, x…
    - [ ] post-type
- [ ] Single (post view)
- [X] Single (page)
- [X] Home (blog index)
- [X] Front page
- [X] 404
- [ ] Tipos de cabecera `header_large`
    - [X] Cello verd
    - [ ] La boop
    - [ ] Mugari
    - [ ] Mess

### Widgets
- [ ] CSS
    - [ ] archives
    - [ ] recent posts
    - [ ] search
    - [ ] terms cloud
    - [ ] terms list
    - [ ] text

## Infraestructura/Tooling
- [ ] `plop` añadir helper `properSnakeCase` o ver como se puede concatenar `properCase` y `snakeCase`
- [ ] inquirer-recursive: https://www.npmjs.com/package/inquirer-recursive
- [ ] `plop component`: generar carpeta y archivos, registrar .scss. Que pregunte si es tipo: normal, container-parent o container-child.
- [ ] `plop component-tpl`
    - generar `twig` y `admin.html`. Detectar el listado de parametros, basandonos en el tipo de cada parametro generar el código que toca (imagen, link, texto…). Molaria que tambien mire `get_context_data` para por lo menos saber que otras variables hay. Si es plural `resources` que genere un `{% for %}`
    - tener en cuenta si es tipo container o no en base a eso `.row.small-up-1...` + admin.html con `<container/>`,
    - crear el código autogenerado al principio y entre unos delimitadores:
    {# <page-fields-cheatsheet> #}
    {# </page-fields-cheatsheet> #}

## Munger/Style Guide
- [ ] icon-bar
- [ ] slick

-------
-------
-------
-------

# Backlog

## Ent library (php)
### Templates, macros & hooks (twig)
- [ ] Gravity Forms override default templates => Foundation
- [ ] Tipos de footer

### Widgets
- [ ] Mailchimp
- [ ] Gravity forms?
- [ ] Traducir labels de wigets
- [ ] Integrar `CarbonFields/Transformer` (?)
- [ ] `plop`:
    - template `{{ foo }}` se pierde en el camino
    - `Proper_Snake_Case` para el nombre de la clase (ver en Infraestructura "añadir properSnakeCase")

### Misc
- [ ] Instalar: plugin bueno para gestionar archivos media de WP
- [ ] Añadir tamaños de imagen siguiendo el número de columnas (?).
- [ ] Documentar el listado de plugins que molan y para que se utilizan. Falta: calendarios. Better Font Awesome (?).
    - https://github.com/benhuson/password-protected
- [ ] Añadir un checklist? Analytics, SEO…
    - Cambiar: `Theme > Analytics ID`
    - Cambiar: `SEO > Home Page Settings > Custom Home Page Title Tagline`
- [ ] Chequear si se han regenerado los salts de wp-config
- [ ] Tests
- [ ] Caching y optimización de wordpress (investigar)

### Post/Terms
- [ ] Helpers: get listado de taxonomia, etc. que devuelva con la clase que toca? hacer un wrapper alrededor de `Timber::get_post`, `get_posts`, `get_term…
    - https://github.com/timber/timber/issues/1399
- [ ] Archive para CPTs, integrar con Ent_Archives widget.
    - http://stackoverflow.com/questions/23386709/date-archives-for-custom-post-type

### Router
- ...

### i18n
- [ ] Crear plugin para copiar contenido de CF entre idiomas de WPML. Molaria que sincronice **unos campos** automaticamente entre plantillas cuando se guarda o se duplica mediante WPML.
- Get CPT from ID... `'trainings_page' => get_permalink(icl_object_id(carbon_get_theme_option('formacions_id'), 'page'))`

### Forms
- [ ] Formularios: gravity forms?

### Visual Composer
- [ ] VisualComposer Transformer como en CarbonFields
- [ ] Componente mapa:
    - Gestionar API key a traves de theme-options?
    - http://bdadam.com/blog/simple-usability-trick-for-google-maps.html
- [ ] Contacto
- [ ] Slider (ent component edo base class con plop y toda la movida)
- [ ] Listado con filtros (ent component edo base class con plop y toda la movida)
- [ ] VisualComposer <section><section class="image-intro">... basurilla hobetzia baziok?
- [ ] Componente Widget area (eg: para poner contenido de footer en cualquier otro sitio, ej: “contact”)

---

## Assets (brunch)
- [ ] sizzy.co
- [ ] Como gestionar los iconos? (a Anna le gusta personalizarlos)
    - Esperar a FontAwesome 5 SVG framework?
- [ ] Hyphenate

---

## Munger
- ...

---

## Infraestructura/Tooling
- [ ] Plops para CPTs de uso habitual: team/staff, noticias, recursos…

---

## Staging & deploy
- [ ] Staging: servidor de l'Apostrof, subir mediante SSH
- [ ] Staging: actualizar vendors, plugins, plantilla, DB… mediante SSH y en un comando
- [ ] Staging: sincronizar dev <-> stage <-> prod (?)
- [ ] Deploy: primera vez, Duplicator.
- [ ] Deploy: actualizar plantilla en el servidor del cliente? Deploy por FTP? Como actualizar vendors?
    - https://github.com/dg/ftp-deployment

---

## Misc
- [ ] emmet.io (?)
- [ ] Hemendik gauza interesgarri batzuk ateatzia zeudek? http://wpgear.org 
- [ ] http://wptest.io/demo/
- [ ] https://github.com/wp-premium => Plugins via GIT!

---

## Known issues
- [ ] PuPHPet, NFS actimeo=2 https://github.com/puphpet/puphpet/issues/2466
- [ ] Añadir WPML via GIT: https://github.com/wp-premium/sitepress-multilingual-cms y https://github.com/wp-premium/wpml-media hay un issue que se interpone >:( https://github.com/composer/installers/issues/313

