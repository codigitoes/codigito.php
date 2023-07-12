#!/bin/bash

declare -a deletes=(
    "delete from credentials;"
    "delete from tags;"
    "delete from blogposts;"
    "delete from blogcontents;"
    "delete from mailings;"
    "delete from fortunes;"
    )
declare -a allDeletes=''
for query in "${deletes[@]}"
do
   allDeletes="${allDeletes}$query"
done
declare -a querys=(
    "select count(id) as total_credentials from credentials order by created desc;"
    "select count(id) as total_tags from tags order by created desc;"
    "select count(id) as total_blogposts from blogposts order by created desc;"
    "select count(id) as total_blogcontents from blogcontents order by created desc;"
    "select count(id) as total_mailings from mailings order by created desc;"
    "select count(id) as total_fortunes from fortunes order by created desc;"
    )
declare -a allQuerys=''
for query in "${querys[@]}"
do
   allQuerys="${allQuerys}$query"
done



docker exec -it `docker ps | grep codigo-com-es.maria | head -n1 | awk '{print $1;}'` mysql -u codigoce -pcodigoce codigoce -e "$allDeletes"
docker exec -it `docker ps | grep codigo-com-es.maria | head -n1 | awk '{print $1;}'` mysql -u codigoce -pcodigoce codigoce -e "$allQuerys"