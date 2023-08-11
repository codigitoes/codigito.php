#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :) ${ENVIRONMENT}'"

echo "markitos say: 'starting supervisor'"
/usr/sbin/service supervisor start
echo "markitos say: 'supervisor started'"

echo "markitos say: 'starting httpd'"
/usr/sbin/apache2ctl -D FOREGROUND && /bin/bash
echo "markitos say: 'httpd started'"