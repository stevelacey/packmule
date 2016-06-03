<?php

namespace Packmule\Controller;

use Silex\Application,
    Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    protected function render(Application $app, $template, $parameters = [])
    {
        return new Response(
            $app['twig']->render($template, $parameters), 200, [
                'Cache-Control' => 's-maxage=604800'
            ]
        );
    }
}
