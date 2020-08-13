#!/bin/bash

docker-compose up -d

id=`docker-compose ps -q php`

docker-compose exec php php Download.php
docker cp ${id}:/listed_stocks.json listed_stocks.json
docker cp ${id}:/listed_stocks.minify.json listed_stocks.minify.json

docker-compose down
