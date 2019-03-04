# rabbit_connector
Прослойка для гибкой работы c RabbitMQ.   
  ## Install
  - ```docker-compose up -d```
  - ```docker-compose exec fpm composer update```
  - ```docker-compose exec fpm php index.php```
---
#### Административная панель: ``http://localhost:15672``

#### Тесты: ``docker-compose exec fpm vendor/bin/phpunit Tests/``