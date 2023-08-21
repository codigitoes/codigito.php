#!/bin/bash
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )/"
cd $DIR"../"


echo ""
echo ""
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console doctrine:database:drop --force
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console doctrine:database:create
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console doctrine:schema:update --force
docker exec -it `docker ps | grep codigito.mariadb | head -n1 | awk '{print $1;}'` mysql -u codigito -pcodigito -h codigito.mariadb -e "$(cat mariadb/fixture.sql)"
echo ""
echo ""
