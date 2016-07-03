<?php

$app = new Silex\Application();

$app['env'] = strpos(__DIR__, 'subdomains/packmule') !== false ? 'prod' : 'dev';

foreach (['app', $app['env'], 'secrets'] as $config) {
    if (file_exists(__DIR__ . '/../config/' . $config . '.yml')) {
        $app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__ . '/../config/' . $config . '.yml'));
    }
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), ['db.options' => $app[$app['env']]['database']]);
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), ['locale' => 'en']);
$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => __DIR__ . '/../views']);

$app->get('/', 'Packmule\Controller\AppController::indexAction')->bind('home');
$app->get('/become', 'Packmule\Controller\AppController::becomeAction')->bind('become');
$app->get('/find', 'Packmule\Controller\AppController::findAction')->bind('find');
$app->get('/trips', 'Packmule\Controller\AppController::tripsAction')->bind('trips');

return $app;
