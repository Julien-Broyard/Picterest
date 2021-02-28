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
	$(console) lint:container
	$(console) lint:twig templates --env=prod
	$(vendor)/parallel-lint --exclude vendor .
	$(vendor)/phpstan analyse src tests --level 7

.PHONY: seed
seed: vendor/autoload.php ## Seed the database
	$(console) doctrine:migrations:migrate -n