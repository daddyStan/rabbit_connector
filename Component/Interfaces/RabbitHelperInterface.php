<?php
declare(strict_types=1);

namespace Component\Interfaces;

/**
 * Interface RabbitHelperInterface
 * @package Component\Interfaces
 */
interface RabbitHelperInterface
{
    public function send(string $message): bool;
    public function bind($queue, $exchange, $route): void;
    public function connectToRoute(string $route = null): bool;
    public function connectToQueue(string $queue): bool;
    public function receive(): void ;
}