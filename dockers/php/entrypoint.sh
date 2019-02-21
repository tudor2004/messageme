#!/bin/sh
set -e

XDEBUG_INI=/usr/local/etc/php/conf.d/xdebug.ini
if [[ "${XDEBUG_ENABLE}" != "1" ]]; then
    echo "Disabling XDebug Configuration"
    rm -f ${XDEBUG_INI}
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
	mkdir -p var/cache var/log
	chown -R www-data var

    if [ "$APP_ENV" == 'dev' ]; then
		bin/setup
	fi

	php bin/console doctrine:migrations:migrate
fi

exec docker-php-entrypoint "$@"