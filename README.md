## Last FM

A Laravel application that allows users to search and view information about music artists and their albums.



### Features

-   User authentication with laravel [Jetstream](https://jetstream.laravel.com) and [socialstream](https://docs.socialstream.dev/) to support Google OAuth.
-   Artist search
-   Album search
-   Favourite artists and albums


### Setup 

Make sure docker engine is running on your machine.

Clone the git repository using the command below.

```
git clone git@github.com:williamjingo/lastfm.git
```

The next steps assume that you running this project using docker, However you can still run this projecting without using docker following the [laravel docs](https://laravel.com/docs/9.x/installation)

Make sures docker engine is running on your machine.

Navigate to the newly created folder `lastfm` and install project dependencies by executing the command below.

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Create the .env file using the command below
```
cp .env.example .env
```
Update ```.env``` with Google credentials ```GOOGLE_CLIENT_ID``` and ```GOOGLE_CLIENT_SECRET```. The credentials can be gotten from the [Google Developers Console](https://console.cloud.google.com/) 

Update ```.env``` with the Last.fm API key ```LAST_FM_API_KEY``` from [last.fm](https://www.last.fm/api)

Run project using

```
./vendor/bin/sail up -d
```

Configure a shell alias that allows you to execute Sail's commands more easily

```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Generate application key using
```
sail artisan key:generate
```

Run database migrations using
```
sail artisan migrate
```


Run the command below to stop the application docker containers

```
sail down
```

### Author

<a href="https://www.linkedin.com/in/william-jingo/" target="_blank">George Jingo</a>
