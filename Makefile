command = @docker run $(3) -t --rm --entrypoint $(1) -v `pwd`:/app paddle-php-sdk $(2)

COMPOSER_STABILITY?=stable

.PHONY: build
build:
	@docker build -t paddle-php-sdk .

.PHONY: install
install:
	$(call command, /usr/local/bin/composer, update --prefer-${COMPOSER_STABILITY})

.PHONY: test
test:
	$(call command, /app/vendor/bin/phpunit, --no-coverage)

.PHONY: stan
stan:
	$(call command, /app/vendor/bin/phpstan, analyse src)

.PHONY: rector
rector:
	$(call command, /app/vendor/bin/rector, process src)

.PHONY: format
format:
	$(call command, /app/vendor/bin/php-cs-fixer, fix)

.PHONY: lint
lint:
	$(call command, /app/vendor/bin/php-cs-fixer, fix --dry-run)
