FROM grafana/grafana:8.4.2-ubuntu

ARG DEPLOY_ENV
USER 0

RUN echo 'alias ls="ls --col"' >> /etc/bash.bashrc
RUN apt-get update && apt-get install -y \
    sudo \
    locate \
    sshpass \
    iputils-ping \
    net-tools \
    ccze \
    nano

# create user
RUN groupadd -g 1000 markitos
RUN useradd markitos -u 1000 -g 1000 -m -s /bin/bash && echo "markitos:markitos" | chpasswd && adduser markitos sudo
RUN echo "markitos    ALL=(ALL:ALL) ALL" >> /etc/sudoers

# timezone
RUN rm -f /etc/localtime ; ln -s /usr/share/zoneinfo/Europe/Madrid /etc/localtime

COPY grafana.ini /etc/grafana/

USER markitos

WORKDIR /etc/grafana