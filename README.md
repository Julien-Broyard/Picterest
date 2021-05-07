# Picterest

Picterest is a _simple_ Pinterest clone made for learning purposes.

## Requirements

- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- PHP 8.0 or higher
- `pdo_pgsql` extension enabled
- [Symfony CLI](https://symfony.com/download)
- [Symfony requirements](https://symfony.com/doc/current/setup.html)

## Setup

Go to [Mailtrap](https://mailtrap.io/) and create an account or log in (It's free).

Create an Inbox and go to your SMTP Settings, select the Symfony 5 integration copy and paste the result in the .env file.

Run the following command to set up the environment:

```shell
composer run setup
```

## Usage

To start the web server and the messenger workers run the following command:

```shell
composer run start
```

To stop the web server and the messenger workers run the following command:

```shell
composer run stop
```

## Tests

To run the tests run the following command:

```shell
composer run test
```