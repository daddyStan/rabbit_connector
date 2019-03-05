<?php

namespace Tests\Component;

use Component\RabbitHelper;
use PHPUnit\Framework\TestCase;

class RabbitHelperTest extends TestCase
{
    /** @var RabbitHelper */
    protected $rabbitHelper;

    protected function setUp()
    {
        $this->rabbitHelper = new RabbitHelper();
    }

    /**
     * Тестируем подключение
     */
    public function testConnectToRoute(string $route = null): void
    {
        $this->assertTrue($this->rabbitHelper->connectToRoute('test'));
    }

    /**
     * Тестируем подключение и отправку
     */
    public function testSend(): void
    {
        $this->assertTrue($this->rabbitHelper->connectToRoute('test'));
        $this->assertTrue($this->rabbitHelper->send('test to test'));
    }

    public function testConnectToQueue(): void
    {
        $this->rabbitHelper->connectToQueue();
    }

    public function testReceive(): void
    {
        $this->rabbitHelper->connectToQueue();
        $this->rabbitHelper->receive();
    }
}