<?php

require_once __DIR__ . '/vendor/autoload.php';

$application = new \App\Application($argv);
$application->run();

