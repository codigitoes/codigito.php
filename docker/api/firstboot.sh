#/bin/bash

git config --global user.email "codigo-com-es"
git config --global user.name "{.''.} ~ Codigo Com Es"
cd /tmp/ && /usr/local/bin/symfony new codigo.com.es  && cd codigo.com.es && chown -R 1000:1000 * && find ./ -name .git -type d | xargs rm -fr
rm -fr /var/www/vhosts/codigo.com.es/.* /var/www/vhosts/codigo.com.es/*
mv * .env .gitignore /var/www/vhosts/codigo.com.es/
cd /var/www/vhosts/codigo.com.es/
composer install
composer require symfony/orm-pack --no-interaction
composer require --dev phpunit --no-interaction
composer require --dev phpstan/phpstan  --no-interaction