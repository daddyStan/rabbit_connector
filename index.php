<?php

require __DIR__.'/vendor/autoload.php';

/* Создаём экземпляр RabbitHelper */
$app = new \Component\RabbitHelper();

///** Создаём подключение и связку очереди, обменника и роута */
//$app->connectToRoute('test');
//$app->bind('test', 'test', 'test');


//for ($i=0; $i < 100; $i++) {
//    $app->send('test_message');
//}

/** Делаем попытку отправить сообщение */
//if ( $app->send('test_message') ) {
//    print "Message is sent \n";
//} else {
//    print "Something is wrong \n";
//}

$app->connectToQueue('test');
/** Делаем попытку отправить сообщение */
$app->receive();