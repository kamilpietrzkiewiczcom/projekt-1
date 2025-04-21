FROM php:8.2-fpm AS first_step

EXPOSE 9000

#RUN apt-get update

#RUN apt-get install git -y

# Install Amqp from Pecl

#RUN apt-get install -y librabbitmq-dev
#RUN pecl install amqp

FROM first_step AS second_step

# Install ping

RUN apt-get update && apt-get install iputils-ping -y

# Install MySQL

RUN apt-get update \
     && docker-php-ext-install mysqli pdo pdo_mysql \
     && docker-php-ext-enable pdo_mysql

CMD ["php-fpm"]
