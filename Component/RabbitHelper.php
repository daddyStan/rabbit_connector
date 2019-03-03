<?php
declare(strict_types=1);

namespace Component;

use Component\Interfaces\RabbitHelperInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitHelper implements RabbitHelperInterface
{
    /** @var Configaration */
    private $configuration;

    /** @var AMQPStreamConnection */
    private $connection;

    /** @var AMQPChannel */
    private $channel;

    /** @var string */
    private $exchange;

    /** @var string */
    private $queue;

    /** @var string */
    private $route;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     * @return self
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * @param string $queue
     * @return self
     */
    public function setQueue(string $queue): self
    {
        $this->queue = $queue;
        return $this;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @param string $exchange
     * @return self
     */
    public function setExchange(string $exchange): self
    {
        $this->exchange = $exchange;
        return $this;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @param AMQPChannel $channel
     * @return self
     */
    public function setChannel(AMQPChannel $channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    /**
     * @param AMQPStreamConnection $connection
     * @return self
     */
    public function setConnection(AMQPStreamConnection $connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return Configaration
     */
    public function getConfiguration(): Configaration
    {
        return $this->configuration;
    }

    /**
     * @param Configaration $configuration
     * @return self
     */
    public function setConfiguration(Configaration $configuration): self
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * RabbitHelper constructor.
     * Подтягиваем необходимые зависимости
     */
    public function __construct()
    {
        $this->setConfiguration(new Configaration());
    }

    /**
     * Отправляем сообщение
     * @param $message
     * @return bool
     */
    public function send(string $message): bool
    {
        $msg = new AMQPMessage($message);

        try {
            $this->getChannel()->basic_publish(
                $msg,
                $this->getExchange(),
                $this->getRoute()
                );

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Коннект для продюсера, конектимся к точке обмена, шлём сообщения по ключу маршрута
     * @param string $route
     * @return bool
     */
    public function connectToRoute(string $route = null): bool
    {
        $config = Configaration::$parameters;

        try {
            $this->setConnection(new AMQPStreamConnection(
                    $config['host'],
                    $config['port'],
                    $config['user'],
                    $config['password'],
                    $config['vhost']
                )
            );

            $this->setChannel($this->getConnection()->channel());
            $this->setExchange( 'test' );
            $this->setQueue( 'test' );

            if ( null === $route ) {
                $this->setRoute('test');
            } else {
                $this->setRoute($route);
            }

            return true;
        } catch (\Exception $e) {
            print $e;
            return false;
        }
    }

    /**
     * Связываем цепочку Точка Обмена -> Роут -> Очередь
     * @param $queue
     * @param $exchange
     * @param $route
     */
    public function bind($queue, $exchange, $route): void
    {
        $this->getChannel()->exchange_declare($exchange, 'direct',false, true, false);
        $this->getChannel()->queue_declare($queue, false, true, false, false);
        $this->getChannel()->queue_bind($queue, $exchange, $route);
    }

    public function connectToQueue(): bool
    {
        // TODO: Implement connectToQueue() method.
    }

    public function receive(): bool
    {
        // TODO: Implement receive() method.
    }

}