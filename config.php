<?php

define('CLIENT', 'Pozo Software Ltd');

ini_set('magic_quotes_sybase', 0);
date_default_timezone_set('Pacific/Auckland');
define('CDN', 'http://index.net.nz/pozo');
define('DOMAIN', 'http://' . $_SERVER['HTTP_HOST']);

define('DEBUG_ENABLED', true);
error_reporting(E_ALL);


define('CMS', __DIR__ . '/../../../cms/v1.0/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'ckywgma30362com38023_pz');
define('DB_USER', 'root');
define('DB_PASS', 'er1c550n');
define('DB_CHAR', 'utf8');
define('IMAGICK', 'convert');

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'ns.gresource@gmail.com');
define('SMTP_PASS', 'weida911');

