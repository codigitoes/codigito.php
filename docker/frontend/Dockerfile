FROM php:8.1-apache

ARG DEPLOY_ENV

WORKDIR /var/www/vhosts/codigito.es

RUN echo 'alias ls="ls --col"' >> /etc/bash.bashrc
RUN apt-get update && apt-get install -y \
    git \
    sshpass \
    iputils-ping \
    net-tools \
    ccze \
    nano \
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
    mariadb-client
RUN mkdir -p /usr/share/man/man1
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt update && apt install -y nodejs

COPY ssl.crt /etc/apache2/ssl/ssl.crt
COPY ssl.key /etc/apache2/ssl/ssl.key

# create user
RUN echo markitos
RUN groupadd -g 1000 markitos
RUN useradd markitos -u 1000 -g 1000 -m -s /bin/bash && echo "markitos:markitos" | chpasswd && adduser markitos sudo && chown -R markitos:markitos /var/www /home/markitos
RUN echo "markitos    ALL = (ALL) NOPASSWD: ALL" >> /etc/sudoers

# timezone
RUN rm -f /etc/localtime ; ln -s /usr/share/zoneinfo/Europe/Madrid /etc/localtime

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/vhosts/codigito.es
RUN chown markitos:markitos ../codigito.es
RUN echo 'alias maria="mysql -h mariadb -u xxx -xxx xxx"' >> /etc/bash.bashrc;
RUN echo 'export PATH=${PATH}:/var/www/vhosts/codigito.es/node_modules/.bin' >> /etc/bash.bashrc

CMD ["npm", "run", "dev"]
