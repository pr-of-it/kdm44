SHELL  := /bin/bash
USERID := ${shell id -u}
STAGE := $(shell echo $$STAGE)

ifeq ($(STAGE),)
STAGE = dev
PROJECT = -p kdm44
else
STAGE := $(shell echo $$STAGE)
PROJECT = -p kdm44
endif

OPT =


HOSTIP := ${shell /sbin/ifconfig | grep -E '([0-9]{1,3}\.){3}[0-9]{1,3}' | grep -v 127.0.0.1 | awk '{ print $$2 }' | cut -f2 -d: | head -n1}
RUN = export DOCKERHOST=${HOSTIP} && docker-compose ${PROJECT} -f ./build/${STAGE}/docker-compose.yml --project-directory ${PWD}


up:
	${RUN} up -d
	${RUN} exec php-fpm usermod -u ${USERID} www-data
	${RUN} exec php-fpm groupmod -g ${USERID} www-data

build-all:
	${RUN} exec php-fpm usermod -u ${USERID} www-data
	${RUN} exec php-fpm groupmod -g ${USERID} www-data
	${RUN} exec --user www-data php-fpm phing -f build/dev/build.xml

up-proxy:
	echo "Not work"

db:
	${RUN} exec --user www-data php-fpm phing -f build/dev/db.xml

phing-build:
	${RUN} exec --user www-data php-fpm phing -f build/dev/build.xml

restart:
	${RUN} restart

down:
	${RUN} down

down-all:
	${RUN} down -v
