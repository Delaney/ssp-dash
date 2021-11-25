## Getting Started

Clone the repo and navigate to the directory. Clone Laradock inside this:

```
git clone https://github.com/Laradock/laradock.git
```

Enter the Laradock folder and rename `.env-example` to `.env`
```
cd laradock
cp .env.example .env
```

Run the containers:
```
docker-compose up -d nginx mysql phpmyadmin redis workspace 
```

Navigate back to the project directory to edit the `.env` file and set the following:
```
DB_HOST=mysql
REDIS_HOST=redis
QUEUE_HOST=beanstalkd
```

To run migrations, get the `laradock_workspace` container's ID and ssh into it:
```
docker ps
docker exec -it <containerId> /bin/bash
php artisan migrate
```
