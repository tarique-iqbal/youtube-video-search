# YouTube Video Search
A small command-line utility that will search YouTube videos by keyword and the result would be written in an Excel file.

## Prerequisites

```
composer
php (>=8.2)
```

## Note
The application will now work if [register_argc_argv](http://php.net/manual/en/ini.core.php#ini.register-argc-argv) is disabled.

## Installation and Run the script

- All the `code` required to get started

- Clone this repo to your local machine using
```shell
$ git clone https://github.com/tarique-iqbal/youtube-video-search.git
```

- Need write permission to following `directories`

`./var/data` `./var/logs` 

- Install the script

```shell
$ cd /path/to/base/directory
$ composer install --no-dev
```

Adapt `config/parameters.php`

- Run the script

```shell
$ php index.php keyword
or
$ php index.php 'Search keyword'
```

- Output file location

`./var/data`

## Running the tests

- Follow the Installation instructions.

Adapt `phpunit.xml.dist` PHP Constant according to your setup environment.

```shell
$ cd /path/to/base/directory
$ composer update
$ ./vendor/bin/phpunit tests
```

Test-cases, test unit and integration tests.
