<?php
require __DIR__ . '/../config.php';

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use Silex\Provider;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;

$loader = require CMS . 'vendor/autoload.php';
$loader->add('Pz', CMS . 'vendor/luckyweida/pz/src');

$app = new Silex\Application();
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

// $app->register(new Silex\Provider\SecurityServiceProvider(), array(
// 	'security.firewalls' => array(
// 		'Pz' => array(
// 			'pattern' => '^/Pz/',
// 			'logout' => array(
// 				'logout_path' => '/Pz/logout',
// 				'target_url' => '/Pz_login'
// 			),
// 			'form' => array(
// 				'login_path' => '/Pz_login',
// 				'check_path' => '/Pz/login_check',
// 				'default_target_path' => '/Pz'
// 			),
// 			'users' => $app->share(function () use($app) {
// 				return new Pz\Users\UserProvider($app['em']);
// 			})
// 		)
// 	)
// ));

$app['security.authentication_provider.dao._proto'] = $app->protect(function ($name) use($app) {
    return $app->share(function () use($app, $name) {
        return new DaoAuthenticationProvider($app['security.user_provider.' . $name], $app['security.user_checker'], $name, $app['security.encoder_factory'], false);
    });
});

// $app->register(new Silex\Provider\MonologServiceProvider(), array(
// 'monolog.logfile' => __DIR__.'/development.log',
// ));

// $encoder = new MessageDigestPasswordEncoder();
// $user = new \Entity\CMS\User ();
// $user->setLogin ( 'admin' );
// $user->setPasswd ( $encoder->encodePassword ( '123456', '' ) );
// $app ['em']->persist ( $user );
// $app ['em']->flush ();

// $app->register(new Pz\Services\GenericSP());
// $app->register(new Pz\Services\UserSP());

// $app->mount('/Pz/contents/Orders', new Dft\Controllers\OrderCSP($app, array()));
// $app->mount('/Pz/contents/ID photocopies', new Dft\Controllers\SubmissionCSP($app, array()));

// $app->mount('/Pz/pages', new Pz\Controllers\PageCSP($app, array()));
// $app->mount('/Pz/assets', new Pz\Controllers\AssetCSP($app, array()));
// $app->mount('/Pz/contents', new Pz\Controllers\ContentCSP($app, array()));

$app->mount('/pz/models', new Pz\Controllers\Model($app, array()));

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
