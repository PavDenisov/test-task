FROM php:8.0-fpm

RUN apt-get update && apt-get install -y wget git unzip \
    cron \
    supervisor

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY /docker/crontab /etc/crontabs/testcrontab
RUN chmod 0644 /etc/crontabs/*

RUN touch /var/log/cron.log

COPY /docker/supervisord.conf /etc/supervisor/

RUN crontab -u root /etc/crontabs/testcrontab

WORKDIR /var/www/test

RUN wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

RUN . ~/.bashrc && nvm install 10.14.0

COPY /docker/scripts/StartFPM.bash /var/www/test/docker/scripts/StartFPM.bash

CMD ["/var/www/test/docker/scripts/StartFPM.bash"]

EXPOSE 9000
