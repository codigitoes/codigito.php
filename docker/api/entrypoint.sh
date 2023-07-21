#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :) ${ENVIRONMENT}'"

echo "markitos say: 'starting supervisor'"
sshpass -p markitos sudo /usr/sbin/service supervisor start
echo "markitos say: 'supervisor started'"

echo "markitos say: 'starting apache'"
apachectl -D FOREGROUND