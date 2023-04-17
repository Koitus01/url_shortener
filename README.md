# url_shortener

TODO: 
1. крон для обновления updated_at
2. аппликейшен тесты на роуты?
3. 

## Requirements
1. [Docker](https://docs.docker.com/get-docker/)
2. [Docker compose](https://docs.docker.com/compose/install/)

## Инструкция по развертыванию

«Склонировать» проект:

    git clone https://github.com/Koitus01/url_shortener.git

Перейти в директорию с ним:

    cd url_shortener

Запустить контейнеры: 

    # Если docker compose установлен как «standalone package»:
    docker-compose up -d

    # Если как плагин для docker'a:
    docker compose up -d

Прогнать миграции для dev и testing баз:

    # Есть таймаут в 10 секунд, поскольку контейнер с mysql может подниматься с задержкой
    chmod 755 ./docker/entrypoint.sh && ./docker/entrypoint.sh

## Использование

После развертывания веб интерфейс должен быть доступен по адресу: http://localhost:8080

Сокращенные ссылки также можно создавать из консоли:

    docker exec -it url_shortener_app ./bin/console app:link:create

Запуск тестов: 

    docker exec -it url_shortener_app php bin/phpunit



## Чистка
Удаление ненужных контейнеров и volum'ов после тестов:

    docker rm --force url_shortener_db url_shortener_webserver url_shortener_app && docker volume rm url_shortener_dbdata 

