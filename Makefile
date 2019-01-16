SHELL  := /bin/bash
USERID := ${shell id -u}
RUN = docker-compose -p kdm44 -f ./build/dev/docker-compose.yml --project-directory ${PWD}
up:
	${RUN} up -d
	${RUN} exec php usermod -u ${USERID} www-data
	${RUN} exec php groupmod -g ${USERID} www-data

build-all:
	${RUN} exec php usermod -u ${USERID} www-data
	${RUN} exec php groupmod -g ${USERID} www-data
	${RUN} exec --user go php phing -f build/dev/build.xml

up-proxy:
	echo "Not work"

db:
	${RUN} exec --user www-data -f ./build/dev/docker-compose.yml php phing -f build/dev/db.xml

phing-build:
	${RUN} exec --user www-data -f ./build/dev/docker-compose.yml php phing -f build/dev/build.xml

restart:
	${RUN} restart

down:
	${RUN} down

down-all:
	${RUN} down -v
