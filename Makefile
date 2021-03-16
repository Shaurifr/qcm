OS := $(shell uname)

.DEFAULT_GOAL := help
help:
		@grep -E '(^[1-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

reset-db: ## sync force the database with the schema
	php bin/console doctrine:database:drop --force --if-exists
	php bin/console doctrine:database:create
	php bin/console doctrine:migration:migrate -n
	php bin/console doctrine:schema:validate
	php bin/console doctrine:fixtures:load -n -e dev

db: ## migrate the database with the schema
	docker-compose exec php bin/console doctrine:migration:migrate

inspect: ## inspect the code with phpstan
	php vendor/bin/phpstan analyse -l 5 -c phpstan.neon src
	php -d memory_limit=-1 vendor/bin/php-cs-fixer fix --rules=@Symfony --dry-run

quality: ## comme inspect, mais joue le php cs fixer pour de vrai.
	php bin/console doctrine:schema:validate
	php -d memory_limit=-1 vendor/bin/php-cs-fixer fix --rules=@Symfony
	php -d memory_limit=-1 vendor/bin/phpstan analyse -l 5 -c phpstan.neon src

test: reset-db phpunit behat ## reset la db et lance les tests unitaires et behat

update-translation-fr: ## updates the file with the missing translations
	php bin/console translation:update --dump-messages --force fr

phpunit: ## lance les tests unitaires
	php bin/phpunit

behat: ## lance les tests behat
	php vendor/bin/behat
