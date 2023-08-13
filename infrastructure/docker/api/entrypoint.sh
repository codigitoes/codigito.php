#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :) ${ENVIRONMENT}'"

echo "markitos say: 'starting supervisor'"
sudo /usr/sbin/service supervisor start
sudo chmod -R 777 /var/log/supervisor*
echo "markitos say: 'supervisor started'"

wait -n

tail -f /dev/null