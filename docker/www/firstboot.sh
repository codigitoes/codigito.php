#/bin/bash

git config --global user.email "codigito"
git config --global user.name "{.''.} ~ Codigo Com Es"
cd /tmp/ && /usr/local/bin/symfony new codigito  --webapp  && cd codigito && chown -R 1000:1000 * && find ./ -name .git -type d | xargs rm -fr
rm -fr /var/www/vhosts/codigito.es/.* /var/www/vhosts/codigito.es/*
mv * .env .gitignore /var/www/vhosts/codigito.es/
cd /var/www/vhosts/codigito.es/
composer install