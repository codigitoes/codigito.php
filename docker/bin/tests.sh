#!/bin/bash

docker exec -it `docker ps | grep codigo-com-es.api | head -n1 | awk '{print $1;}'` php bin/phpunit
