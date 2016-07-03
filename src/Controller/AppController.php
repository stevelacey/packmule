<?php

namespace Packmule\Controller;

use Silex\Application,
    Symfony\Component\Form\Extension\Core\Type\ChoiceType,
    Symfony\Component\Form\Extension\Core\Type\FormType,
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

    public function tripsAction(Application $app, Request $request)
    {
        $countries = array_map(
            'current',
            $app['db']->fetchAll('select distinct(country) from trips order by country')
        );
        $countries = array_combine($countries, $countries);

        $to = '';
        if (!$request->get('to') && $request->getClientIp() != '127.0.0.1') {
            try {
                $geocoder = new \Geocoder\Provider\FreeGeoIp(new \Ivory\HttpAdapter\CurlHttpAdapter());
                $to = $geocoder->geocode($request->getClientIp())->first()->getCountry()->getName();
            } catch (\Ivory\HttpAdapter\HttpAdapterException $e) {
            }
        }

        $options = ['choices' => $countries, 'placeholder' => '', 'required' => false];

        $form = $app['form.factory']->createNamedBuilder('', FormType::class, ['to' => $to])
            ->setMethod('GET')
            ->add('from', ChoiceType::class, $options)
            ->add('to', ChoiceType::class, $options)
            ->getForm();
        $form->handleRequest($request);

        $trips = $app['db']->fetchAll(
            '
                select

                ft.id,
                ft.username,
                concat(\'https://nomadtrips.co/\', ft.username) url,
                pt.city from_city,
                pt.country from_country,
                pt.latitude from_latitude,
                pt.longitude from_longitude,
                ft.city to_city,
                ft.country to_country,
                ft.latitude to_latitude,
                ft.longitude to_longitude,
                pt.end departure,
                ft.start arrival

                from trips ft

                left join trips pt on pt.id = (
                    select id from trips
                    where id != ft.id
                        and username = ft.username
                        and "start" < ft.start
                        and "end" < ft.end
                    order by start desc
                    limit 1
                )

                where ft.start > now()
                ' . ($form['from']->getData() ? 'and pt.country = ?' : '') . '
                ' . ($form['to']->getData()   ? 'and ft.country = ?' : '') . '
                order by arrival
                limit 20
            ',
            array_values(array_filter([
                $form['from']->getData(),
                $form['to']->getData(),
            ]))
        );

        return new Response($app['twig']->render('trips.html.twig', [
            'countries' => $countries,
            'form' => $form->createView(),
            'trips' => $trips,
        ]));
    }
}
