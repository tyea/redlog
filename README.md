# Red Log

## About

Red Log is a Laravel package for writing log messages to a MySQL, PostgreSQL, SQLite, or SQL Server database.

## Requirements

* PHP >= 7.0
* Laravel >= 5.5

## Installation

```
composer require tyea/redlog
```

## Usage

Update your `.env` and `.env.example` files:

```
LOG_CHANNEL=database
LOG_TABLE=logs
```

Update your `config/logging.php` file:

```
"database" => [
	"driver" => "monolog",
	"handler" => "Tyea\\RedLog\\DatabaseHandler",
	"table" => env("LOG_TABLE", "logs")
]
```

Run these commands:

```
php artisan log:table
php artisan migrate
```

Update your `app/Console/Kernel.php` file:

```
$schedule->command("log:clear 7")->daily();
```

## Author

Written by Tom Yeadon in April 2020.
