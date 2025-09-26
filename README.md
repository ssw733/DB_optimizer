# DB_optimizer
Test task of migration some fields to S3

Install:
```bash
composer i
```

Generate mock:
```bash
php artisan db:seed
```

Migration to S3:
```bash
php artisan emails:migrate-to-s3
```
