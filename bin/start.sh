#!/usr/bin/env bash

echo "Build project..."
docker-compose -f docker-compose.yaml build

echo "Up project..."
docker-compose -f docker-compose.yaml up -d --force-recreate

echo "Waiting Elasticsearch..."
until curl -X GET http://localhost:9200  &> /dev/null
do
    echo "Waiting ..."
    sleep 2
done

echo "Start"
docker exec -it app bash

