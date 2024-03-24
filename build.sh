#!/bin/bash
set -e

cd ~/workspace/laradock

docker-compose build --no-cache workspace php-fpm php-worker nginx postgres redis docker-in-docker

cd ~/workspace/trading-point-app
