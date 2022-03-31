# Authentication

Authenticating with the service is done through server tokens. 

## Client Setup

To setup access for a given server (instance of the app) use the [`token:setup` Artisan command](ClientCommand.md).

```
$ php artisan token:setup
```

## API Authentication

To make authenticated requests to the API, simply add the `X-Rimsys-Server-Token` header with the token value you recived when setting up the client.

```
[
	'X-Rimsys-Server-Token' => 'dfasdfasdfasdf'
]
```

If an invalid token is passed, a `403 Forbidden` response will be returned. 
