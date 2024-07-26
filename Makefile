##################
# Variables
##################

DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env
DOCKER_COMPOSE_PLUGIN = docker compose -f ./docker/docker-compose.yml --env-file ./docker/.env

DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

##################
# Docker compose
##################

dc_build:
	${DOCKER_COMPOSE} build

dc_start:
	${DOCKER_COMPOSE} start

dc_stop:
	${DOCKER_COMPOSE} stop

dc_up:
	${DOCKER_COMPOSE} up -d --remove-orphans

dc_ps:
	${DOCKER_COMPOSE} ps

dc_logs:
	${DOCKER_COMPOSE} logs -f

dc_down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans


build:
	${DOCKER_COMPOSE_PLUGIN} build

start:
	${DOCKER_COMPOSE_PLUGIN} start

stop:
	${DOCKER_COMPOSE_PLUGIN} stop

up:
	${DOCKER_COMPOSE_PLUGIN} up -d --remove-orphans

ps:
	${DOCKER_COMPOSE_PLUGIN} ps

logs:
	${DOCKER_COMPOSE_PLUGIN} logs -f

down:
	${DOCKER_COMPOSE_PLUGIN} down -v --rmi=all --remove-orphans



##################
# App
##################

dc_app_bash:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash

app_bash:
	${DOCKER_COMPOSE_PLUGIN} exec -u www-data php-fpm bash
