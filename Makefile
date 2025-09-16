# Variables
PHP=php
ARTISAN=$(PHP) artisan
NPM=npm

# Targets
install:
	$(NPM) install
	composer install
	$(ARTISAN) key:generate
	$(ARTISAN) migrate:fresh --seed

serve:
	composer run dev

migrate:
	$(ARTISAN) migrate

key:
	$(ARTISAN) key:generate

fresh:
	$(ARTISAN) migrate:fresh --seed

seed:
	$(ARTISAN) db:seed

queue:
	$(ARTISAN) queue:work

test-backend:
	$(PHP) vendor/bin/pest

test-frontend:
	$(NPM) run test

test-e2e:
	$(NPM) run test:e2e

lint:
	$(NPM) run lint

build:
	$(NPM) run build

dev:
	$(NPM) run dev

# Cache management
clear-cache:
	$(ARTISAN) cache:clear
	$(ARTISAN) config:clear
	$(ARTISAN) route:clear
	$(ARTISAN) view:clear

clear-all:
	$(ARTISAN) optimize:clear
	$(ARTISAN) cache:clear
	$(ARTISAN) config:clear
	$(ARTISAN) route:clear
	$(ARTISAN) view:clear
	$(ARTISAN) event:clear
	$(ARTISAN) queue:clear

optimize:
	$(ARTISAN) optimize

