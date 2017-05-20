var path = require('path');
var paths = {
    theme: 'wordpress/app/themes/ent',
    src:   'wordpress/app/themes/ent/src',
}

module.exports = {
    paths: {
        public: path.join(paths.theme, '/assets'),
        watched: [
            path.join(paths.src, '/assets'),
            path.join(paths.src, '/javascripts'),
            path.join(paths.src, '/scss'),
        ],
    },
    files: {
        javascripts: {
            joinTo: {
                'main.js':    path.join(paths.src, '/javascripts/**'),
                'vendors.js': /^(?!javascripts)/,
            }
        },
        stylesheets: {
            joinTo: 'main.css'
        },
    },
    npm: {
        globals: {
            jQuery: 'jquery',
        }
    },
    conventions: {
        assets: /(assets|vendors\/assets|fonts)/
    },
    modules: {
        nameCleaner: function (path) {
            path = path.replace(paths.src +'/', '');
            path = path.replace(/^javascripts\//, '');

            return path;
        },
    },
    plugins: {
        fingerprint: {
            manifestGenerationForce: true,
            manifest: path.join(paths.theme, '/assets/assets.json'),
            srcBasePath: 'wordpress/app/themes/ent/assets/',
            destBasePath: 'wordpress/app/themes/ent',
        },
        copycat: {
            fonts: ['node_modules/font-awesome/fonts'],
        },
        sass: {
            options: {
                includePaths: [
                    'node_modules/font-awesome/scss',
                    'node_modules/foundation-sites/scss',
                    'node_modules',
                ]
            }
        },
        postcss: {
            processors: [
                require('autoprefixer')(['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 8']),
                require('csswring'),
            ]
        },
        uglify: {
            mangle: true,
            compress: {
                global_defs: {
                    DEBUG: false
                }
            }
        },
        browserSync: {
            port: 3333,
            proxy: 'apostrof-wordpress.dev',
            logLevel: 'debug'
        }
    }
};
