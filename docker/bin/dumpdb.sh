#!/bin/bash

declare -a querys=(
    "select * from credentials\G;"
    "select * from tags\G;"
    "select * from blogposts\G;"
    "select * from blogcontents\G;"
    "select * from mailings\G;"
    "select * from fortunes\G;"
    )

declare -a all=''
for query in "${querys[@]}"
do
   all="${all}$query"
done

echo ""
echo ""
docker exec -it `docker ps | grep codigo-com-es.maria | head -n1 | awk '{print $1;}'` mysql -u codigoce  -pcodigoce codigoce -e "$all"
echo ""
echo ""
