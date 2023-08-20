#!/bin/bash

docker exec -it `docker ps | grep codigito.www | head -n1 | awk '{print $1;}'` bash
