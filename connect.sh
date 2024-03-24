#!/bin/bash
set -e

cd ~/workspace/laradock

docker-compose exec workspace /bin/bash -c "cd /var/www/trading-point-app; exec /bin/bash"

cd ~/workspace/trading-point-app
