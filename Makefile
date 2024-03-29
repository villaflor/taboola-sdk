.PHONY: all fix lint test

all: lint test

fix:
	php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php

lint:
	php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --dry-run
	php vendor/bin/phpmd src/ text cleancode,codesize,controversial,design,naming,unusedcode
	php vendor/bin/phpmd tests/ text cleancode,codesize,controversial,design,naming,unusedcode

test:
	php vendor/bin/phpunit --configuration phpunit.xml