<?php

$app = new Silex\Application();

$app['title'] = 'Packmule';
$app['name'] = 'Packmule';
$app['twitter'] = 'Packmule';
$app['description'] = 'Packmule';
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider, ['twig.path' => __DIR__ . '/../views']);
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text($app));
    $twig->addExtension(
        new Misd\LinkifyBundle\Twig\Extension\LinkifyTwigExtension(
            new Misd\LinkifyBundle\Helper\LinkifyHelper(
                new Misd\Linkify\Linkify()
            )
        )
    );

    return $twig;
}));

$app->get('/', 'Packmule\Controller\AppController::indexAction')->bind('home');
$app->get('/become', 'Packmule\Controller\AppController::becomeAction')->bind('become');
$app->get('/find', 'Packmule\Controller\AppController::findAction')->bind('find');

return $app;
