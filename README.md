## Knot Tech Test API

<hr />
<p>
Welcome to the Knot Tech Test API Doc. This serves as documentation for project setup and usage.
</p>

### Setup
To follow the steps outlined below you have to have a terminal window with the project root as your current directory

#### Environment Setup (Non-Docker)
Copy Example Environment File
```shell
cp .env.example .env
```
Create a Local Database and change the DB_* variables to point to your database.

Install Dependencies
```shell
composer install
```

Generate Application Key
```shell
php artisan key:generate
```

Migrate and seed database
```shell
php artisan migrate --seed
```

Run Application
```shell
php artisan serve
```
The application is now accessible at the [http://localhost:8000](http://localhost:8000) and the docs at 
[http://localhost:8000/api/docs](http://localhost:8000/api/docs)
