<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',         // atau IP server PostgreSQL
    'username' => 'nama_user_pgsql',
    'password' => 'password_pgsql',
    'database' => 'nama_database_pgsql',
    'dbdriver' => 'postgre',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);


// Pudin End
