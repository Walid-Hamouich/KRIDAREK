init: docker-start
	cd "./Apps" && docker compose exec backoffice composer install
	cd "./Apps" && docker compose exec api composer install

.IPHONY: docker-start
docker-start: ## Starts the containers
	@cd "./Apps" && docker compose up -d

.IPHONY: docker-build
docker-build:
	@cd ./Apps && docker compose up -d --build

.IPHONY: docker-stop
docker-stop:
	@cd Apps && docker compose stop

.IPHONY: docker-down
docker-down:
	@cd Apps && docker compose down
.IPHONY: docker-restart
docker-restart:
	@cd Apps && docker compose restart

.IPHONY: docker-bash
docker-bash:
	@cd Apps && docker compose exec $(service) bash

.IPHONY: docker-shell
docker-shell:
	@cd Apps && docker compose exec $(service) sh

prepare-husky:
	@copy config-tools\husky\commitlint.config.js .
	@copy config-tools\husky\package-lock.json .
	@copy config-tools\husky\package.json .
	npm install
	npm run prepare
	del package-lock.json
	del package.json
	del commitlint.config.js
	rmdir /Q /S node_modules
	cd config-tools\husky && npm install

