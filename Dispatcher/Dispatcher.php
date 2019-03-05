<?php

namespace Dispatcher;

use Dispatcher\Interfaces\DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    public function dispatch(string $message)
    {
        var_dump($message);
    }
}