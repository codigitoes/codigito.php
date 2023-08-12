#!/bin/bash
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )/"
cd $DIR"../"

sleep 1
echo ""
echo "API"
echo ""
docker exec -it `docker ps | grep codigito.mariadb | head -n1 | awk '{print $1;}'` mysql -u root -proot -h codigito.mariadb  -e "$(cat mariadb/all.sql)"
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  rm -fr  var/cache/* var/log/*.log
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  composer install --no-interaction
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console doctrine:database:drop --force
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console doctrine:database:create
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console doctrine:schema:update --force
docker exec -it `docker ps | grep codigito.api | head -n1 | awk '{print $1;}'`  php bin/console lexik:jwt:generate-keypair --overwrite --no-interaction
docker exec -it `docker ps | grep codigito.mariadb | head -n1 | awk '{print $1;}'` mysql -u root -proot -h codigito.mariadb  -e "$(cat mariadb/fixture.sql)"
sleep 1
echo ""
echo "ADMIN"
echo ""
docker exec -it `docker ps | grep codigito.admin | head -n1 | awk '{print $1;}'`  rm -fr  var/cache/* var/log/*.log
docker exec -it `docker ps | grep codigito.admin | head -n1 | awk '{print $1;}'`  composer install --no-interaction
sleep 1
echo ""
echo "WWW"
echo ""
docker exec -it `docker ps | grep codigito.www | head -n1 | awk '{print $1;}'`  rm -fr  var/cache/* var/log/*.log
docker exec -it `docker ps | grep codigito.www | head -n1 | awk '{print $1;}'`  composer install --no-interaction
echo ""
echo "END"
echo ""
sleep 1
