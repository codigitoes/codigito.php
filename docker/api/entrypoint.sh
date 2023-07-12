#!/bin/bash

# Start the run once job.
echo "markitos say: 'Docker container has been started from entrypoint.sh :)'"

echo ';==============  logging started ==============;'
tail -f /var/www/vhosts/codigito/var/log/* | ccze -A &
echo ';==============  logging terminated ==============;'

apachectl -D FOREGROUND