<?php

namespace Dispatcher;

use Dispatcher\Interfaces\DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    public $tempArray = [];

    /**
     * @param string $message
     */
    public function dispatch(string $message)
    {
        /**
         * Работаем с принятыми сообщениями как нам надо
         */
        print ($message . "\n");
        $this->tempArray[] = $message;
    }
}