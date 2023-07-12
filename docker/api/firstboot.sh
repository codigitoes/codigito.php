#/bin/bash

git config --global user.email "codigito.es@gmail.com"
git config --global user.name "{.''.} ~ Marco Antonio ~ mArKit0s"
cd /tmp/ && /usr/local/bin/symfony new codigito  && cd codigito && chown -R 1000:1000 * && find ./ -name .git -type d | xargs rm -fr
rm -fr /var/www/vhosts/codigito/.* /var/www/vhosts/codigito/*
mv * .env .gitignore /var/www/vhosts/codigito/
cd /var/www/vhosts/codigito/
composer install
composer require symfony/orm-pack --no-interaction
composer require --dev phpunit --no-interaction