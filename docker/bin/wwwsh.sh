#!/bin/bash

docker exec -it `docker ps | grep codigo-com-es.www | head -n1 | awk '{print $1;}'` bash
