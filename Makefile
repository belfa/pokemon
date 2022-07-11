current-dir := $(dir $(lastword $(MAKEFILE_LIST)))
SHELL = /bin/sh

.PHONY: help
help: Makefile
	@sed -n 's/^##//p' $<

.PHONY: build
## build			Construye la aplicación
build:
	docker-compose down
	docker-compose up -d
	docker exec test-performance-php composer install
	docker exec test-performance-php composer config extra.symfony.allow-contrib true

#🐘 Create environment local file
create_env_file:
	@if [ ! -f .env.local ]; then cp .env .env.local; fi

test: create_env_file
## test			Lanza los todos los test
	docker exec test-performance-php ./vendor/bin/phpunit --testsuite Unit
	docker exec test-performance-php ./vendor/bin/phpunit --testsuite Integration
	docker exec test-performance-php ./vendor/bin/phpunit --testsuite Acceptation
	docker exec test-performance-php ./vendor/bin/phpunit --testsuite Functional

unit:
## unit			Lanza los test unitarios
	docker exec test-performance-php ./vendor/bin/phpunit --testsuite Unit

# 🐳 Docker Compose
start: CMD=up -d
stop: CMD=stop
destroy: CMD=down

doco start stop destroy: create_env_file
	@docker-compose $(CMD)

.PHONY: build
dev:
	create_env_file
	docker-compose up -d

## clean			Limpia la cache de Symfony
clean:
	@rm -rf ./var/
	@docker exec test-performance-php ./bin/console cache:warmup

## bash			Entra en la consola
bash:
	@docker exec -it test-performance-php bash

## stop-containers	Para todos los contenedores corriendo actualmente en el sistema
stop-containers:
	@for container in $$(docker ps -q);do docker kill $$container; done

## composer		Lanza composer para instalar las dependencias de php
composer:
	docker-compose up --no-deps -d php
	docker-compose exec php composer install

