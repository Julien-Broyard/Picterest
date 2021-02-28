# Picterest

Picterest is a _simple_ Pinterest clone made for learning purposes.

### Requirements

- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Make](https://www.gnu.org/software/make/)
- PHP 8.0 or higher
- `pdo_pgsql` extension enabled
- [Symfony CLI](https://symfony.com/download)
- [Symfony requirements](https://symfony.com/doc/current/setup.html)


### Setup

Run the following command to set up the environment:

```
make setup
```

### Usage

To start the web server and the messenger workers run the following command:

```
make start
```

To stop the web server and the messenger workers run the following command:

```
make stop
```