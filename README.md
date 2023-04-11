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

Удаление ненужных контейнеров после тестов:

    docker rm --force url_shortener_db url_shortener_webserver url_shortener_app

