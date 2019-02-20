<?php
declare(strict_types=1);

namespace Component\Interfaces;

interface RabbitHelperInterface
{
    public function send($message): bool;
    public function bind($queue, $exchange, $route): void;
    public function connectToRoute(string $route = null);
    public function connectToQueue();
}