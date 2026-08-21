DOCKER_COMPOSE ?= docker compose

up:
	@$(DOCKER_COMPOSE) up -d

up-lts:
	@COMPOSE_PROJECT_NAME=shopware-lts $(DOCKER_COMPOSE) -f compose.yml -f compose.lts.yml -f compose.override.yml up -d

down:
	@$(DOCKER_COMPOSE) down

down-lts:
	@COMPOSE_PROJECT_NAME=shopware-lts $(DOCKER_COMPOSE) -f compose.yml -f compose.lts.yml -f compose.override.yml down
