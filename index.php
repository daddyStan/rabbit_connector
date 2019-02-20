<?php

require __DIR__.'/vendor/autoload.php';

$app = new \Component\RabbitHelper();
$app->connectToRoute('test');
$app->bind('test', 'test', 'test');
$app->send("test_message");