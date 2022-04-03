#!/usr/bin/env bash

echo "Build project..."
docker-compose -f docker-compose.yaml build

echo "Up project..."
docker-compose -f docker-compose.yaml up -d --force-recreate

echo "Start"
docker exec -it app bash

