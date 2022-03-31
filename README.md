# Rimsys Standards API

This repo contains the application responible or importing standards from various data providers into a dedicated standards service. Additionally, it provides a REST API that allows other applications to connect use it. 

## Installation

Install Laravel other Composer dependencies

```
composer install
```

Migrate databse tables

```
php artisan migrate
```

## Database Seeders

For convenience, two seeders are available to set an inital database state for this API. You may seed each of these as outlined below or see them all at once by running:

```
php artisan db:seed
```


### Seeding Sample Standard Data

An initial set of 50,000 records is included in a `standads.gz` SQL dump. You can seed this data by calling:

```
php artisan db:seed --class=StandardSeeder
```

### Seeding a Development API Key

For convenience, you may seed an initial development key that is configured with in the [Postman environment](#postman).

```
php artisan db:seed --class=AppTokenSeeder
```


## API Documentation

This repo contains API documentation that provides detail on how to authenticate and use this API in other applications. Additionally, the documentation covers a `token` tool to provide an easy way to register, and delete new application tokens as well as list any applications with current active tokens. 

| Section                          			 | Summary 																		   | 
| ------------------------------------------ | ------------------------------------------------------------------------------- | 
| [Authentication.md](docs/Authenication.md) | How to configuring server tokens and use them in requests                       |
| [ClientCommand.md](docs/ClientCommand.md)  | The command line tool to setup and list tokens as well as remove current tokens |
| [Standards.md](docs/Standards.md)          | How use use the API, including sample requests, responses and errors 		   |

### Postman {#postman}

For convenience, sample requests are configured in a [Postman Workspace](https://interstellar-trinity-886684.postman.co/) that can be used to explore this API.

[Join this workspace](https://app.getpostman.com/join-team?invite_code=9b243aab8e743a4e76096f63485f8768)
