<?php
// Define environment constant
define('WP_ENV', __DIR__ == '/var/project/wordpress' ? 'DEV' : 'PROD');

// Load configuration
$config = require_once(__DIR__ .'/config/dev.php');

if (WP_ENV == 'PROD') {
    $config = array_merge($config, require_once(__DIR__ .'/config/prod.php'));
}

define('ROOT_DIR', __DIR__);

// URLs
define('WP_HOME', $config['WP_HOME']);
define('WP_SITEURL', WP_HOME . '/wp');

// Custom Content Directory
define('WP_CONTENT_DIR', __DIR__ . '/app');
define('WP_CONTENT_URL', WP_HOME . '/app');

// DB conection
define('DB_NAME',     'dbname');
define('DB_USER',     'dbuser');
define('DB_PASSWORD', '123');
define('DB_HOST',     '127.0.0.1');
define('DB_CHARSET',  'utf8');
define('DB_COLLATE',  '');

// Authentication unique keys and salts
define('AUTH_KEY',         '9fee305f2d0c7cd194cda2345598e39230af751bed80d28edc5cd0824605b89b');
define('SECURE_AUTH_KEY',  '898daa032c711aaa671329d52e729580215f8310be4af118d65998b73be13031');
define('LOGGED_IN_KEY',    '5b70e3db7161c9d054c447169f8a1c4c3e02b66c9af971c6cda03c87d09c2778');
define('NONCE_KEY',        '9f27a43b94b58940b62bc2694593fd6d49d1051491acf04c7e640fdbe6f8e6a4');
define('AUTH_SALT',        'c7418572bf5c25bc0ba7572e83dacb6bdf22870820a2ade541c6a8036c0f5813');
define('SECURE_AUTH_SALT', '0657976fee456d477529ade987394e60c2e75292c8ff2a11637ff5b97ddb719d');
define('LOGGED_IN_SALT',   'ae4cc6fb22b538c46dd037756b7507b66ea86c1a7e6d63f0e49e4af94b8b232a');
define('NONCE_SALT',       'b86da0b9540071ea0cd93bb9ecffcc2db734de4a6b50aa8b1ec75cd86eafe3f8');

// WordPress database table prefix
$table_prefix = 'wp_';

// Absolute path to the WordPress directory.
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/wp/');
}

// Sets up WordPress vars and included files.
require_once(ABSPATH . 'wp-settings.php');
