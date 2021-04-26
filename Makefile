console := php bin/console
vendor := ./vendor/bin

.DEFAULT_GOAL := help
.PHONY: help
help: ## Show this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: format
format: vendor/autoload.php ## Format the code
	$(vendor)/php-cs-fixer fix src
	composer normalize

.PHONY: lint
lint: vendor/autoload.php ## Lint the code
	$(console) lint:yaml config --parse-tags
	$(console) doctrine:schema:validate --skip-sync -vvv --no-interaction
	$(console) lint:twig templates --env=prod
	$(vendor)/parallel-lint --exclude vendor .
	$(vendor)/phpstan analyse src --level 7

.PHONY: start
start: vendor/autoload.php ## Start the web server and the workers
	docker-compose up -d
	symfony serve -d
	symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async

.PHONY: stop
stop: vendor/autoload.php ## Stops the the web server and the workers
	docker-compose stop
	symfony server:stop
	symfony console messenger:stop-workers

.PHONY: setup
setup: vendor/autoload.php ## Sets up the entire environment
	composer install
	make start
	$(console) doctrine:migrations:migrate --no-interaction
	$(console) hautelook:fixtures:load --no-interaction
