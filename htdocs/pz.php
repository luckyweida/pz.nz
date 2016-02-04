<?php
require __DIR__ . '/../config.php';

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use Silex\Provider;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;


$loader = require CMS . 'vendor/autoload.php';
//TODO: fix pz spacename
$loader->add('Pz', CMS . 'vendor/luckyweida/pz/src');
$loader->add('Site', __DIR__ . '/../src');


$app = new Pz\Application();
$app['debug'] = DEBUG_ENABLED;

require CMS . 'vendor/luckyweida/pz/metadata.php';

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => CMS . 'vendor/luckyweida/pz/views',
    'twig.form.templates' =>  array(
        'form.twig'
    ),
    'twig.options' => array(
        'cache' => __DIR__ . '/../cache/twig/',
        'auto_reload' => true
    )
));

$app["twig"] = $app->share($app->extend("twig", function (\Twig_Environment $twig, Silex\Application $app) {
    $twig->addExtension(new Pz\Twig\Extension($app));
    return $twig;
}));

$app->register(new Silex\Provider\ValidatorServiceProvider(), array());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array(
        'en'
    )
));

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
$driverImpl = $config->newDefaultAnnotationDriver(array(
    __DIR__ . "/../cache"
), false);

$config->setMetadataDriverImpl($driverImpl);
$config->setProxyDir(__DIR__ . '/../cache/Proxies');
$config->setProxyNamespace('Proxies');
$connectionOptions = array(
    'driver' => 'pdo_mysql',
    'host' => DB_HOST,
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHAR
);
$app['em'] = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'pz' => array(
            'pattern' => '^/pz/',
            'logout' => array(
                'logout_path' => '/pz/logout/',
                'target_url' => '/pz_login/'
            ),
            'form' => array(
                'login_path' => '/pz_login/',
                'check_path' => '/pz/login_check/',
                'default_target_path' => '/pz/'
            ),
            'users' => $app->share(function () use ($app) {
                return new Pz\Users\UserProvider($app['em']);
            })
        )
    )
));

$app['security.authentication_provider.dao._proto'] = $app->protect(function ($name) use($app) {
    return $app->share(function () use($app, $name) {
        return new DaoAuthenticationProvider($app['security.user_provider.' . $name], $app['security.user_checker'], $name, $app['security.encoder_factory'], false);
    });
});

$app->register(new \Pz\Services\Generic());

$app->mount('/pz/model', new Pz\Controllers\Model($app, array()));
$app->mount('/pz/content', new Pz\Controllers\Content($app, array()));

$app->mount('/pz', new Pz\Controllers\HomeCSP($app, array()));
$app->mount('/pz_login', new Pz\Controllers\LoginCSP($app, array()));

$app->error(function (\Exception $e, $code) use($app) {
    if ($code == 404) {
        return new Symfony\Component\HttpFoundation\Response($app['twig']->render('404.twig', array()), 200);
    } else if ($code == 401) {
        return new Symfony\Component\HttpFoundation\Response($app['twig']->render('401.twig', array()), 200);
    }
});

$app->run();
