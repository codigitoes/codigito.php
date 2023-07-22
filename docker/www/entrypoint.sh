#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :)'"

echo "markitos say: 'starting promtail'"
/usr/local/bin/promtail -config.file /etc/promtail-local-config.yaml & 
echo "markitos say: 'promtail started'"

apachectl -D FOREGROUND