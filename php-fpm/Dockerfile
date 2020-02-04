FROM phpdockerio/php72-fpm

RUN apt-get update
RUN apt-get install php7.2-bcmath php7.2-mysql php-redis php-xdebug php-yaml -y
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

