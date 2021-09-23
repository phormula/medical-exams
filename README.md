
```
# Run the webserver on port 8000
php artisan serve
```

## About

This project returns search results medical exams performed at various medical facilities in various locations. The geographical location data is populated with cities and regions in Italy.

This project is done with PHP/ [Laravel 8.x](https://laravel.com/).

## Installation

- Install [PHP 7.3+ or above](https://www.php.net) as required by Laravel 8.x.

- Install [composer](https://getcomposer.org/download/).

- Clone this repository
```sh
    $ git clone https://github.com/phormula/medical-exams.git
```
- This project uses by default SQlite database (add [SQlite driver](https://www.php.net/manual/en/sqlite3.installation.php) for your version of PHP)

- Create the SQlite database file under ``` ./medical-exams/database/ ``` directory and name it ``` database.sqlite ```
- Update the ``` .env ``` file with the absolute path of the database file ``` (DB_DATABASE=/home/{path/to/project}/medical-exams/database/database.sqlite) ```

- Perform migrations
```sh
    $ php artisan migrate
```

- Seed geolocation data (regions, states, cities, postal codes)
```sh
    $ php artisan geolocate:seed
```

- Seed demo data (users, structures, exams)
```sh
    $ php artisan db:seed --class=DatabaseSeeder
```
generated users are of the form 
```
**email**: structure1@gmail.com, structure2@gmail.com, structure3@gmail.com, ...
**password**: password
```

### Additional Library and installation

This project makes use of Bootstrap with Laravel mix and therefore you need ```nodejs``` and ```npm```

- Install [nodejs 14.x](https://nodejs.org/en/download/)

- Make sure you are the project's directory and run the following commands
```sh
     npm install
     npm run dev
```

Finally start the development server
```sh
     php artisan serve
```

### Added Packages

 - REST API using auth tokens with Laravel Sanctum


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
