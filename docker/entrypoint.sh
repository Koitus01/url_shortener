sleep 10
docker exec -it url_shortener_app php bin/console doctrine:migrations:migrate -n
docker exec -it url_shortener_app php bin/console --env=test doctrine:schema:create