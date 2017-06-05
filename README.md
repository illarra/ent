# l'Apòstrof Wordpress

- [Retomar proyecto](#markdown-header-retomar-proyecto-de-cliente-fork)
- [Iniciar proyecto](#markdown-header-iniciar-proyecto-de-cliente-desde-apostrof-wordpress-primer-fork)
- [Desarrollo](#markdown-header-desarrollo)
    - [_Style Guide_](#markdown-header-style-guide)
    - [Cambiar header](#markdown-header-cambiar-header)

---

## Retomar proyecto de cliente (fork)

**Quieres continuar con un proyecto? Puede que lo tengas que cargar desde casa, pero ahora ya desde el repositorio del proyecto del cliente… sigue estos pasos. Btw, no hagas horas extras en casa.**

Facil y para toda la familia:

- Crear maquina virtual: `$ vagrant up`
- Actualiza `/etc/hosts` con el dominio e IP que sale en `puphpet/config.yaml` 
- Entrar en la maquina: `$ vagrant ssh`
    - `$ composer intall`
    - `$ db-import`
- En tu maquina, carpeta `project`:
    - `$ yarn install`

## Iniciar proyecto de cliente desde `apostrof/wordpress` (primer fork)

**Sigue este apartado para la primera vez que tengas que poner el proyecto en marcha: hacer fork, cambiar configuración… Esto se hace solo una vez por cliente/proyecto.**

### Fork del repositorio

- Hacer un fork del proyecto via BitBucket, nombre del proyecto `{CLIENT}-{PROJECT}` (ejemplo: `matriu-appoderat`, `iridia-web`...)
- Clonar el fork
- Añadir un nuevo remote: `git remote add wordpress https://bitbucket.org/apostrof/wordpress.git`

### Actualizar PuPHPet

- Editar `puphpet/config.yaml`
    - Replace `apostrof-wordpress` con el nombre del proyecto `{CLIENT}-{PROJECT}`
    - Cambiar IP `192.168.16.101` siguiendo patron `192.168.{YEAR}.{PROJECT_ID}` 
- Editar `/etc/hosts`
    - Añadir `192.168.xxx.yyy {CLIENT}-{PROJECT}.dev` (la misma IP de PuPHPet)

```yaml
vagrantfile:
    vm:
        provider:
            local:
                machines:
                    vflm_8vqev94ahaz7:
                        id: apostrof-wordpress
                        hostname: apostrof-wordpress.dev
                        network:
                            private_network: 192.168.16.101

nginx:
    vhosts:
        nxv_o64qt2azr14l:
            server_name: apostrof-wordpress.dev
            server_aliases:
                - www.apostrof-wordpress.dev
```

### Crear maquina virtual

- Asegurate de que tienes `vagrant` y `virtualbox` instalados
    - Check: `$ brew cask list`
    - Install: `$ brew cask install vagrant virtualbox`
        - **Problemas con VirtualBox? Prueba con la versión `5.0.26`.**
- Crear maquina: `$ vagrant up`

### Instalar dependencias

- Entrar en la maquina virtual: `$ vagrant ssh`
    - Ir a la carpeta `project` (`$ proj`) y ejecutar: `$ composer install`
- En tu maquina, en la carpeta `project`:
    - Actualizar `brunch-config.js` valor de `module.exports.plugins.browserSync.proxy`
    - Instalar dependencias frontend: `$ yarn install`

### Poner WordPress en marcha

- Editar `project/wordpress/config/dev.php` cambiar `WP_HOME` e introducir `http://{CLIENT}-{PROJECT}.dev`
- En la maquina virtual:
    - Carga datos en la base de datos: `$ db-import`
    - Ir a `$ cd /var/project/wordpress`
    - Cambiar URL vieja en la DB: `$ wp search-replace 'apostrof-wordpress.dev' '{CLIENT}-{PROJECT}.dev' --skip-columns=guid`
    - Actualizar salts de WordPress: `$ plop wp-config`
    - Hacer backup de la DB: `$ db-export`

### Commit & profit

![](setup-done.gif)

## Desarrollo

### Style Guide

...

### Cambiar header

...

### Añadir un post type

- `$ plop post-type` o algun otro generator dentro de ese namespace.
