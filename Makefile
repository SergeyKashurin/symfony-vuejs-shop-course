NODE_MODULES = ./node_modules
VENDOR = ./vendor

##
## UTILS
## ----------
psql-connect:
	psql -h 127.0.0.1 -d ranked_choice -U rc_admin -W

watch:
	yarn dev watch

##
## REFACTORING
## -----------

check:
	make refactoring --keep-going

refactoring: eslint php-cs-fixer

eslint:
	${NODE_MODULES}/.bin/eslint assets/js/ --ext .js,.vue --fix

php-cs-fixer:
	${VENDOR}/bin/php-cs-fixer fix src --verbose

phpstan:
	${VENDOR}/bin/phpstan analyse src --level 8

##
## TESTING
## -----------

run-test:
	sh ./bin/run-tests.sh