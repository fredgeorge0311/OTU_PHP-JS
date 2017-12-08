#!/usr/bin/env bash

docker exec -u __USERKEY__ __APP_ID__ /usr/local/bin/wait-for-it.sh --timeout=120 mysql:3306 -- echo "ready!"
docker exec -u __USERKEY__ __APP_ID__ ./psh.phar bamboo:init
I: docker exec -u __USERKEY__ __APP_ID__ ./psh.phar bamboo:mink