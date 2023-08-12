#!/bin/bash

docker exec -it `docker ps | grep codigito.rabbitmq | head -n1 | awk '{print $1;}'` bash
