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

    public function testBind()
    {
        $this->rabbitHelper->connectToRoute('test');
        $this->rabbitHelper->bind('test', 'test', 'test');
    }

    /**
     * Тестируем подключение
     */
    public function testConnectToRoute(): void
    {
        $this->assertTrue($this->rabbitHelper->connectToRoute('test'));
    }

    /**
     * Тестируем подключение и отправку
     */
    public function testSend(): void
    {
        $this->assertTrue($this->rabbitHelper->connectToRoute('test'));
        $this->assertTrue($this->rabbitHelper->send('test for test'));
    }

    /**
     * Тестируем подключение к очереди
     */
    public function testConnectToQueue(): void
    {
        $this->rabbitHelper->connectToQueue('test');
    }

    /**
     * Тестируем получение сообщений
     * @expectedException
     */
    public function testReceive(): void
    {
        $this->rabbitHelper->connectToQueue('test');
        $this->rabbitHelper->receive();
        $this->assertSame('test for test', $this->rabbitHelper->getDispatcher()->tempArray[0]);
    }
}