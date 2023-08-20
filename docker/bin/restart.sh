#!/bin/bash

SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )/"
cd $DIR"../"

if [ $# -eq 1 ]
  then
    echo ""
    echo "{.''.}"
    echo "{.''.} No arguments supplied: ${SOURCE} dev|prod container.name"
    echo "{.''.}"
    echo "{.''.} example: $ bash ${SOURCE} dev codigito.api"
    echo "{.''.}"
    echo ""
    exit
fi

if `[[ -z "$1" || -z "$2" ]]`; then
    echo ""
    echo "{.''.}"
    echo "{.''.} DEPLOY_ENV and SERVICE must contain value"
    echo "{.''.}"
    echo ""
    exit
fi

echo ""
echo "{.''.}"
echo "{.''.} DEPLOY_ENV: $1"
echo "{.''.} SERVICE...: $2"
echo "{.''.}"


DEPLOY_ENV=$1 docker-compose up --no-deps -d --build --remove-orphans $2