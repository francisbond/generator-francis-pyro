<?php

/**
 * Database Configuration
 */

/** Define site host */
if (isset($_SERVER['X_FORWARDED_HOST']) && !empty($_SERVER['X_FORWARDED_HOST'])) {
  $hostname = $_SERVER['X_FORWARDED_HOST'];
} else {
  $hostname = $_SERVER['HTTP_HOST'];
}

/** Set environment based on hostname */
switch ($hostname) {

  case '<%= _.slugify(slug) %>.pyro.dev':
    $db['default'] = array(
        'hostname'    =>  'localhost',
        'username'    =>  'root',
        'password'    =>  'root',
        'database'    =>  '<%= _.slugify(slug) %>',
        'dbdriver'    =>  'mysql',
        'dbprefix'    =>  'pyro_',
        'active_r'    =>  true,
        'pconnect'    =>  false,
        'db_debug'    =>  true,
        'cache_on'    =>  false,
        'char_set'    =>  'utf8',
        'dbcollat'    =>  'utf8_unicode_ci',
        'port'        =>  3306,

        // 'Tough love': Forces strict mode to test your app for best compatibility
        'stricton'    => true,
    );

    break;

  default:
    $db['default'] = array(
        'hostname'    =>  getenv('DB_HOST'),
        'username'    =>  getenv('DB_USER'),
        'password'    =>  getenv('DB_PASSWORD'),
        'database'    =>  getenv('DB_NAME'),
        'dbdriver'    =>  'mysql',
        'active_r'    =>  true,
        'pconnect'    =>  false,
        'db_debug'    =>  true,
        'cache_on'    =>  false,
        'char_set'    =>  'utf8',
        'dbcollat'    =>  'utf8_unicode_ci',
        'port'        =>  getenv('DB_PORT')
    );
}

/** Clean up */
unset($hostname);
