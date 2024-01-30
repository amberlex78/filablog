# Get the prefix name of the container (dir name of the project)
export PREFIX=$$(basename $$(realpath .))
export LARAVEL_EXEC=docker exec -it ${PREFIX}-laravel.test-1

clean:
	@$(LARAVEL_EXEC) php artisan optimize:clear

lint:
	@$(LARAVEL_EXEC) composer pint
	@$(LARAVEL_EXEC) composer phpstan
