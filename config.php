<?php

ini_set('magic_quotes_sybase', 0);
date_default_timezone_set('Pacific/Auckland');
define('CDN', 'http://final.nz');
//define('CDN', 'http://192.168.20.121:3003/pozo');
define('CMS', __DIR__ . '/../../cms/v1.0/');
if (isset($_SERVER['HTTP_HOST'])) {
    define('DOMAIN', 'http://' . $_SERVER['HTTP_HOST']);
}
define('DEFAULT_NAMESPACE', 'Site');


define('DEV', true);
define('DEBUG_ENABLED', DEV);
if (DEV) {
    //dev
    error_reporting(E_ALL);
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'ckywgma30362com38023_pz');
    define('DB_USER', 'root');
    define('DB_PASS', 'er1c550n');
    define('DB_CHAR', 'utf8');

    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_PORT', 587);
    define('SMTP_USER', 'ns.gresource@gmail.com');
    define('SMTP_PASS', 'weida911');

    define('IMAGICK', 'convert');
} else {
    //live
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'ckywgma30362com38023_pz');
    define('DB_USER', 'root');
    define('DB_PASS', 'er1c550n');
    define('DB_CHAR', 'utf8');

    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_PORT', 587);
    define('SMTP_USER', 'ns.gresource@gmail.com');
    define('SMTP_PASS', 'weida911');

    define('IMAGICK', 'convert');
}

define('CLIENT', 'Pozo Software Ltd');
