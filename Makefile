install:
	composer install

lint:
	composer exec --verbose phpcs -- src tests
	composer exec --verbose phpstan analyse src tests

lint-fix:
	composer exec --verbose phpcbf -- src tests

test:
	composer exec --verbose phpunit tests