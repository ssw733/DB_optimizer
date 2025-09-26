# DB_optimizer
Test task of migration some fields to S3

Install:
$ docker compose up

Generate mock:
$ php artisan db:seed

Migration to S3:
$ php artisan emails:migrate-to-s3