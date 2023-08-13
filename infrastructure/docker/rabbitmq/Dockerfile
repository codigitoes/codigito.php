FROM  rabbitmq:3-management

ARG DEPLOY_ENV

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
    supervisor \
    wget \
    tar \
    sudo \
    wget 

# create user
RUN echo markitos
RUN groupadd -g 1000 markitos
RUN useradd markitos -u 1000 -g 1000 -m -s /bin/bash && echo "markitos:markitos" | chpasswd && adduser markitos sudo
RUN echo "markitos    ALL = (ALL) NOPASSWD: ALL" >> /etc/sudoers

RUN mkdir -p /etc/rabbitmq/conf.d
RUN chown -R rabbitmq:rabbitmq /etc/rabbitmq/conf.d
COPY 20-logging.conf /etc/rabbitmq/conf.d
RUN echo 'alias ls="ls --col -las"' >> /etc/bash.bashrc