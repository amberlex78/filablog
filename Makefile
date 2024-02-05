# Get the prefix name of the container = dir name of the project
export PREFIX = $$(basename $$(realpath .))

export LARAVEL_EXEC    = docker exec -it ${PREFIX}-laravel.test-1
export LARAVEL_ARTISAN = ${LARAVEL_EXEC} php artisan

.DEFAULT_GOAL := pint

lint: pint stan
pint:
	@$(LARAVEL_EXEC) composer pint
stan:
	@$(LARAVEL_EXEC) composer phpstan

clean:
	@$(LARAVEL_ARTISAN) optimize:clear

DB_FRESH_SEED_COMMAND = $(LARAVEL_EXEC) rm -rf ./storage/app/public && $(LARAVEL_ARTISAN) migrate:fresh --seed
db-fresh-seed:
	@if [ "$(APP_ENV)" = "production" ]; then \
		read -p "Are you sure you want to execute db-fresh-seed in the current environment? (y/n) " answer; \
		[ "$$answer" = "y" ] && $(DB_FRESH_SEED_COMMAND); \
	else \
		$(DB_FRESH_SEED_COMMAND); \
	fi
