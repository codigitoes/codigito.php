FROM php:8.1-apache

RUN echo 'alias ls="ls --col"' >> /etc/bash.bashrc
RUN apt-get update && apt-get install -y \
    git \
    sshpass \
    iputils-ping \
    net-tools \
    ccze \
    nano \
    npm \
    unzip \
    gnupg \
    tar \
    sudo \
    wget \
    libaio1 \
    libpq-dev \
    libwebp-dev \
    libfreetype6 \
    libfreetype6-dev \
    g++ \
    cron \
    libonig-dev \
    build-essential \
    mariadb-client \
    && docker-php-ext-install \
    mbstring  \
    pdo_mysql
RUN mkdir -p /usr/share/man/man1
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

COPY php.ini /usr/local/etc/php/php.ini
RUN rm -f /tmp/.htaccess
COPY .htaccess /tmp/

COPY ssl.crt /etc/apache2/ssl/ssl.crt
COPY ssl.key /etc/apache2/ssl/ssl.key

# Install composer (NO SE USA REALMENTE YA QUE VENDOR LO INSTALAMOS DE OTRA FORMA)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# create user
RUN groupadd -g 1000 markitos
RUN useradd markitos -u 1000 -g 1000 -m -s /bin/bash

# Install symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony
RUN mkdir /.symfony5 && chown 1000:1000 /.symfony5 && chmod 777 /.symfony5

# Set apache configuration
COPY default.conf /etc/apache2/sites-available/default.conf
RUN ln -s /etc/apache2/sites-available/default.conf /etc/apache2/sites-enabled/
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2dissite 000-default

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY entrypoint.sh /tmp
COPY firstboot.sh /tmp
RUN chmod 777 /tmp/*
WORKDIR /var/www/vhosts/codigito
RUN echo 'alias maria="mysql -h mariadb -u codigito -pcodigito codigito"' >> /etc/bash.bashrc;

#: la primera vez, o bash /tmp/firstboot.sh
#git config --global user.email "codigito.es@gmail.com"
#git config --global user.name "{.''.} ~ Marco Antonio ~ mArKit0s"
#cd /tmp/ && /usr/local/bin/symfony new codigito  && cd codigito && chown -R 1000:1000 * && find ./ -name .git -type d | xargs rm -fr
#rm -fr /var/www/vhosts/codigito/.* /var/www/vhosts/codigito/*
#mv * .env .gitignore /var/www/vhosts/codigito/
#cd /var/www/vhosts/codigito/
#composer install
#composer require symfony/orm-pack
#composer require --dev phpunit

ENTRYPOINT ["/tmp/entrypoint.sh"]
#CMD ["apachectl", "-D", "FOREGROUND"]
