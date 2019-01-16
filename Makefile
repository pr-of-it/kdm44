up:
	docker-compose -p kdm44 -f ./build/dev/docker-compose.yml up -d
	docker-compose -p kdm44 exec php usermod -u $(id -u ${USER}) www-data
	docker-compose -p kdm44 exec php groupmod -g $(id -u ${USER}) www-data
	docker-compose -p kdm44 -f ./build/dev/docker-compose.yml restart

build:
	docker-compose -p kdm44 exec --user www-data php phing -f build/dev/build.xml

up-proxy:
	echo "Not work"

phing-build:
	docker-compose -p kdm44 exec --user www-data php-fpm phing -f build/dev/build.xml

restart:
	docker-compose -p kdm44 -f ./build/dev/docker-compose.yml restart

down:
	docker-compose -p kdm44 -f ./build/dev/docker-compose.yml down

down-all:
	docker-compose -p kdm44 -f ./build/dev/docker-compose.yml down -v

