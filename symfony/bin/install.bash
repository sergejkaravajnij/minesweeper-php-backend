#!/bin/bash
##
## Run composer install
## Run database migrations
## Clear the cache
##
composer install --prefer-source --no-interaction \
&& php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration \
&& php bin/console cache:clear