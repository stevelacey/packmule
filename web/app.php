<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../app/app.php';

Symfony\Component\HttpFoundation\Request::setTrustedProxies(array('127.0.0.1', '::1'));

$app->run();
