FROM wordpress:php8.0-apache

COPY ./docker/error-reporting.ini /usr/local/etc/php/conf.d/error-reporting.ini

COPY ./docker/wait-for-mysql ./docker/wait-for-mysql.php /usr/local/bin/

RUN curl --silent --output /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod a+x \
    /usr/local/bin/wp \
    /usr/local/bin/wait-for-mysql \
    /usr/local/bin/wait-for-mysql.php && \
  wp --allow-root --version


