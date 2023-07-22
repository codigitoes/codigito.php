FROM php:8.1-apache

ARG DEPLOY_ENV

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
RUN echo markitos
RUN groupadd -g 1000 markitos
RUN useradd markitos -u 1000 -g 1000 -m -s /bin/bash && echo "markitos:markitos" | chpasswd && adduser markitos sudo && chown -R markitos:markitos /var/www
RUN echo "markitos    ALL=(ALL:ALL) ALL" >> /etc/sudoers


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

# promtail for loki
RUN wget https://github.com/grafana/loki/releases/download/v2.8.3/promtail-linux-amd64.zip && unzip promtail-linux-amd64.zip && mv promtail-linux-amd64 /usr/local/bin/promtail
RUN apt-get update
RUN apt-get install -y wget unzip
RUN apt-get install -y libc6-amd64-cross
RUN ln -s /usr/x86_64-linux-gnu/lib64/ /lib64
ENV LD_LIBRARY_PATH="$LD_LIBRARY_PATH:/lib64:/usr/x86_64-linux-gnu/lib"
COPY promtail-local-config.yaml /etc/promtail-local-config.yaml
RUN mkdir -p /data/loki && chown -R 1000:1000 /data && chmod -R 777 /data


# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY entrypoint.sh /tmp
RUN chmod 777 /tmp/*
WORKDIR /var/www/vhosts/codigito.es
RUN echo 'alias maria="mysql -h codigito.mariadb -u codigito -pcodigito codigito"' >> /etc/bash.bashrc;
RUN echo 'export PATH=${PATH}:/var/www/vhosts/codigito.es/vendor/bin' >> /etc/bash.bashrc;

ENTRYPOINT ["/tmp/entrypoint.sh"]