<?php

namespace Component;

/*
 *  По сути, хранение конфигурации подключения можно реализовать как угодно. Здесь лишь краткий пример.
 */
class Configaration
{
    public static $parameters = [
        'host'     => 'rabbit1',
        'port'     => 5672,
        'user'     => 'admin',
        'password' => 'admin',
        'vhost'    => '/'
    ];
}