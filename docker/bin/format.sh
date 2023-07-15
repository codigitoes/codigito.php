#!/bin/bash

SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )/"
cd $DIR"../"

docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'` vendor/bin/php-cs-fixer fix src
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'` vendor/bin/php-cs-fixer fix tests
docker exec -it `docker ps | grep codigito.admin | head -n1 | awk '{print $1;}'` vendor/bin/php-cs-fixer fix src
docker exec -it `docker ps | grep codigito.www | head -n1 | awk '{print $1;}'` vendor/bin/php-cs-fixer fix src