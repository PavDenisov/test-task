## Project set up

##Steps
1. [Install Docker](https://docs.docker.com/get-docker/).
2. [Install Docker Compose](https://docs.docker.com/compose/install/).
3. [Install git](https://git-scm.com/downloads).
4. Clone repository **"git clone https://github.com/PavDenisov/test-task.git"**.
5. Run **"docker-compose build"** command
6. Run **"docker-compose up -d"** command
7. Wait 5 minutes
8. Go to [localhost](http://localhost/).

## Commands
Update laravel blog articles: **"docker-compose exec fpm php artisan update:laravel:blog:data"**

Start Cron: **"./docker/scripts/CronStart.bash"**

Stop Cron: **"./docker/scripts/CronStop.bash"**

## Configs


Laravel blog parser config file: **"./config/laravel_blog_parser.php"**

Attempts for http requests config file: **"./config/attempts.php"**
