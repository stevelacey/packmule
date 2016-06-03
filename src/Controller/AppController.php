<?php

namespace Packmule\Controller;

use Silex\Application,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    public function indexAction(Application $app)
    {
        return $this->render($app, 'index.html.twig', []);
    }

    public function becomeAction(Application $app)
    {
        return $this->render($app, 'become.html.twig', []);
    }

    public function findAction(Application $app)
    {
        return $this->render($app, 'find.html.twig', []);
    }
}
