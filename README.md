## Trading Point App

Used technologies:
- Laravel 11: As the base technology
- PostgreSQL: For the database
- Redis: For caching
- [Pusher](https://pusher.com/): For real-time notifications and updates

[Laradock](https://laradock.io/) is used for local development. It's not mandatory as other local setups can be used as well.

If you use Laradock, the required containers are 'workspace', 'php-fpm', 'php-worker', 'nginx', 'postgres', 'redis', 'docker-in-docker'.

The 'build.sh', 'up.sh', 'connect.sh', and 'stop.sh' are helper scripts meant to be updated locally to help you with day-to-day Docker commands.


## Limitations
The dashboard is hardcoded to work with exactly 10 stocks. This means that you can change the stocks that are configured in the ALPHA_VANTAGE_STOCKS_LIST environment variable, but you MUST ALWAYS have exactly 10 stocks.

This can be later updated to dynamically create the top cards and the graphs based on the number of stocks specified in the ALPHA_VANTAGE_STOCKS_LIST environment variable.


## How to run
In order to run the app, you need to meet the following requirements and follow the instructions below:
- Requirements:
  - You need a [Pusher](https://pusher.com/) account for real-time updates.
    - Once you have the account, create a channel and configure these env variables: PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_CLUSTER
  - You need an [Alpha Vantage API key](https://www.alphavantage.co/support/#api-key).
    - Just fill in the form, and you'll get a free key that is limited to 25 requests per day
- Instructions:
  - Copy .env.example and rename it to .env
  - Configure the database connection
  - Configure the Redis connection
  - Configure the Pusher connection
  - Configure the Alpha Vantage API connection
  - Configure [Laravel's scheduler](https://laravel.com/docs/11.x/scheduling#running-the-scheduler)
  - Run ``` php artisan migrate ``` to create the database
  - Run the queue worker ``` php artisan queue:work -v ```
    - Here is the [documentation](https://laravel.com/docs/11.x/queues#running-the-queue-worker)
  - Configure ``` trading.test ``` in your local ``` hosts ``` file
  - Open the app [dashboard](trading.test)


Once the application is configured, the scheduler will execute the tasks configured in [routes/console.php](routes/console.php) that will, in turn, dispatch jobs to be executed by the queue worker.

The scheduled tasks will dispatch a data pull job and a cache update job every minute for every stock option that is configured in the ALPHA_VANTAGE_STOCKS_LIST environment variable.

The cache update job will also broadcast an event that will update the data from the top 10 cards visible on the dashboard page.

The graphs' data is NOT updated automatically, and you need to refresh the page to view new data. This can be later added as the infrastructure is already in place.


## Closure
If something is not clear or you need help with running the app, please don't hesitate to write me at cosmin.bosutar@genuineq.com
