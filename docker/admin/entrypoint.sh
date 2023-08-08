#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :)'"

echo "markitos say: 'starting promtail'"
/usr/local/bin/promtail -config.file /etc/promtail-local-config.yaml & 
echo "markitos say: 'promtail started'"

echo "markitos say: 'starting httpd'"
killall -9 apache2ctl
/usr/sbin/apache2ctl -D FOREGROUND
echo "markitos say: 'httpd started'"