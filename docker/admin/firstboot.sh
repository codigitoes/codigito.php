#/bin/bash

git config --global user.email "codigito"
git config --global user.name "{.''.} ~ Codigo Com Es"
cd /tmp/ && /usr/local/bin/symfony new codigito  --webapp  && cd codigito && chown -R 1000:1000 * && find ./ -name .git -type d | xargs rm -fr
rm -fr /var/www/vhosts/codigito/.* /var/www/vhosts/codigito/*
mv * .env .gitignore /var/www/vhosts/codigito/
cd /var/www/vhosts/codigito/
composer install