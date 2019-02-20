<?php
declare(strict_types=1);

namespace Component;

use Component\Interfaces\RabbitHelperInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitHelper implements RabbitHelperInterface
{
    private $configuration;

    private $connection;

    private $channel;

    private $exchange;

    private $queue;

    private $route;

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     * @return self
     */
    public function setRoute($route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param mixed $queue
     * @return self
     */
    public function setQueue($queue): self
    {
        $this->queue = $queue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @param mixed $exchange
     * @return self
     */
    public function setExchange($exchange): self
    {
        $this->exchange = $exchange;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param mixed $channel
     * @return self
     */
    public function setChannel($channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     * @return self
     */
    public function setConnection($connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param mixed $configuration
     * @return self
     */
    public function setConfiguration($configuration): self
    {
        $this->configuration = $configuration;
        return $this;
    }

    public function __construct()
    {
        $this->setConfiguration(new Configaration());
    }

    /**
     * @param $message
     * @return bool
     */
    public function send($message): bool
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

    /**
     * @return bool
     */
    public function connectToQueue(): bool
    {

        $this->setConfiguration([
            'host'      => $this->getContainer()->getParameter($this->getPrefix() . 'host'),
            'port'      => $this->getContainer()->getParameter($this->getPrefix() . 'port'),
            'vhost'     => $this->getContainer()->getParameter($this->getPrefix() . 'vhost'),
            'user'      => $this->getContainer()->getParameter($this->getPrefix() . 'user'),
            'password'  => $this->getContainer()->getParameter($this->getPrefix() . 'password')
        ]);

        try {
            $this->setConnection(new AMQPStreamConnection(
                    $this->getConfig()['host'],
                    $this->getConfig()['port'],
                    $this->getConfig()['user'],
                    $this->getConfig()['password'],
                    $this->getConfig()['vhost']
                )
            );

            $this->setChannel($this->getConnection()->channel());
            $this->setExchange( $this->getEnv() . $this->getContainer()->getParameter($this->getType())['exchange'] );
            $this->setQueue( $this->getEnv() . $this->getContainer()->getParameter($this->getType())['queue'] );

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}