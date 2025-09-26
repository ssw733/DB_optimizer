## Database to S3 migrator

Установка:
$ docker compose up

Генерация синтетических данных:
$ php artisan db:seed

Миграция в S3:
$ php artisan emails:migrate-to-s3