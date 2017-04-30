# TODO

## Ent library PRIORITY (php)
### Post/Terms
- [ ] *!*EntField::media => media_gallery? :-/
- [ ] Helpers: get listado de taxonomia, etc. que devuelva con la clase que toca? hacer un wrapper alrededor de `Timber::get_post`, `get_posts`, `get_term…
    - https://github.com/timber/timber/issues/1399
- [X] *!*Terms `register()`
- [X] *!*Gestion de custom fields + `CarbonFields/Transformer`

### Widgets
- [ ] *!*Convertir los viejos a CarbonFields: icons, search, recent posts, taxonomy list (categories), taxonomy cloud (tags), archives…
- [ ] *!*Crear widget básicos utilizando CarbonFields, que ya tengan en cuenta el idioma
- [ ] *!*Integrar `CarbonFields/Transformer`
    - Edo WPML string i18n plugina instalatu ta fuera, no?

### Router
- [ ] *!*Route handler, que no tenga que crear un “home.php” y copiar toda la movida de $context por que quiero simplemente añadir una propiedad (ver Fil a l’afulla “home.php”).
    - http://framework.themosis.com/docs/1.3/routing/

### Templates, macros & hooks (twig)
- [ ] *!*Timber twig `|resize` no funciona…
- [ ] *!*Archive: author, tags, category, date (year, month, day), taxonomy x
- [ ] *!*Single (post view)
- [ ] *!*Single (page)
- [ ] *!*Home (blog index)
- [ ] *!*404
- [ ] *!*Search
- [ ] *!*Tipos de cabecera
- [ ] *!*Tipos de footer
- [X] *!*Tener la plantilla base twig en Ent

### Misc
- [ ] *!*`config.php` timezone fuera, poner como opcional…
- [ ] *!*Instalar: un plugin bueno para compartir en redes sociales
- [ ] *!*Analytics mediante Ent
- [ ] Añadir tamaños de imagen siguiendo el número de columnas (?).
- [ ] Documentar el listado de plugins que molan y para que se utilizan. Falta: calendarios. Better Font Awesome (?).
- [ ] Tener un /style-guide donde mirar como quedan los diferentes elementos?
- [ ] Añadir un checklist? Analytics, SEO…
    - Cambiar: `Theme > Analytics ID`
    - Cambiar: `SEO > Home Page Settings > Custom Home Page Title Tagline`
- [ ] Chequear si se han regenerado los salts de wp-config
- [ ] Tests
- [ ] Caching y optimización de wordpress (investigar)
- [X] *!*Opciones a nivel de theme con CarbonFields, como gestionar? `src/theme-options.php`?
- [X] *!*Instalar: the seo framework y solucionar gestion de títulos

### i18n
- [ ] *!*Añadir traducciones YAML a nivel de Ent con namespace `ent.*`
- [ ] Crear plugin para copiar contenido de CF entre idiomas de WPML. Molaria que sincronice **unos campos** automaticamente entre plantillas cuando se guarda o se duplica mediante WPML.

### Forms
- [ ] Formularios: gravity forms?

### Visual Composer
- [ ] *!*No se esta cargando en las páginas.
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
- [ ] Como es posible que en Fil a l'Agulla tengamos 3mb de vendors.js!???! Ponerme al día con temas de optimización.
- [ ] Como gestionar los iconos? (a Anna le gusta personalizarlos)
- [ ] Hyphenate
- [ ] Unorphan

---

## Munger
- [ ] *!*Volver a $padding vs `mu-with-gutter-size`. Cambiar nombres: `$unit`, `$unit-05`, `$unit-025` y `$unit-2`. Montarlo utilizando `rem`s, y que lo único que cambie entre small, medium y large sea el tamaño de fuente del body.
- [ ] *!*Gestionar mejor tema escala tipográfica (modular scale). Ahora es un poco caos. Foundation da un notice: "$header-sizes has been replaced with $header-styles", ver si ahora esta mejor solucionado.
- [ ] *!*Que hacer con Munger? Vamos a seguir utilizando Bolt y Silex… asi que…

---

## Infraestructura/Tooling
- [ ] *!*Que hacer con los salts? Si se regenera `wp-config.php` el login peta? que pasos hay que seguir cuando se empieza un nuevo proyecto?
- [ ] Todo tema headers/footers gestionar a traves de Plop? `plop header labcoop` o `plop footer filagulla`
- [ ] Plops para CPTs de uso habitual: team/staff, noticias, recursos…
- [ ] `plop component`: generar carpeta y archivos, registrar .scss. Que pregunte si es tipo: normal, container-parent o container-child.
- [ ] `plop component-tpl`
    - generar `twig` y `admin.html`. Detectar el listado de parametros, basandonos en el tipo de cada parametro generar el código que toca (imagen, link, texto…). Molaria que tambien mire `get_context_data` para por lo menos saber que otras variables hay. Si es plural `resources` que genere un `{% for %}`
    - tener en cuenta si es tipo container o no en base a eso `.row.small-up-1...` + admin.html con `<container/>`,
    - crear el código autogenerado al principio y entre unos delimitadores:
    {# <page-fields-cheatsheet> #}
    {# </page-fields-cheatsheet> #}

---

## Staging & deploy
- [ ] Staging: servidor de l'Apostrof, subir mediante SSH
- [ ] Staging: actualizar vendors, plugins, plantilla, DB… mediante SSH y en un comando
- [ ] Deploy: primera vez, Duplicator.
- [ ] Deploy: actualizar plantilla en el servidor del cliente? Deploy por FTP? Como actualizar vendors?
    - https://github.com/dg/ftp-deployment

---

## Misc
- [ ] Hemendik gauza interesgarri batzuk ateatzia zeudek? http://wpgear.org 
- [ ] http://wptest.io/demo/
- [ ] https://github.com/wp-premium => Plugins via GIT!

---

## Known issues
- [ ] PuPHPet, NFS actimeo=2 https://github.com/puphpet/puphpet/issues/2466
- [ ] Añadir WPML via GIT: https://github.com/wp-premium/sitepress-multilingual-cms y https://github.com/wp-premium/wpml-media hay un issue que se interpone >:( https://github.com/composer/installers/issues/313

