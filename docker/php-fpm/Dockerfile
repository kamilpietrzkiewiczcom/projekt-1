FROM php:8.2-fpm

EXPOSE 9000

RUN apt-get update

RUN apt-get install git -y

# Install MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Install Amqp from Pecl

RUN apt-get install -y librabbitmq-dev
RUN pecl install amqp

CMD ["php-fpm"]
