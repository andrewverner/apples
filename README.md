`docker compose up --build -d`

Inside a PHP container

```
composer install
./yii migrate --migrationPath=@yii/rbac/migrations
./yii init/add-admin --username=<username> --password=<password> --email=<email>
```

Open http://localhost:8059