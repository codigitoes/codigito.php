#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :)'"

echo "markitos say: 'starting httpd'"
/usr/sbin/apache2ctl -D BACKGROUND
echo "markitos say: 'httpd started'"
tail -f /dev/null &