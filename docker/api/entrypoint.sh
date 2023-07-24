#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :) ${ENVIRONMENT}'"

echo "markitos say: 'starting supervisor'"
sshpass -p markitos sudo /usr/sbin/service supervisor start
echo "markitos say: 'supervisor started'"

echo "markitos say: 'starting promtail'"
/usr/local/bin/promtail -config.file /etc/promtail-local-config.yaml & 
echo "markitos say: 'promtail started'"

rm /var/run/apache2.pid 2> /dev/null
apachectl -D FOREGROUND