# Picterest

Picterest is a _simple_ Pinterest clone made for learning purposes.

## Requirements

- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Make](https://www.gnu.org/software/make/)
- PHP 8.0 or higher
- `pdo_pgsql` extension enabled
- [Symfony CLI](https://symfony.com/download)
- [Symfony requirements](https://symfony.com/doc/current/setup.html)

## Setup

Go to [Mailtrap](https://mailtrap.io/) and create an account or log in (It's free).

Create an Inbox and go to your SMTP Settings, select the Symfony 5 integration copy and paste the result in the .env file.

Run the following command to set up the environment:

```shell
make setup
```

## Usage

To start the web server and the messenger workers run the following command:

```shell
make start
```

To stop the web server and the messenger workers run the following command:

```shell
make stop
```
