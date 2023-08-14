FROM php:8.1-apache

ARG DEPLOY_ENV

WORKDIR /var/www/vhosts/codigito.es


RUN echo 'alias ls="ls --col"' >> /etc/bash.bashrc
RUN apt-get update && apt-get install -y \
    git \
    grc \
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
RUN echo markitos
RUN groupadd -g 1000 markitos
RUN useradd markitos -u 1000 -g 1000 -m -s /bin/bash && echo "markitos:markitos" | chpasswd && adduser markitos sudo && chown -R markitos:markitos /var/www /home/markitos
RUN echo "markitos    ALL = (ALL) NOPASSWD: ALL" >> /etc/sudoers

# timezone
RUN rm -f /etc/localtime ; ln -s /usr/share/zoneinfo/Europe/Madrid /etc/localtime

# Install symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony
RUN mkdir /.symfony5 && chown 1000:1000 /.symfony5 && chmod 777 /.symfony5

# Set apache configuration
COPY default.conf /etc/apache2/sites-available/default.conf
COPY default.production.conf /etc/apache2/sites-available/default.production.conf
RUN if [ "$DEPLOY_ENV" = "prod" ]; then ln -s /etc/apache2/sites-available/default.production.conf /etc/apache2/sites-enabled/default.conf ; fi
RUN if [ "$DEPLOY_ENV" = "prod" ]; then rm /etc/apache2/sites-available/default.conf ;  fi
RUN if [ "$DEPLOY_ENV" = "dev" ]; then ln -s /etc/apache2/sites-available/default.conf /etc/apache2/sites-enabled/default.conf ; fi
RUN if [ "$DEPLOY_ENV" = "dev" ]; then rm /etc/apache2/sites-available/default.production.conf ;  fi
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2dissite 000-default

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY entrypoint.sh /tmp
RUN chmod 777 /tmp/*
RUN echo 'alias maria="mysql -h codigito.mariadb -u codigito -pcodigito codigito"' >> /etc/bash.bashrc;
RUN echo 'export PATH=${PATH}:/var/www/vhosts/codigito.es/vendor/bin' >> /etc/bash.bashrc;
RUN echo 'alias slog="grc tail -f /var/log/supervisor/*"' >> /etc/bash.bashrc
RUN echo 'alias clog="grc tail -f /var/www/vhosts/codigito.es/var/log/*"' >> /etc/bash.bashrc
RUN echo 'alias alog="grc tail -f /var/www/vhosts/codigito.es/var/log/*   /var/log/supervisor/*"' >> /etc/bash.bashrc
RUN echo 'export PATH=${PATH}:/var/www/vhosts/codigito.es/vendor/bin' >> /etc/bash.bashrc

RUN chown 1000:1000 -R /var/log/apache2
USER root
CMD sudo /usr/sbin/apache2ctl -D FOREGROUND
# CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]