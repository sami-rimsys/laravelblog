# Standards API

## Authentication

To make requests to the standards API, be sure to include the `X-Rimsys-Server-Token` header with the token you received during client setup. These steps are defined in the [Authentication Section](Authentication.md)

## Requesting Standards

All requests to v1 of this API should be made to `/api/v1`. For standards specifically, this api currently exposes two endpoints

| Method | Endpoint                         | Purpose                       |
| ------ | -------------------------------- | ----------------------------- |
| `GET`  | `/api/v1/standards`              | Request an index of standards |
| `GET`  | `/api/v1/standards/{standardId}` | Request a given standard      |

## Requesting an Index of Standards

You may request an index of standards using the endpoint `/api/v1/standards`.

### Query Parameters

This endpoint accepts several query parameters.

| Parameter | Description |
| --- | --- |
| [limit](#limit) | Limit the number of results per page (max: 100) | 
| [page](#page) | Request a specific page in the result set | 
| [ids](#ids) | Only return standards with the specified ids | 
| [order_by](#order_by) | Order the result set by attribute and direction | 
| [only](#only) | Only include the specified attributed in the result set | 
| [except](#except) | Include attributes except the specified attributed in th result set | 


#### Limit {#limit}

By default, records are limited to 100 per page. You may change this by adding a limit parameter to the request.

```
api/v1/standards?limit=50
```

**Note:** 100 is the maximum number of records that can be returned per page. 

[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-4f05572a-3ebf-4a19-90a4-449a8d43dca2)

#### Pagination {#page}

You may request a specific page of results using the `page` pameter. For example, to request the 2nd page of results:

```
api/v1/standards?page=2
```

Pagination also works with any other query parameters. For example, to request page 2 with 10 results per page, simply add both a `limit` and a `page` parameter

```
api/v1/standards?limit=10&page=2
```

If you request a non-existant page, you will receive an empty result set.

[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-aead8e52-145d-48f8-89da-7b3bb12d03fe)

#### Filter by Standard Id {#ids}

You may filter the standards returned by id by passing the `ids` parameter along with a comma seperated list of ids. The id value corresponds with the `id` attribute on a standard.

[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-663b2080-e200-438e-9622-1b0e4c1babe0)

##### Errors

A `422` will be returned if you request one of the following:

| Request | Response |
|-------- | -------- |
| More than 100 ids | [Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-89ffc68c-3502-4348-98e6-4d84bc0f3dbf) |
| An id that doesn't exist | [Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-81f42dcc-6fd0-45c2-ba51-ec190d89ebe9) |
| A non-numeric id | [Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-81f42dcc-6fd0-45c2-ba51-ec190d89ebe9) |

#### Order Result Set {#order_by}

By default, the result set is ordered by the `updated_at` attribute in decending order. You may order the result set in either ascending or decenting order on a given attribute by passing a direction attribute string to the `order_by` parameter.

To order by the `title` attribute in ascending order:

```
/standards=order_by=asc:title
```

[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-b81056b2-fe97-4887-a7b7-49ef7ad66bea)

To order by the `title` attribute in descending order:

```
/standards=order_by=desc:title
```

[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-e3242c1f-2cca-448d-b383-41ce13e65984)

**Default:**

The default sort direction of decending is applied if one is not provided. For example, the following request will order by title in decending order.

```
/standards=order_by=title
```

##### Errors

A `422` will be returned if the request contains either an invalid direction or attribute

| Request | Response |
|-------- | -------- |
| Invalid Attribute | [Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-44ee24c5-3ce8-4734-9f33-20dd89180849) |
| Invalid Direction | [Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-72796161-6a8d-427c-8fd0-8e42c440c4d2) |

### Response Structure

All requests to this endpoint will generate JSON responses with this structure.

```
{
   "total": 50,
   "per_page": 15,
   "current_page": 1,
   "last_page": 4,
   "first_page_url": "http://rimsys-scrapers.test/api/v1/standards?page=1",
   "last_page_url": "http://rimsys-scrapers.test/api/v1/standards?page=4",
   "next_page_url": "http://rimsys-scrapers.test/api/v1/standards?page=2",
   "prev_page_url": null,
   "path": "http://rimsys-scrapers.test/api/v1/standards",
   "from": 1,
   "to": 15,
   "data":[
        {
            "id": '',
            "number": '',
            "title": '',
            "url": '',
            "provider": '',
            "overview": '',
            "status": '',
            "year": '',
            "cross_reference": '',
            "publisher": '',
            "pages": '',
            "replaces": '',
            "replaced_by": '',
            "provider_standard_id": '',
            "isbn": '',
            "changed_at": '',
            "publication_date": '',
            "withdrawn_date": '',
            "created_at": '',
            "updated_at": '',
        },
        {
            // Next Record...
        }
   ]
}
```

#### Errors

Error responses will contain an `errors` object with the errors that were found in the request. Errors are keyed by parameter name.

```
{
    "message": "The given data was invalid.",
    "errors": {
        "order_by": [
            "Invalid sort order 'invalid' was found in 'order_by=invalid:number' "
        ]
    }
}
```

### Record Attributes

Each record in a response will include the following attrubutes

| Attribute          | Type      | Note 													 |
| ------------------ | --------- | --------------------------------------------------------- |
| `id`               | int       | Unique identifier 										 |
| `number`           | string    | The standard number 										 |
| `title`            | text      | The title of the standard                                 |
| `url`              | text      | The url the to standard on the providers website          |
| `provider`         | string    | The name of the provider (e.g. ITEH)                      |
| `overview`         | text      | The overview text of the standard                         |
| `status`           | string    | The status of the standard (e.g. 'current', 'withdrawn')  |
| `year`             | string    | The 4 digit year of the standard 						 |
| `cross_reference`  | text      | The cross reference statement from the provider 			 |
| `publisher`        | string    | The publisher of the standard 							 |
| `pages`            | int       | The number of pages in the standard 						 |
| `replaces`         | text      | The text explaining the replacement of this standard 	 |
| `replaced_by`      | string    | The standard number that replaces this standard 			 |
| `isbn`             | string    | The ISBN10 code 											 |
| `changed_at` 	 	 | timestamp | The date the standard was changed in ISO 8601 format		 |
| `publication_date` | timestamp | The date the standard was published in ISO 8601 format	 |
| `withdrawn_date`   | timestamp | The date the standard was withdrawn in ISO 8601 format	 |
| `created_at`       | timestamp | The date the standard was imported in ISO 8601 format	 |
| `updated_at`       | timestamp | The date the standard was last changed in ISO 8601 format |

#### Subset of Attributes

To request a subset of attributes to be returned for each record, you may use the `only` and `except` query parameters along with a comma seperated list of attributes.

##### Only include the specified attributes {#only}

To request only `number`, `title` and `status` for records:

```
/api/v1/standards?only=number,titile,status
```
[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-a97ebb09-9331-47ab-8aed-619a1e8bc026)

##### Include all attributed except the specified {#except}

To request all attributes except `number`, `title` and `status` for records:

```
/api/v1/standards?except=number,titile,status
```

[Explore with Postman](https://interstellar-trinity-886684.postman.co/workspace/Rimsys-Standards-API~e26f7b2e-1f7e-41cc-87c9-09f082cb6471/request/876121-000c6e78-d10a-41fa-a22c-6b3f63197f7c)