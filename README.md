# url_shortener

## Requirements
1. Docker compose:

## Инструкция по развертыванию

«Склонировать» проект:

    git clone https://github.com/Koitus01/url_shortener.git

Перейти в директорию с ним:

    cd url_shortener

Если docker compose установлен как «standalone package»:

    docker-compose up -d

Если как плагин для docker'a:

    docker compose up -d

«Прогон» миграций:
    
    chmod 755 ./docker/entrypoint.sh && ./docker/entrypoint.sh

Веб интерфейс теперь доступен по адресу: http://localhost:8080

Консольное создание сокращенной ссылки:

    docker exec -it url_shortener_app ./bin/console app:create:link

## Чистка
Удаление ненужных контейнеров и volum'ов после тестов:

    docker rm --force url_shortener_db url_shortener_webserver url_shortener_app && docker volume rm url_shortener_dbdata 

