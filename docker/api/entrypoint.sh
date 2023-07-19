#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :)'"
echo "markitos say: 'starting supervisor'"
sshpass -p markitos sudo /usr/sbin/service supervisor start
echo "markitos say: 'supervisor started'"

apachectl -D FOREGROUND