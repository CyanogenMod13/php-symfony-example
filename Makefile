docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm php-cli composer install

composer-update:
	docker-compose run --rm php-cli composer update