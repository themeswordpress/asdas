# Suppliers' API Reference

The Vatrex suppliers API offers a way to interact with suppliers resources programmatically.

All API requests must be made over HTTPS. Calls made over plain HTTP will fail. API requests without authentication will also fail for the private endpoints.

Each request must be authenticated with an API access key using the authorization request header. You can obtain an access key for an account by using the login or register routes.

API keys have a rate limit of [To be determined] requests per minute by default.

Use this document to explore the API for available endpoints. Potentially, we will release an API Blueprint support.

## Pagination

### Offset / limit

You can specify an offset to start from and a limit to the number of results.

```html
?offset=20&limit=10
```

### Page / page size

You can specify the page number and the size of each page.

```html
?page=2&page_size=10
```

`page_size` defaults to 25 for all paginated resources.

### Cursor

You can fetch a specific number of results before or after a given cursor.

```html
?first=10&after=g3QAAAABZAACaWRiAAACDg==
?last=10&before=g3QAAAABZAACaWRiAAACDg==
```

## Ordering

To sort the results, specify fields to order by and the direction of sorting for
each field.

```html
?order_by[]=name&order_by[]=age&order_directions[]=asc&order_directions[]=desc
```

## Filtering

### Filters

A complete filter consists of the field, the operator, and the value. The
operator is optional and defaults to `==`. Filters need to be passed as a list
and are combined with a logical `AND`. It is currently not possible to combine
filters with an `OR`.

```html
?filters[0][field]=name&filters[0][op]=ilike_and&filters[0][value]=Jane
```

### Supported Operators

| Operator       | Value              | WHERE clause                                            |
| :------------- | :----------------- | ------------------------------------------------------- |
| `==`           | `"Salicaceae"`     | `WHERE column = 'Salicaceae'`                           |
| `!=`           | `"Salicaceae"`     | `WHERE column != 'Salicaceae'`                          |
| `=~`           | `"cyth"`           | `WHERE column ILIKE '%cyth%'`                           |
| `empty`        | `true`             | `WHERE (column IS NULL) = true`                         |
| `empty`        | `false`            | `WHERE (column IS NULL) = false`                        |
| `not_empty`    | `true`             | `WHERE (column IS NOT NULL) = true`                     |
| `not_empty`    | `false`            | `WHERE (column IS NOT NULL) = false`                    |
| `<=`           | `10`               | `WHERE column <= 10`                                    |
| `<`            | `10`               | `WHERE column < 10`                                     |
| `>=`           | `10`               | `WHERE column >= 10`                                    |
| `>`            | `10`               | `WHERE column > 10`                                     |
| `in`           | `["pear", "plum"]` | `WHERE column = ANY('pear', 'plum')`                    |
| `not_in`       | `["pear", "plum"]` | `WHERE column = NOT IN('pear', 'plum')`                 |
| `contains`     | `"pear"`           | `WHERE 'pear' = ANY(column)`                            |
| `not_contains` | `"pear"`           | `WHERE 'pear' = NOT IN(column)`                         |
| `like`         | `"cyth"`           | `WHERE column LIKE '%cyth%'`                            |
| `not_like`     | `"cyth"`           | `WHERE column NOT LIKE '%cyth%'`                        |
| `like_and`     | `["Rubi", "Rosa"]` | `WHERE column LIKE '%Rubi%' AND column LIKE '%Rosa%'`   |
| `like_and`     | `"Rubi Rosa"`      | `WHERE column LIKE '%Rubi%' AND column LIKE '%Rosa%'`   |
| `like_or`      | `["Rubi", "Rosa"]` | `WHERE column LIKE '%Rubi%' OR column LIKE '%Rosa%'`    |
| `like_or`      | `"Rubi Rosa"`      | `WHERE column LIKE '%Rubi%' OR column LIKE '%Rosa%'`    |
| `ilike`        | `"cyth"`           | `WHERE column ILIKE '%cyth%'`                           |
| `not_ilike`    | `"cyth"`           | `WHERE column NOT ILIKE '%cyth%'`                       |
| `ilike_and`    | `["Rubi", "Rosa"]` | `WHERE column ILIKE '%Rubi%' AND column ILIKE '%Rosa%'` |
| `ilike_and`    | `"Rubi Rosa"`      | `WHERE column ILIKE '%Rubi%' AND column ILIKE '%Rosa%'` |
| `ilike_or`     | `["Rubi", "Rosa"]` | `WHERE column ILIKE '%Rubi%' OR column ILIKE '%Rosa%'`  |
| `ilike_or`     | `"Rubi Rosa"`      | `WHERE column ILIKE '%Rubi%' OR column ILIKE '%Rosa%'`  |

The filter operators `empty` and `not_empty` will regard empty arrays as
empty values if the field is known to be an array field.

The filter operators `ilike_and`, `ilike_or`, `like_and` and `like_or`
accept both strings and list of strings.

- If the filter value is a string, it will be split at whitespace characters
  and the segments are combined with `and` or `or`.
- If a list of strings is passed, the individual strings are not split, and
  the list items are combined with `and` or `or`.



## Endpoints


  * [Working with Customers](#working-with-customers)
    * [index](#working-with-customers-index)
    * [create](#working-with-customers-create)
    * [show](#working-with-customers-show)
    * [create](#working-with-customers-create)
    * [update](#working-with-customers-update)
    * [delete](#working-with-customers-delete)
  * [Working with Segments](#working-with-segments)
    * [index](#working-with-segments-index)
  * [Users Authentication](#users-authentication)
    * [register](#users-authentication-register)
    * [verify_otp](#users-authentication-verify_otp)
    * [login](#users-authentication-login)
    * [logout](#users-authentication-logout)
  * [Working with Messages](#working-with-messages)
    * [index](#working-with-messages-index)
    * [create](#working-with-messages-create)
  * [Working with Collections](#working-with-collections)
    * [index](#working-with-collections-index)
    * [create](#working-with-collections-create)
    * [update](#working-with-collections-update)
    * [show](#working-with-collections-show)
    * [update](#working-with-collections-update)
    * [delete](#working-with-collections-delete)
    * [attach_products](#working-with-collections-attach_products)
    * [detach_products](#working-with-collections-detach_products)
    * [sort_collections](#working-with-collections-sort_collections)
  * [Working with Products](#working-with-products)
    * [index](#working-with-products-index)
    * [create](#working-with-products-create)
    * [show](#working-with-products-show)
    * [create](#working-with-products-create)
    * [update](#working-with-products-update)
    * [delete](#working-with-products-delete)
  * [Working with Orders](#working-with-orders)
    * [index](#working-with-orders-index)
    * [create](#working-with-orders-create)
    * [show](#working-with-orders-show)
    * [create](#working-with-orders-create)
    * [fulfill](#working-with-orders-fulfill)
    * [cancel](#working-with-orders-cancel)
    * [mark_as_paid](#working-with-orders-mark_as_paid)
  * [Fetching Statistics](#fetching-statistics)
    * [index](#fetching-statistics-index)
  * [Getting Store Slug Suggestions](#getting-store-slug-suggestions)
    * [suggest_slugs](#getting-store-slug-suggestions-suggest_slugs)
  * [Working with Stores](#working-with-stores)
    * [create](#working-with-stores-create)
    * [show](#working-with-stores-show)
    * [update](#working-with-stores-update)
    * [delete](#working-with-stores-delete)
  * [Working with Subsbase Webhooks](#working-with-subsbase-webhooks)
    * [process_webhook](#working-with-subsbase-webhooks-process_webhook)

## Working with Customers
### <a id=working-with-customers-index></a>index
#### index lists all customers

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers
* __Request headers:__
```
accept: application/json
authorization: HD3O27zXbfqo90HA6HQninkki9Gnu41g-zZZASeIoI8
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:45 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlQMQ95948jIAABim
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

#### Customers pagination

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?page_size=2
* __Request headers:__
```
accept: application/json
authorization: HSuYCFtpx4l0LFyCs3TMup54bjwB7A28OWEiJ7hQ81M
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:47 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlZQzGa8rQlwAAB1m
```
* __Response body:__
```json
{
  "data": [
    {
      "additional_notes": "some additional_notes",
      "address": {
        "city": null,
        "street_address": null
      },
      "country_code": "EG",
      "id": 1,
      "name": "some name",
      "opted_in_at": null,
      "phone_number": "+201117040436",
      "type": "manual"
    },
    {
      "additional_notes": "some additional_notes",
      "address": {
        "city": null,
        "street_address": null
      },
      "country_code": "EG",
      "id": 2,
      "name": "some name",
      "opted_in_at": null,
      "phone_number": "+201118450398",
      "type": "manual"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": 2,
    "page_size": 2,
    "previous_page": null,
    "total_count": 4,
    "total_pages": 2
  }
}
```

#### Filtering by phone number with some results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?filters[0][field]=phone_number&filters[0][value]=%2B201111500574
* __Request headers:__
```
accept: application/json
authorization: dV7eLQvdVK4p9IRBdh1qIbI1kSKAvWqDkn1zF6VPIGU
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:47 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlXrLQ5aPVpkAABYC
```
* __Response body:__
```json
{
  "data": [
    {
      "additional_notes": "some additional_notes",
      "address": {
        "city": null,
        "street_address": null
      },
      "country_code": "EG",
      "id": 1,
      "name": "some name",
      "opted_in_at": null,
      "phone_number": "+201111500574",
      "type": "manual"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Filtering by phone number with no results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?filters[0][field]=phone_number&filters[0][value]=invalid
* __Request headers:__
```
accept: application/json
authorization: TOxzS5UlnxNIMswEd4idVsBP4YwEsbtI8SDkXQRuW1I
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:45 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlSzqFZAWmpIAABWn
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

#### Filtering by name or phone number with some results (only the 'ilike' operation is supported for the 'q' field)

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?filters[0][field]=q&filters[0][op]=ilike&filters[0][value]=some
* __Request headers:__
```
accept: application/json
authorization: IYc2FEYsi-4jve9q_DbsrZp2KamV1plpZrvxkjEISTw
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:45 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlRAJo-i2wOoAABlG
```
* __Response body:__
```json
{
  "data": [
    {
      "additional_notes": "some additional_notes",
      "address": {
        "city": null,
        "street_address": null
      },
      "country_code": "EG",
      "id": 1,
      "name": "some name",
      "opted_in_at": null,
      "phone_number": "+201119230555",
      "type": "manual"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Filtering by name or phone number with some results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?filters[0][field]=q&filters[0][op]=ilike&filters[0][value]=%2B201119583957
* __Request headers:__
```
accept: application/json
authorization: SYgv0BiyOdefNVZ67gbGwahq684iGGI5W6iKJDSUMcg
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:46 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlW4QhICg1KIAABdn
```
* __Response body:__
```json
{
  "data": [
    {
      "additional_notes": "some additional_notes",
      "address": {
        "city": null,
        "street_address": null
      },
      "country_code": "EG",
      "id": 1,
      "name": "some name",
      "opted_in_at": null,
      "phone_number": "+201119583957",
      "type": "manual"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Filtering by name or phone number with no results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?filters[0][field]=q&filters[0][op]=ilike&filters[0][value]=nothing
* __Request headers:__
```
accept: application/json
authorization: f3Tjpv_qxEGDZVoSbqcNg5YiI2b_7TeTxFwGPHIv1m8
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:44 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlPYCI8nLfOwAAAqI
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

#### Invalid operation on 'q' field

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers?filters[0][field]=q&filters[0][op]=empty&filters[0][value]=nothing
* __Request headers:__
```
accept: application/json
authorization: nxxzIJAVNsjfGipOwQYUlVi4w1FOHbU8npKKYHJQH1I
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:45 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlTnltlxQlxIAAAwI
```
* __Response body:__
```json
{
  "errors": {
    "filters": [
      {
        "op": [
          "is invalid"
        ],
        "value": [
          "is invalid"
        ]
      }
    ]
  }
}
```

### <a id=working-with-customers-create></a>create
#### create customer renders customer when data is valid

##### Request
* __Method:__ POST
* __Path:__ /api/v1/customers
* __Request headers:__
```
accept: application/json
authorization: jVg-Tf_T1nz17MSyh0X4d3EXND727NJph9Sfr3Ms2rw
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "additional_notes": "some additional_notes",
  "address": {
    "city": "Alexandria",
    "street_address": "Some St."
  },
  "name": "some name",
  "phone_number": "+201111653602",
  "type": "manual"
}
```

##### Response
* __Status__: 201
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:46 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlUaAcVQFIL8AABrm
location: /api/v1/customers/1
```
* __Response body:__
```json
{
  "additional_notes": "some additional_notes",
  "address": {
    "city": "Alexandria",
    "street_address": "Some St."
  },
  "country_code": "EG",
  "id": 1,
  "name": "some name",
  "opted_in_at": null,
  "phone_number": "+201111653602",
  "type": "manual"
}
```

### <a id=working-with-customers-show></a>show
#### create customer renders customer when data is valid

##### Request
* __Method:__ GET
* __Path:__ /api/v1/customers/1
* __Request headers:__
```
accept: application/json
authorization: jVg-Tf_T1nz17MSyh0X4d3EXND727NJph9Sfr3Ms2rw
cookie: locale=en
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:46 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlUa7EnEFIL8AABsG
```
* __Response body:__
```json
{
  "additional_notes": "some additional_notes",
  "address": {
    "city": "Alexandria",
    "street_address": "Some St."
  },
  "country_code": "EG",
  "id": 1,
  "name": "some name",
  "opted_in_at": null,
  "phone_number": "+201111653602",
  "type": "manual"
}
```

### <a id=working-with-customers-create></a>create
#### Providing invalid data

##### Request
* __Method:__ POST
* __Path:__ /api/v1/customers
* __Request headers:__
```
accept: application/json
authorization: 5zcdpEiFExrmVTqJtUGxY2vfqygXjS3w3JtiJU90TAE
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": null,
  "phone_number": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:47 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlYdZKg0VHXMAABym
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ],
    "phone_number": [
      "can't be blank"
    ]
  }
}
```

### <a id=working-with-customers-update></a>update
#### update customer renders customer when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/customers/1
* __Request headers:__
```
accept: application/json
authorization: X3ftVo484X3QvSzYKWYbyyOLDyINYAM6iJBImKL9MrI
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "additional_notes": "some updated additional_notes",
  "address": {},
  "name": "some updated name",
  "phone_number": "+201119434475",
  "type": "manual"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:46 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlWDwyTDLrJ8AABum
```
* __Response body:__
```json
{
  "additional_notes": "some updated additional_notes",
  "address": {
    "city": null,
    "street_address": null
  },
  "country_code": "EG",
  "id": 1,
  "name": "some updated name",
  "opted_in_at": null,
  "phone_number": "+201119434475",
  "type": "manual"
}
```

#### update customer renders errors when data is invalid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/customers/1
* __Request headers:__
```
accept: application/json
authorization: 48xnIBjf6TLEKlz9Uy37_XzU9ZK2TIJ7HQ_KMgyXzk0
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": null,
  "phone_number": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:45 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlR3ILa0PY1cAABnG
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ],
    "phone_number": [
      "can't be blank"
    ]
  }
}
```

### <a id=working-with-customers-delete></a>delete
#### delete customer deletes chosen customer

##### Request
* __Method:__ DELETE
* __Path:__ /api/v1/customers/1
* __Request headers:__
```
accept: application/json
authorization: ACmW049kQA1dkNYS3B6jdUDw159mV_N-WOmrnIdeyGA
```

##### Response
* __Status__: 204
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:46 GMT; max-age=864000; HttpOnly
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlVQB-b_p3zYAABtG
```
* __Response body:__
```json

```

## Working with Segments
### <a id=working-with-segments-index></a>index
#### index lists all segments

##### Request
* __Method:__ GET
* __Path:__ /api/v1/segments
* __Request headers:__
```
accept: application/json
authorization: jK5YK6PNJ39ftQqYgmPcAmF4jQ8c4NB5_WVNndy-ihM
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:48 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlbplJdweGGoAABai
```
* __Response body:__
```json
{
  "data": [
    {
      "count": 1,
      "description": "Represents customers opted in to receive newsletters",
      "name": "Subscribers",
      "segment": "subscribers"
    }
  ]
}
```

## Users Authentication
### <a id=users-authentication-register></a>register
#### POST /api/v1/register register new account

##### Request
* __Method:__ POST
* __Path:__ /api/v1/register
* __Request headers:__
```
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "phone_number": "+201118844481"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:34 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwknHkq5nboFEAAAjh
```
* __Response body:__
```json
{
  "message": "OTP sent to phone number. Please check your messages.",
  "phone_number": "+201118844481"
}
```

#### invalid phone number

##### Request
* __Method:__ POST
* __Path:__ /api/v1/register
* __Request headers:__
```
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "phone_number": "invalid"
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:34 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwknVqdQX0FAIAAAmB
```
* __Response body:__
```json
{
  "errors": {
    "phone_number": [
      "The string supplied did not seem to be a phone number"
    ]
  }
}
```

### <a id=users-authentication-verify_otp></a>verify_otp
#### POST /api/v1/verify-otp logs the user in

##### Request
* __Method:__ POST
* __Path:__ /api/v1/verify-otp
* __Request headers:__
```
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "otp": "1993",
  "phone_number": "+970598765432"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:34 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwknSFY5THls8AAAMn
```
* __Response body:__
```json
{
  "access_token": "nU--mrMUt41Stlews91CHAOx2F3gBsqLeULCBpWsKuA",
  "is_registration_complete": false
}
```

### <a id=users-authentication-login></a>login
#### POST /api/v1/login logs the user in

##### Request
* __Method:__ POST
* __Path:__ /api/v1/login
* __Request headers:__
```
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "phone_number": "+201119076942"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:34 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwknTd0e3DnPIAAAlB
```
* __Response body:__
```json
{
  "message": "OTP sent to phone number. Please check your messages.",
  "phone_number": "+201119076942"
}
```

### <a id=users-authentication-logout></a>logout
#### POST /api/v1/logout logs the user out

##### Request
* __Method:__ POST
* __Path:__ /api/v1/logout
* __Request headers:__
```
authorization: 2A-TKq0g3z0TNj3SxsQDF04ieB8SL-AQXKFqXp8Evfg
```

##### Response
* __Status__: 204
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:33 GMT; max-age=864000; HttpOnly
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwknBUK5qxZfYAAAgh
```
* __Response body:__
```json

```

#### Logout using invalid access token

##### Request
* __Method:__ POST
* __Path:__ /api/v1/logout
* __Request headers:__
```
authorization: 2A-TKq0g3z0TNj3SxsQDF04ieB8SL-AQXKFqXp8Evfg
```

##### Response
* __Status__: 401
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:33 GMT; max-age=864000; HttpOnly
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwknGclnmxZfYAAAjB
```
* __Response body:__
```json

```

## Working with Messages
### <a id=working-with-messages-index></a>index
#### index lists all messages

##### Request
* __Method:__ GET
* __Path:__ /api/v1/messages
* __Request headers:__
```
accept: application/json
authorization: l6y9S02a-m6eryTPcbtnj03gwEFONvgVi_dMWPjXtKU
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:48 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlcut6E4LVFQAABnn
```
* __Response body:__
```json
{
  "data": []
}
```

### <a id=working-with-messages-create></a>create
#### create message responds with 503 Service Unavailable

##### Request
* __Method:__ POST
* __Path:__ /api/v1/messages
* __Request headers:__
```
accept: application/json
authorization: _T1rEcVx3BN6adgtA6FTmc8rZbf1d-vTpSV74o_7sbo
content-type: multipart/mixed; boundary=plug_conn_test
```

##### Response
* __Status__: 503
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:48 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwldg9LIpsC0MAABFI
```
* __Response body:__
```json
{
  "errors": {
    "detail": "Service Unavailable"
  }
}
```

## Working with Collections
### <a id=working-with-collections-index></a>index
#### index lists all collections

##### Request
* __Method:__ GET
* __Path:__ /api/v1/collections
* __Request headers:__
```
accept: application/json
authorization: 4jo3owbvZZZ8fuPogqwL5qGxII75zXrVrb-wZik-VW4
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:43 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlI21PR-KgKoAABSm
```
* __Response body:__
```json
{
  "data": [
    {
      "display_order": 1,
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "https://vatrin-dev.s3.amazonaws.com/image1.png"
      ],
      "name": "some name5223",
      "products_count": 2,
      "slug": "some-name5223"
    }
  ]
}
```

### <a id=working-with-collections-create></a>create
#### create collection renders collection when data is valid

##### Request
* __Method:__ POST
* __Path:__ /api/v1/collections
* __Request headers:__
```
accept: application/json
authorization: 846OBqOXRs7gEj-ebN5tA-qnh_MVQBUanlb62cdiecM
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": "some name"
}
```

##### Response
* __Status__: 201
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:44 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlOk7mqAjLm4AABPH
location: /api/v1/collections/1
```
* __Response body:__
```json
{
  "display_order": 1,
  "id": 1,
  "name": "some name",
  "products_count": null,
  "slug": "some-name"
}
```

#### Not providing a collection name

##### Request
* __Method:__ POST
* __Path:__ /api/v1/collections
* __Request headers:__
```
accept: application/json
authorization: 5eav-3so0FnkKGDKPYYijaDVdLuUzXLbLqp5Jjf30Nw
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:44 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlNy0sGnHq6sAABfm
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ]
  }
}
```

### <a id=working-with-collections-update></a>update
#### update collection renders collection when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/collections/1
* __Request headers:__
```
accept: application/json
authorization: _YgCPZA1oTTPTa12Y4J06sjZLcTdyCnn65Z9V01LGEU
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": "some updated name"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:43 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlKh0n6AoNF0AABUm
```
* __Response body:__
```json
{
  "display_order": 1,
  "id": 1,
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/image1.png",
    "https://vatrin-dev.s3.amazonaws.com/image1.png"
  ],
  "name": "some updated name",
  "products": [
    {
      "always_available": false,
      "description": "some description",
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "https://vatrin-dev.s3.amazonaws.com/image2.png"
      ],
      "name": "some name",
      "slug": "some-name",
      "total_quantity": 84,
      "variant_count": 2,
      "variants": [
        {
          "always_available": false,
          "id": 1,
          "name": "regular",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        },
        {
          "always_available": false,
          "id": 2,
          "name": "large",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        }
      ],
      "variants_name": "variants",
      "visibility": "visible"
    },
    {
      "always_available": false,
      "description": "some description",
      "id": 2,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "https://vatrin-dev.s3.amazonaws.com/image2.png"
      ],
      "name": "some name",
      "slug": "some-name-1",
      "total_quantity": 84,
      "variant_count": 2,
      "variants": [
        {
          "always_available": false,
          "id": 3,
          "name": "regular",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        },
        {
          "always_available": false,
          "id": 4,
          "name": "large",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        }
      ],
      "variants_name": "variants",
      "visibility": "visible"
    }
  ],
  "products_count": 2,
  "slug": "some-updated-name"
}
```

### <a id=working-with-collections-show></a>show
#### update collection renders collection when data is valid

##### Request
* __Method:__ GET
* __Path:__ /api/v1/collections/1
* __Request headers:__
```
accept: application/json
authorization: _YgCPZA1oTTPTa12Y4J06sjZLcTdyCnn65Z9V01LGEU
cookie: locale=en
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:43 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlKi96asoNF0AABVm
```
* __Response body:__
```json
{
  "display_order": 1,
  "id": 1,
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/image1.png",
    "https://vatrin-dev.s3.amazonaws.com/image1.png"
  ],
  "name": "some updated name",
  "products": [
    {
      "always_available": false,
      "description": "some description",
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "https://vatrin-dev.s3.amazonaws.com/image2.png"
      ],
      "name": "some name",
      "slug": "some-name",
      "total_quantity": 84,
      "variant_count": 2,
      "variants": [
        {
          "always_available": false,
          "id": 1,
          "name": "regular",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        },
        {
          "always_available": false,
          "id": 2,
          "name": "large",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        }
      ],
      "variants_name": "variants",
      "visibility": "visible"
    },
    {
      "always_available": false,
      "description": "some description",
      "id": 2,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "https://vatrin-dev.s3.amazonaws.com/image2.png"
      ],
      "name": "some name",
      "slug": "some-name-1",
      "total_quantity": 84,
      "variant_count": 2,
      "variants": [
        {
          "always_available": false,
          "id": 3,
          "name": "regular",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        },
        {
          "always_available": false,
          "id": 4,
          "name": "large",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        }
      ],
      "variants_name": "variants",
      "visibility": "visible"
    }
  ],
  "products_count": 2,
  "slug": "some-updated-name"
}
```

### <a id=working-with-collections-update></a>update
#### Not providing a collection name

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/collections/1
* __Request headers:__
```
accept: application/json
authorization: GvZZpz_TDYLXXWeWgyBpBtvYoWprxBcuhakQIJEZ0TA
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:43 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlJsrZPE8_D0AABJn
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ]
  }
}
```

### <a id=working-with-collections-delete></a>delete
#### delete collection deletes chosen collection

##### Request
* __Method:__ DELETE
* __Path:__ /api/v1/collections/1
* __Request headers:__
```
accept: application/json
authorization: ZSe5_vy38Vrj_2cCsp1cPtiFyrmoUg8ztsNUqChUSho
```

##### Response
* __Status__: 204
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:44 GMT; max-age=864000; HttpOnly
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlM-zLpJmFSsAABbG
```
* __Response body:__
```json

```

### <a id=working-with-collections-attach_products></a>attach_products
#### attach collection products renders collection and its products when data is valid

##### Request
* __Method:__ POST
* __Path:__ /api/v1/collections/1/products
* __Request headers:__
```
accept: application/json
authorization: xG_shU-Iej506YXKg8EqBabcaNifDm-i3tW_2BW8jT8
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "product_ids": [
    1
  ]
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:42 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlH_8rXff3M4AABNm
```
* __Response body:__
```json
{
  "display_order": 1,
  "id": 1,
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/image1.png"
  ],
  "name": "some name4903",
  "products": [
    {
      "always_available": false,
      "description": "some description",
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "https://vatrin-dev.s3.amazonaws.com/image2.png"
      ],
      "name": "some name",
      "slug": "some-name",
      "total_quantity": 84,
      "variant_count": 2,
      "variants": [
        {
          "always_available": false,
          "id": 1,
          "name": "regular",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        },
        {
          "always_available": false,
          "id": 2,
          "name": "large",
          "price": "42.00",
          "quantity": 42,
          "reduced_price": null,
          "sku": null
        }
      ],
      "variants_name": "variants",
      "visibility": "visible"
    }
  ],
  "products_count": 1,
  "slug": "some-name4903"
}
```

### <a id=working-with-collections-detach_products></a>detach_products
#### detach collection products renders collection and its products when data is valid

##### Request
* __Method:__ DELETE
* __Path:__ /api/v1/collections/1/products
* __Request headers:__
```
accept: application/json
authorization: muaBar41sridprxIdtGyBXEpprf44f2hqryOwGNOR4U
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "product_ids": [
    1
  ]
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:43 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlLW6296rCk4AABMi
```
* __Response body:__
```json
{
  "display_order": 1,
  "id": 1,
  "images": [],
  "name": "some name4867",
  "products": [],
  "products_count": 0,
  "slug": "some-name4867"
}
```

### <a id=working-with-collections-sort_collections></a>sort_collections
#### "collection_ids" sorted array of collection ids

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/collections/sort
* __Request headers:__
```
accept: application/json
authorization: 0ZUybvo47_kPWsNv2O6Sjqq3ze3rSaZoR4bAaKiwwzA
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "collection_ids": [
    3,
    1,
    2
  ]
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:43 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlMKvI_d4pCIAABYG
```
* __Response body:__
```json
{
  "data": [
    {
      "display_order": 1,
      "id": 3,
      "images": [],
      "name": "some name5607",
      "products_count": 0,
      "slug": "some-name5607"
    },
    {
      "display_order": 2,
      "id": 1,
      "images": [],
      "name": "some name5543",
      "products_count": 0,
      "slug": "some-name5543"
    },
    {
      "display_order": 3,
      "id": 2,
      "images": [],
      "name": "some name5575",
      "products_count": 0,
      "slug": "some-name5575"
    }
  ]
}
```

## Working with Products
### <a id=working-with-products-index></a>index
#### index lists all products

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products
* __Request headers:__
```
accept: application/json
authorization: FIlDBiKGBOEOAOiJv9TRqGYUhIWkRu_AgLbZguqVXGo
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:40 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk-eJ19b79NAAAA5G
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

#### Products pagination

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products?page_size=2
* __Request headers:__
```
accept: application/json
authorization: 9IkoQx1_woJIwr6W1K1yoImpBhEEF-5sBVmvTFOxfag
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:42 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlHLtA0a8XfUAABKG
```
* __Response body:__
```json
{
  "data": [
    {
      "description": "some description",
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png"
      ],
      "name": "some name",
      "slug": "some-name",
      "total_quantity": 84,
      "variant_count": 2,
      "variants_name": "variants",
      "visibility": "visible"
    },
    {
      "description": "some description",
      "id": 2,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png"
      ],
      "name": "some name",
      "slug": "some-name-1",
      "total_quantity": 84,
      "variant_count": 2,
      "variants_name": "variants",
      "visibility": "visible"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": 2,
    "page_size": 2,
    "previous_page": null,
    "total_count": 4,
    "total_pages": 2
  }
}
```

#### Filtering by name with some results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products?filters[0][field]=name&filters[0][op]=ilike&filters[0][value]=some
* __Request headers:__
```
accept: application/json
authorization: Quz2oplu774d0CrtrPuDgIx39LY79vhaU1oMOX13LuE
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:42 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlFgSx7p_tFEAABph
```
* __Response body:__
```json
{
  "data": [
    {
      "description": "some description",
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png"
      ],
      "name": "some name",
      "slug": "some-name",
      "total_quantity": 84,
      "variant_count": 2,
      "variants_name": "variants",
      "visibility": "visible"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Filtering by name with no results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products?filters[0][field]=name&filters[0][value]=nothing
* __Request headers:__
```
accept: application/json
authorization: lXyGTUa4bbzMPJnLTU6gUdDF0OA3LmGGw4DmsxDcYdM
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:40 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlBJEd8I-unUAAA4i
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

#### Filtering by collection count with some results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products?filters[0][field]=collection_count&filters[0][value]=0
* __Request headers:__
```
accept: application/json
authorization: AR6YUJP31zkRsS6iMlVoGR3imyDUejNRLpg1-8TpCJI
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:40 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk_ZkXp02mZ0AAA_H
```
* __Response body:__
```json
{
  "data": [
    {
      "description": "some description",
      "id": 1,
      "images": [
        "https://vatrin-dev.s3.amazonaws.com/image1.png"
      ],
      "name": "some name",
      "slug": "some-name",
      "total_quantity": 84,
      "variant_count": 2,
      "variants_name": "variants",
      "visibility": "visible"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Filtering by collection count with no results

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products?filters[0][field]=collection_count&filters[0][value]=1
* __Request headers:__
```
accept: application/json
authorization: zuSu_ONGZdGVoAAdQpS20DZU1g1YtuMtofrSodlJ3Aw
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:41 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlEqRV48z1WwAABEH
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

### <a id=working-with-products-create></a>create
#### create product renders product when data is valid

##### Request
* __Method:__ POST
* __Path:__ /api/v1/products
* __Request headers:__
```
accept: application/json
authorization: Ea7Qu8Qudjlm7CLEgwUWikhs2uB1DDxxgAINUemOFEY
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "addons": [
    {
      "name": "Napkins",
      "options": [
        {
          "name": "Yes",
          "price": 0
        },
        {
          "name": "No",
          "price": 0
        }
      ],
      "required": false,
      "type": "one"
    }
  ],
  "description": "product description",
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/placeholder.png",
    "https://vatrin-dev.s3.amazonaws.com/placeholder2.png"
  ],
  "name": "product name",
  "variants": [
    {
      "always_available": false,
      "name": "regular",
      "price": 42.0,
      "quantity": 42,
      "reduced_price": 39.0,
      "sku": "VATRIN_PRODUCT_SKU"
    },
    {
      "name": "large",
      "price": 42.0,
      "quantity": 7,
      "reduced_price": 40.0,
      "sku": "VATRIN_PRODUCT_LARGE_SKU"
    }
  ],
  "variants_name": "size",
  "visibility": "visible"
}
```

##### Response
* __Status__: 201
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:40 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk9kPd_hSEekAAA7H
location: /api/v1/products/1
```
* __Response body:__
```json
{
  "addons": [
    {
      "id": 1,
      "max_order": 1,
      "min_order": 1,
      "name": "Napkins",
      "options": [
        {
          "display_order": null,
          "id": "228e4947-4a85-445c-bf7b-2e0bdf5da5df",
          "max_order": 1,
          "name": "Yes",
          "price": "0",
          "sku": null
        },
        {
          "display_order": null,
          "id": "0922ce6e-3366-45fd-be87-4b1acde546ad",
          "max_order": 1,
          "name": "No",
          "price": "0",
          "sku": null
        }
      ],
      "required": false,
      "type": "one"
    }
  ],
  "always_available": false,
  "collections": [],
  "description": "product description",
  "id": 1,
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/placeholder.png",
    "https://vatrin-dev.s3.amazonaws.com/placeholder2.png"
  ],
  "name": "product name",
  "slug": "product-name",
  "total_quantity": 49,
  "variant_count": 2,
  "variants": [
    {
      "always_available": false,
      "id": 1,
      "name": "regular",
      "price": "42.0",
      "quantity": 42,
      "reduced_price": "39.0",
      "sku": "VATRIN_PRODUCT_SKU"
    },
    {
      "always_available": null,
      "id": 2,
      "name": "large",
      "price": "42.0",
      "quantity": 7,
      "reduced_price": "40.0",
      "sku": "VATRIN_PRODUCT_LARGE_SKU"
    }
  ],
  "variants_name": "size",
  "visibility": "visible"
}
```

### <a id=working-with-products-show></a>show
#### create product renders product when data is valid

##### Request
* __Method:__ GET
* __Path:__ /api/v1/products/1
* __Request headers:__
```
accept: application/json
authorization: Ea7Qu8Qudjlm7CLEgwUWikhs2uB1DDxxgAINUemOFEY
cookie: locale=en
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:40 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk9m1p-pSEekAAA7n
```
* __Response body:__
```json
{
  "addons": [
    {
      "id": 1,
      "max_order": 1,
      "min_order": 1,
      "name": "Napkins",
      "options": [
        {
          "display_order": null,
          "id": "228e4947-4a85-445c-bf7b-2e0bdf5da5df",
          "max_order": 1,
          "name": "Yes",
          "price": "0",
          "sku": null
        },
        {
          "display_order": null,
          "id": "0922ce6e-3366-45fd-be87-4b1acde546ad",
          "max_order": 1,
          "name": "No",
          "price": "0",
          "sku": null
        }
      ],
      "required": false,
      "type": "one"
    }
  ],
  "always_available": false,
  "collections": [],
  "description": "product description",
  "id": 1,
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/placeholder.png",
    "https://vatrin-dev.s3.amazonaws.com/placeholder2.png"
  ],
  "name": "product name",
  "slug": "product-name",
  "total_quantity": 49,
  "variant_count": 2,
  "variants": [
    {
      "always_available": false,
      "id": 1,
      "name": "regular",
      "price": "42.00",
      "quantity": 42,
      "reduced_price": "39.00",
      "sku": "VATRIN_PRODUCT_SKU"
    },
    {
      "always_available": false,
      "id": 2,
      "name": "large",
      "price": "42.00",
      "quantity": 7,
      "reduced_price": "40.00",
      "sku": "VATRIN_PRODUCT_LARGE_SKU"
    }
  ],
  "variants_name": "size",
  "visibility": "visible"
}
```

### <a id=working-with-products-create></a>create
#### Not providing a product name

##### Request
* __Method:__ POST
* __Path:__ /api/v1/products
* __Request headers:__
```
accept: application/json
authorization: 3XwjXRK1hccrlTnTv-zB4MHCdnWABBkqPbHXp6He9WA
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:41 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlB7tZnhq654AABjh
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ],
    "variants": [
      "can't be blank"
    ]
  }
}
```

#### Free plan product limit reached

##### Request
* __Method:__ POST
* __Path:__ /api/v1/products
* __Request headers:__
```
accept: application/json
authorization: KFAeKuHOteUAvjyXttwaWZ_AoOPcfADvyYHFm7rHtx8
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "addons": [
    {
      "name": "Napkins",
      "options": [
        {
          "name": "Yes",
          "price": 0
        },
        {
          "name": "No",
          "price": 0
        }
      ],
      "required": false,
      "type": "one"
    }
  ],
  "description": "product description",
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/placeholder.png",
    "https://vatrin-dev.s3.amazonaws.com/placeholder2.png"
  ],
  "name": "product name",
  "variants": [
    {
      "always_available": false,
      "name": "regular",
      "price": 42.0,
      "quantity": 42,
      "reduced_price": 39.0,
      "sku": "VATRIN_PRODUCT_SKU"
    },
    {
      "name": "large",
      "price": 42.0,
      "quantity": 7,
      "reduced_price": 40.0,
      "sku": "VATRIN_PRODUCT_LARGE_SKU"
    }
  ],
  "variants_name": "size",
  "visibility": "visible"
}
```

##### Response
* __Status__: 402
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:41 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlDC9K71SiXoAABkh
```
* __Response body:__
```json
{
  "errors": {
    "contact_phone_number": "+201102536843",
    "detail": "Products Limit Reached",
    "payment_link": "http://localhost:4002/en/billing/upgrade?plan_code=premium&store_name=some+store+name&phone_number=%2B201114298504"
  }
}
```

### <a id=working-with-products-update></a>update
#### update product renders product when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/products/1
* __Request headers:__
```
accept: application/json
authorization: 0ZkD0f4jqu3jAu1Um3xAh5nnMYxZt0sUur-jQ7nhiN8
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "description": "some updated description",
  "name": "some updated name"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:42 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlGUcwYkSq-8AABEC
```
* __Response body:__
```json
{
  "addons": [
    {
      "id": 1,
      "max_order": 1,
      "min_order": 1,
      "name": "some addon",
      "options": [
        {
          "display_order": null,
          "id": "e1102e6a-ef7e-40ca-a47a-72c17a8aa2a8",
          "max_order": 1,
          "name": "some option",
          "price": "0",
          "sku": null
        },
        {
          "display_order": null,
          "id": "35da89ee-ec03-4513-8b39-79a37666ea84",
          "max_order": 1,
          "name": "some other option",
          "price": "0",
          "sku": null
        }
      ],
      "required": false,
      "type": "one"
    },
    {
      "id": 2,
      "max_order": 1,
      "min_order": 1,
      "name": "some other addon",
      "options": [
        {
          "display_order": null,
          "id": "adcd0f97-a96d-466f-bafd-a405a7ebee72",
          "max_order": 1,
          "name": "some option",
          "price": "0",
          "sku": null
        },
        {
          "display_order": null,
          "id": "d5be48b0-2a96-4979-9673-bfa0e1e84536",
          "max_order": 1,
          "name": "some other option",
          "price": "0",
          "sku": null
        }
      ],
      "required": false,
      "type": "many"
    }
  ],
  "always_available": false,
  "collections": [],
  "description": "some updated description",
  "id": 1,
  "images": [
    "https://vatrin-dev.s3.amazonaws.com/image1.png",
    "https://vatrin-dev.s3.amazonaws.com/image2.png"
  ],
  "name": "some updated name",
  "slug": "some-updated-name",
  "total_quantity": 84,
  "variant_count": 2,
  "variants": [
    {
      "always_available": false,
      "id": 1,
      "name": "regular",
      "price": "42.00",
      "quantity": 42,
      "reduced_price": null,
      "sku": null
    },
    {
      "always_available": false,
      "id": 2,
      "name": "large",
      "price": "42.00",
      "quantity": 42,
      "reduced_price": null,
      "sku": null
    }
  ],
  "variants_name": "variants",
  "visibility": "visible"
}
```

#### update product renders errors when data is invalid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/products/1
* __Request headers:__
```
accept: application/json
authorization: i9EnNs3pXM21e8eInmiaIpSESmM4MQWz0rdcBi5PAdQ
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "name": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:41 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlD3jKw1pEcYAABAG
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ]
  }
}
```

### <a id=working-with-products-delete></a>delete
#### delete product deletes chosen product

##### Request
* __Method:__ DELETE
* __Path:__ /api/v1/products/1
* __Request headers:__
```
accept: application/json
authorization: 4Q-949Mr2NeIWUxN5ccz-dWeXidFCju1Q-7F2_NLCSY
```

##### Response
* __Status__: 204
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:40 GMT; max-age=864000; HttpOnly
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlALwuWhGs44AABgh
```
* __Response body:__
```json

```

## Working with Orders
### <a id=working-with-orders-index></a>index
#### index lists all orders

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders
* __Request headers:__
```
accept: application/json
authorization: nHh10dSzdqsyKhonPQM_WSVS7wZl8Dwk8SjxwKMMWX0
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:36 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkw2aF6_c1FcAAAen
```
* __Response body:__
```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 0,
    "total_pages": 0
  }
}
```

#### Orders pagination

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders?page_size=2
* __Request headers:__
```
accept: application/json
authorization: wryfa4qYEBLWQjjH-PVFctpQdCQ590IpUC40GXUvZBk
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk6NWjJJYI44AAAvG
```
* __Response body:__
```json
{
  "data": [
    {
      "confirmation_code": "4-916",
      "customer": {
        "additional_notes": "some additional_notes",
        "address": {
          "city": null,
          "street_address": null
        },
        "name": "some name",
        "phone_number": "+201113214041"
      },
      "customer_id": 4,
      "delivery_fees": "120.50",
      "fulfillment_type": "delivery",
      "id": 4,
      "inserted_at": "2023-09-26T11:50:39",
      "line_items": [
        {
          "additional_notes": null,
          "addons": [],
          "id": 4,
          "price": "42.00",
          "product_data": {
            "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
            "product_name": "some name",
            "variant_name": "regular"
          },
          "quantity": 1,
          "status": "pending"
        }
      ],
      "payment_method": "cod",
      "payment_status": "pending",
      "status": "pending",
      "subtotal_price": "42.00",
      "type": "manual",
      "updated_at": "2023-09-26T11:50:39"
    },
    {
      "confirmation_code": "3-953",
      "customer": {
        "additional_notes": "some additional_notes",
        "address": {
          "city": null,
          "street_address": null
        },
        "name": "some name",
        "phone_number": "+201114115652"
      },
      "customer_id": 3,
      "delivery_fees": "120.50",
      "fulfillment_type": "delivery",
      "id": 3,
      "inserted_at": "2023-09-26T11:50:39",
      "line_items": [
        {
          "additional_notes": null,
          "addons": [],
          "id": 3,
          "price": "42.00",
          "product_data": {
            "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
            "product_name": "some name",
            "variant_name": "regular"
          },
          "quantity": 1,
          "status": "pending"
        }
      ],
      "payment_method": "cod",
      "payment_status": "pending",
      "status": "pending",
      "subtotal_price": "42.00",
      "type": "manual",
      "updated_at": "2023-09-26T11:50:39"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": 2,
    "page_size": 2,
    "previous_page": null,
    "total_count": 4,
    "total_pages": 2
  }
}
```

#### Filtering by status with some results. Supported statuses: "pending", "fulfilled" and "canceled".

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders?filters[0][field]=status&filters[0][value]=canceled
* __Request headers:__
```
accept: application/json
authorization: LUsmdlYO6rbN1_dw7RyYEBt5OyqxJU64-rpq1AapsLk
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:38 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk4akL00etKQAABKB
```
* __Response body:__
```json
{
  "data": [
    {
      "confirmation_code": "1-858",
      "customer": {
        "additional_notes": "some additional_notes",
        "address": {
          "city": null,
          "street_address": null
        },
        "name": "some name",
        "phone_number": "+201113744572"
      },
      "customer_id": 1,
      "delivery_fees": "120.50",
      "fulfillment_type": "delivery",
      "id": 1,
      "inserted_at": "2023-09-26T11:50:38",
      "line_items": [
        {
          "additional_notes": null,
          "addons": [],
          "id": 1,
          "price": "42.00",
          "product_data": {
            "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
            "product_name": "some name",
            "variant_name": "regular"
          },
          "quantity": 1,
          "status": "canceled"
        }
      ],
      "payment_method": "cod",
      "payment_status": "pending",
      "status": "canceled",
      "subtotal_price": "42.00",
      "type": "manual",
      "updated_at": "2023-09-26T11:50:38"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Filtering by payment status with some results. Supported statuses: "pending" and "paid".

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders?filters[0][field]=payment_status&filters[0][value]=paid
* __Request headers:__
```
accept: application/json
authorization: EV57gzeCSBFxlS_IL8b1DzbPU9tBnYunN3cEjFYJEgo
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:37 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkzZ2wtafq7sAAA-h
```
* __Response body:__
```json
{
  "data": [
    {
      "confirmation_code": "1-358",
      "customer": {
        "additional_notes": "some additional_notes",
        "address": {
          "city": null,
          "street_address": null
        },
        "name": "some name",
        "phone_number": "+201114919419"
      },
      "customer_id": 1,
      "delivery_fees": "120.50",
      "fulfillment_type": "delivery",
      "id": 1,
      "inserted_at": "2023-09-26T11:50:37",
      "line_items": [
        {
          "additional_notes": null,
          "addons": [],
          "id": 1,
          "price": "42.00",
          "product_data": {
            "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
            "product_name": "some name",
            "variant_name": "regular"
          },
          "quantity": 1,
          "status": "pending"
        }
      ],
      "payment_method": "cod",
      "payment_status": "paid",
      "status": "pending",
      "subtotal_price": "42.00",
      "type": "manual",
      "updated_at": "2023-09-26T11:50:37"
    }
  ],
  "meta": {
    "current_page": 1,
    "next_page": null,
    "page_size": 25,
    "previous_page": null,
    "total_count": 1,
    "total_pages": 1
  }
}
```

#### Orders pagination with invalid page size

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders?page_size=invalid
* __Request headers:__
```
accept: application/json
authorization: WwZG5FMVkhl54f_amRHbVC45Gidh9ZYtrPqYNGbrE2g
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:36 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkxsCzHlYelIAAAhn
```
* __Response body:__
```json
{
  "errors": {
    "page_size": [
      "is invalid"
    ]
  }
}
```

#### Orders filtering with invalid operator

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders?filters[0][field]=status&filters[0][value]=fulfilled&filters[0][op]=ilike
* __Request headers:__
```
accept: application/json
authorization: GoTWKeiY1W1ZUhKWqDi0G4OZYVJTEyCYVRFerUWx5iw
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:38 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk3js_wtkbTYAAAuC
```
* __Response body:__
```json
{
  "errors": {
    "filters": [
      {
        "op": [
          "is invalid"
        ]
      }
    ]
  }
}
```

### <a id=working-with-orders-create></a>create
#### create order renders order when data is valid

##### Request
* __Method:__ POST
* __Path:__ /api/v1/orders
* __Request headers:__
```
accept: application/json
authorization: WKugc837NjLtSRW6F9tvvpjascO_GLsTAN7bH5OwYJ0
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "customer_id": 1,
  "delivery_fees": 15,
  "line_items": [
    {
      "addons": [
        {
          "addon_id": 1,
          "option_id": "b419b5ba-cd4e-4788-8e47-656677a6a3e7",
          "quantity": 1
        }
      ],
      "quantity": 2,
      "variant_id": 1
    }
  ]
}
```

##### Response
* __Status__: 201
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:36 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkv9-Ge3Z6RAAAAem
location: /api/v1/orders/1
```
* __Response body:__
```json
{
  "confirmation_code": "1-384",
  "customer": {
    "additional_notes": "some additional_notes",
    "address": {
      "city": null,
      "street_address": null
    },
    "name": "some name",
    "phone_number": "+201111345179"
  },
  "customer_id": 1,
  "delivery_fees": "15",
  "fulfillment_type": "delivery",
  "id": 1,
  "inserted_at": "2023-09-26T11:50:36",
  "line_items": [
    {
      "additional_notes": null,
      "addons": [
        {
          "addon_name": "some addon",
          "option_name": "some option",
          "price": "0",
          "quantity": 1,
          "sku": null
        }
      ],
      "id": 1,
      "price": "42.00",
      "product_data": {
        "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "product_name": "some name",
        "variant_name": "regular"
      },
      "quantity": 2,
      "status": "pending"
    }
  ],
  "payment_method": "cod",
  "payment_status": "pending",
  "status": "pending",
  "subtotal_price": "84.00",
  "type": "manual",
  "updated_at": "2023-09-26T11:50:36"
}
```

### <a id=working-with-orders-show></a>show
#### create order renders order when data is valid

##### Request
* __Method:__ GET
* __Path:__ /api/v1/orders/1
* __Request headers:__
```
accept: application/json
authorization: WKugc837NjLtSRW6F9tvvpjascO_GLsTAN7bH5OwYJ0
cookie: locale=en
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:36 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkwDbsLjZ6RAAAAfp
```
* __Response body:__
```json
{
  "confirmation_code": "1-384",
  "customer": {
    "additional_notes": "some additional_notes",
    "address": {
      "city": null,
      "street_address": null
    },
    "name": "some name",
    "phone_number": "+201111345179"
  },
  "customer_id": 1,
  "delivery_fees": "15.00",
  "fulfillment_type": "delivery",
  "id": 1,
  "inserted_at": "2023-09-26T11:50:36",
  "line_items": [
    {
      "additional_notes": null,
      "addons": [
        {
          "addon_name": "some addon",
          "option_name": "some option",
          "price": "0",
          "quantity": 1,
          "sku": null
        }
      ],
      "id": 1,
      "price": "42.00",
      "product_data": {
        "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "product_name": "some name",
        "variant_name": "regular"
      },
      "quantity": 2,
      "status": "pending"
    }
  ],
  "payment_method": "cod",
  "payment_status": "pending",
  "status": "pending",
  "subtotal_price": "84.00",
  "type": "manual",
  "updated_at": "2023-09-26T11:50:36"
}
```

### <a id=working-with-orders-create></a>create
#### Invalid order attributes

##### Request
* __Method:__ POST
* __Path:__ /api/v1/orders
* __Request headers:__
```
accept: application/json
authorization: r_rwYloRB9af6o0wYa1oCHq5wEW8fOUaH9SqsbZMt40
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "customer_id": 1,
  "line_items": [
    {
      "product_id": 1
    }
  ]
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:37 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk1H6ew-QUvIAAArG
```
* __Response body:__
```json
{
  "errors": {
    "line_items": [
      {
        "price": [
          "can't be blank"
        ],
        "product_data": [
          "can't be blank"
        ],
        "quantity": [
          "can't be blank"
        ],
        "variant_id": [
          "can't be blank"
        ]
      }
    ]
  }
}
```

#### Invalid order attributes, duplicate line items

##### Request
* __Method:__ POST
* __Path:__ /api/v1/orders
* __Request headers:__
```
accept: application/json
authorization: hVkxAYfMR6xVn_EC6LxGvKOggx9V6br3m1WIBNs8kwc
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "customer_id": 1,
  "delivery_fees": 15,
  "line_items": [
    {
      "addons": [
        {
          "addon_id": 1,
          "option_id": "428541f4-4814-4747-a09f-64c7344c5a9e",
          "quantity": 1
        },
        {
          "addon_id": 2,
          "option_id": "4808f499-ecac-4113-b442-496b52079bbc",
          "quantity": 1
        }
      ],
      "quantity": 1,
      "variant_id": 1
    },
    {
      "addons": [
        {
          "addon_id": 2,
          "option_id": "4808f499-ecac-4113-b442-496b52079bbc",
          "quantity": 1
        },
        {
          "addon_id": 1,
          "option_id": "428541f4-4814-4747-a09f-64c7344c5a9e",
          "quantity": 1
        }
      ],
      "quantity": 2,
      "variant_id": 1
    }
  ]
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:38 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk5MdP8hqyg4AABOh
```
* __Response body:__
```json
{
  "errors": {
    "line_items": [
      "line_items must be unique"
    ]
  }
}
```

#### Invalid order attributes, duplicate line items

##### Request
* __Method:__ POST
* __Path:__ /api/v1/orders
* __Request headers:__
```
accept: application/json
authorization: hVkxAYfMR6xVn_EC6LxGvKOggx9V6br3m1WIBNs8kwc
cookie: locale=en
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "customer_id": 1,
  "delivery_fees": 15,
  "line_items": [
    {
      "addons": [
        {
          "addon_id": 1,
          "option_id": "428541f4-4814-4747-a09f-64c7344c5a9e",
          "quantity": 1
        },
        {
          "addon_id": 1,
          "option_id": "91a8fa3e-d0d1-4ab7-9137-3b41d200740c",
          "quantity": 1
        }
      ],
      "quantity": 1,
      "variant_id": 1
    },
    {
      "addons": [
        {
          "addon_id": 1,
          "option_id": "91a8fa3e-d0d1-4ab7-9137-3b41d200740c",
          "quantity": 1
        },
        {
          "addon_id": 1,
          "option_id": "428541f4-4814-4747-a09f-64c7344c5a9e",
          "quantity": 1
        }
      ],
      "quantity": 2,
      "variant_id": 1
    }
  ]
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:38 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk5NwZRlqyg4AABPB
```
* __Response body:__
```json
{
  "errors": {
    "line_items": [
      "line_items must be unique"
    ]
  }
}
```

### <a id=working-with-orders-fulfill></a>fulfill
#### fulfill order renders order when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/orders/1/fulfill
* __Request headers:__
```
accept: application/json
authorization: Gns8C2lWjlZ0wN7eeIipWE1L_tRgxx7AHajsjXrLhLY
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:38 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk2xovAelTi4AAAqH
```
* __Response body:__
```json
{
  "confirmation_code": "1-123",
  "customer": {
    "additional_notes": "some additional_notes",
    "address": {
      "city": null,
      "street_address": null
    },
    "name": "some name",
    "phone_number": "+201116901204"
  },
  "customer_id": 1,
  "delivery_fees": "120.50",
  "fulfillment_type": "delivery",
  "id": 1,
  "inserted_at": "2023-09-26T11:50:38",
  "line_items": [
    {
      "additional_notes": null,
      "addons": [],
      "id": 1,
      "price": "42.00",
      "product_data": {
        "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "product_name": "some name",
        "variant_name": "regular"
      },
      "quantity": 1,
      "status": "fulfilled"
    }
  ],
  "payment_method": "cod",
  "payment_status": "pending",
  "status": "fulfilled",
  "subtotal_price": "42.00",
  "type": "manual",
  "updated_at": "2023-09-26T11:50:38"
}
```

### <a id=working-with-orders-cancel></a>cancel
#### cancel order renders order when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/orders/1/cancel
* __Request headers:__
```
accept: application/json
authorization: yXDGpncmq8xhT7Se0ncrsvB7HmHGxIGjKGgqEyaWrQo
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:37 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkyhKqBRLCDcAAAhi
```
* __Response body:__
```json
{
  "confirmation_code": "1-727",
  "customer": {
    "additional_notes": "some additional_notes",
    "address": {
      "city": null,
      "street_address": null
    },
    "name": "some name",
    "phone_number": "+201113838284"
  },
  "customer_id": 1,
  "delivery_fees": "120.50",
  "fulfillment_type": "delivery",
  "id": 1,
  "inserted_at": "2023-09-26T11:50:37",
  "line_items": [
    {
      "additional_notes": null,
      "addons": [],
      "id": 1,
      "price": "42.00",
      "product_data": {
        "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "product_name": "some name",
        "variant_name": "regular"
      },
      "quantity": 1,
      "status": "canceled"
    }
  ],
  "payment_method": "cod",
  "payment_status": "pending",
  "status": "canceled",
  "subtotal_price": "42.00",
  "type": "manual",
  "updated_at": "2023-09-26T11:50:37"
}
```

### <a id=working-with-orders-mark_as_paid></a>mark_as_paid
#### mark order as paid renders order when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/orders/1/mark-as-paid
* __Request headers:__
```
accept: application/json
authorization: QSOf5grBIiWGqc-C-dmDU9ydNZj5DRvpW4hgPRUUPsE
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:37 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk1796zS7Mh8AAAmn
```
* __Response body:__
```json
{
  "confirmation_code": "1-969",
  "customer": {
    "additional_notes": "some additional_notes",
    "address": {
      "city": null,
      "street_address": null
    },
    "name": "some name",
    "phone_number": "+201114494550"
  },
  "customer_id": 1,
  "delivery_fees": "120.50",
  "fulfillment_type": "delivery",
  "id": 1,
  "inserted_at": "2023-09-26T11:50:37",
  "line_items": [
    {
      "additional_notes": null,
      "addons": [],
      "id": 1,
      "price": "42.00",
      "product_data": {
        "image": "https://vatrin-dev.s3.amazonaws.com/image1.png",
        "product_name": "some name",
        "variant_name": "regular"
      },
      "quantity": 1,
      "status": "pending"
    }
  ],
  "payment_method": "cod",
  "payment_status": "paid",
  "status": "pending",
  "subtotal_price": "42.00",
  "type": "manual",
  "updated_at": "2023-09-26T11:50:37"
}
```

## Fetching Statistics
### <a id=fetching-statistics-index></a>index
#### Supported periods are "today", "yesterday", "week" and "month" and defaults to "today".
Possible "trend" values are "up", "down" and "sideways".


##### Request
* __Method:__ GET
* __Path:__ /api/v1/stats?period=today
* __Request headers:__
```
accept: application/json
authorization: m1rQLSKC1TkZiZIDkWv9n6rO6FZC4MGuKcYpoQkEEsc
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:47 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwlaDuRqS8lfsAAB3G
```
* __Response body:__
```json
{
  "orders": {
    "orders_count": 0,
    "total_sales": "0",
    "variance": {
      "orders_count": {
        "percent": "0%",
        "trend": "sideways"
      },
      "total_sales": {
        "percent": "0%",
        "trend": "sideways"
      }
    }
  },
  "products": {
    "products_count": 0
  }
}
```

#### Providing invalid period

##### Request
* __Method:__ GET
* __Path:__ /api/v1/stats?period=year
* __Request headers:__
```
accept: application/json
authorization: sHt_0GEwM-AWjyYRtfH_wRxiLcNGNZ8zoMQKXzYyqMU
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:47 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwla2LasxI1tgAABlH
```
* __Response body:__
```json
{
  "errors": {
    "detail": "invalid period \"year\""
  }
}
```

## Getting Store Slug Suggestions
### <a id=getting-store-slug-suggestions-suggest_slugs></a>suggest_slugs
#### Slug suggestions using name

##### Request
* __Method:__ GET
* __Path:__ /api/v1/store/slug-suggestions?name=some+name
* __Request headers:__
```
accept: application/json
authorization: l1bimlISWYmIr9iJZapfOn8pyT4VxxLc7mhMwOP60xA
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk79kiKBMsAwAABZB
```
* __Response body:__
```json
{
  "error": null,
  "suggestions": [
    "some-name"
  ],
  "valid": true
}
```

#### Slug suggestions using slug

##### Request
* __Method:__ GET
* __Path:__ /api/v1/store/slug-suggestions?slug=some-slug
* __Request headers:__
```
accept: application/json
authorization: OByl3_lhvk7OiIp9S_59jFbQGyI6B03_QAuw2ihq5Vw
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk80ns8etzwUAAA1m
```
* __Response body:__
```json
{
  "error": null,
  "suggestions": [
    "some-slug"
  ],
  "valid": true
}
```

#### Slug suggestions when name and slug are provided (ignores name)

##### Request
* __Method:__ GET
* __Path:__ /api/v1/store/slug-suggestions?name=ignored&slug=some-slug
* __Request headers:__
```
accept: application/json
authorization: No6Pi9HUIUKBUsF4HRv2ayjc7ec9_sdrmaGmt14YSnY
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk8zf1Ve0Q5QAAA1G
```
* __Response body:__
```json
{
  "error": null,
  "suggestions": [
    "some-slug"
  ],
  "valid": true
}
```

#### Slug suggestion for duplicate slug

##### Request
* __Method:__ GET
* __Path:__ /api/v1/store/slug-suggestions?slug=some-duplicate-slug
* __Request headers:__
```
accept: application/json
authorization: 4UXJqX-h1oEreuFudgh-es3FIwDkKSMQVLz0MZdVEqQ
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk8wbuEOo5JIAABbB
```
* __Response body:__
```json
{
  "error": "has already been taken",
  "suggestions": [
    "some-duplicate-slug-1"
  ],
  "valid": false
}
```

#### Not providing a name or a slug

##### Request
* __Method:__ GET
* __Path:__ /api/v1/store/slug-suggestions
* __Request headers:__
```
accept: application/json
authorization: UZZt83h6fGvOLJVOteKGoPnOh55fTrPd9DrsReEQEkM
```

##### Response
* __Status__: 400
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk7_E8cehQnMAABZh
```
* __Response body:__
```json
{
  "errors": {
    "detail": "Either \"name\" or \"slug\" should be provided."
  }
}
```

## Working with Stores
### <a id=working-with-stores-create></a>create
#### create store renders store when data is valid

##### Request
* __Method:__ POST
* __Path:__ /api/v1/stores
* __Request headers:__
```
accept: application/json
authorization: MwyHXszQvTbx0W2rPDBysaRilTrJlmc6UPlDmpTwvR8
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "industry": "retail",
  "store_name": "some name"
}
```

##### Response
* __Status__: 201
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:34 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkpXNYZUrlbMAAArB
location: /api/v1/stores/75173
```
* __Response body:__
```json
{
  "address": {
    "city": null,
    "country": "Egypt",
    "country_code": "EG",
    "street_address": null
  },
  "contact_phone_number": "+201102536843",
  "delivery_areas": [],
  "id": 75173,
  "industry": "retail",
  "logo": "https://vatrin-dev.s3.amazonaws.com/placeholders/logo-placeholder.png",
  "phone_number": "+201113468112",
  "shareable_link": "https://dev.vatrin.app/some-name?shared=true",
  "slug": "some-name",
  "social_links": {},
  "store_link": "https://dev.vatrin.app/some-name",
  "store_name": "some name",
  "store_policy": null,
  "subscription": {
    "currency": "EGP",
    "customer_id": "vatrex_test_some-name",
    "has_active_paid_plan": false,
    "last_bill_date": null,
    "next_bill_date": null,
    "payment_link": "http://localhost:4002/en/billing/upgrade?plan_code=premium&store_name=some+name&phone_number=%2B201113468112",
    "plan": "free",
    "price": "0",
    "status": "active"
  }
}
```

#### Specifying a slug

##### Request
* __Method:__ POST
* __Path:__ /api/v1/stores
* __Request headers:__
```
accept: application/json
authorization: Oai_BJQqYTH1ocZsmo_n8EWY606et7Nxkh2sumuz1eo
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "industry": "retail",
  "slug": "some-slug",
  "store_name": "some name"
}
```

##### Response
* __Status__: 201
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:36 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkuc7r2QdOgkAAA2B
location: /api/v1/stores/75179
```
* __Response body:__
```json
{
  "address": {
    "city": null,
    "country": "Egypt",
    "country_code": "EG",
    "street_address": null
  },
  "contact_phone_number": "+201102536843",
  "delivery_areas": [],
  "id": 75179,
  "industry": "retail",
  "logo": "https://vatrin-dev.s3.amazonaws.com/placeholders/logo-placeholder.png",
  "phone_number": "+201113184864",
  "shareable_link": "https://dev.vatrin.app/some-slug?shared=true",
  "slug": "some-slug",
  "social_links": {},
  "store_link": "https://dev.vatrin.app/some-slug",
  "store_name": "some name",
  "store_policy": null,
  "subscription": {
    "currency": "EGP",
    "customer_id": "vatrex_test_some-slug",
    "has_active_paid_plan": false,
    "last_bill_date": null,
    "next_bill_date": null,
    "payment_link": "http://localhost:4002/en/billing/upgrade?plan_code=premium&store_name=some+name&phone_number=%2B201113184864",
    "plan": "free",
    "price": "0",
    "status": "active"
  }
}
```

#### Not providing a store name nor industry

##### Request
* __Method:__ POST
* __Path:__ /api/v1/stores
* __Request headers:__
```
accept: application/json
authorization: Qn-NCBjAbySLhsG4g70IvqS3rlAwH6Rsnp0w3wCxukU
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "industry": null,
  "store_name": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwktihe2mfjzYAAAzh
```
* __Response body:__
```json
{
  "errors": {
    "industry": [
      "can't be blank"
    ],
    "name": [
      "can't be blank"
    ]
  }
}
```

#### Providing an invalid slug format

##### Request
* __Method:__ POST
* __Path:__ /api/v1/stores
* __Request headers:__
```
accept: application/json
authorization: D-EDz4v90GUrxAhh8KqzQBJ737j50nh4gkxXq8aNBpw
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "industry": "retail",
  "slug": "invalid slug",
  "store_name": "some name"
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkrAyF9gMiMYAAAUG
```
* __Response body:__
```json
{
  "errors": {
    "slug": [
      "must only contain lowercase letters and numbers separated by hyphens"
    ],
    "tenant_id": [
      "must only contain lowercase letters and numbers separated by hyphens"
    ]
  }
}
```

### <a id=working-with-stores-show></a>show
#### show store renders store giving valid slug

##### Request
* __Method:__ GET
* __Path:__ /api/v1/stores/some-name
* __Request headers:__
```
accept: application/json
authorization: aVHFwMRk8IqIUxbBrLCshvNk28OD9x8RwL_oWzXHj10
cookie: locale=en
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkq9xAF1PG-gAAATm
```
* __Response body:__
```json
{
  "address": {
    "city": null,
    "country": "Egypt",
    "country_code": "EG",
    "street_address": null
  },
  "contact_phone_number": "+201102536843",
  "delivery_areas": [],
  "id": 75174,
  "industry": "retail",
  "logo": "https://vatrin-dev.s3.amazonaws.com/placeholders/logo-placeholder.png",
  "phone_number": "+201117432982",
  "shareable_link": "https://dev.vatrin.app/some-name?shared=true",
  "slug": "some-name",
  "social_links": {},
  "store_link": "https://dev.vatrin.app/some-name",
  "store_name": "some name",
  "store_policy": null,
  "subscription": {
    "currency": "EGP",
    "customer_id": "vatrex_test_some-name",
    "has_active_paid_plan": false,
    "last_bill_date": null,
    "next_bill_date": null,
    "payment_link": "http://localhost:4002/en/billing/upgrade?plan_code=premium&store_name=some+name&phone_number=%2B201117432982",
    "plan": "free",
    "price": "0",
    "status": "active"
  }
}
```

#### Store is not yet created for a valid access token

##### Request
* __Method:__ GET
* __Path:__ /api/v1/stores/invalid-slug
* __Request headers:__
```
accept: application/json
authorization: V2Z4D7g0EBHrvHf0OwiNayfsmFGwtKEgwoO_DajjfW8
```

##### Response
* __Status__: 404
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkthMHES-1icAAAYm
```
* __Response body:__
```json
{
  "errors": {
    "detail": "Internal Server Error"
  }
}
```

#### show singleton store renders primary store

##### Request
* __Method:__ GET
* __Path:__ /api/v1/store
* __Request headers:__
```
accept: application/json
authorization: HYV763KmEcwHmjaRoH6Yn6MKplC8eXZr4f5-SnhT_3s
cookie: locale=en
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:34 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkpTT_ApFzQQAAASH
```
* __Response body:__
```json
{
  "address": {
    "city": null,
    "country": "Egypt",
    "country_code": "EG",
    "street_address": null
  },
  "contact_phone_number": "+201102536843",
  "delivery_areas": [],
  "id": 75172,
  "industry": "retail",
  "logo": "https://vatrin-dev.s3.amazonaws.com/placeholders/logo-placeholder.png",
  "phone_number": "+201119143167",
  "shareable_link": "https://dev.vatrin.app/some-name?shared=true",
  "slug": "some-name",
  "social_links": {},
  "store_link": "https://dev.vatrin.app/some-name",
  "store_name": "some name",
  "store_policy": null,
  "subscription": {
    "currency": "EGP",
    "customer_id": "vatrex_test_some-name",
    "has_active_paid_plan": false,
    "last_bill_date": null,
    "next_bill_date": null,
    "payment_link": "http://localhost:4002/en/billing/upgrade?plan_code=premium&store_name=some+name&phone_number=%2B201119143167",
    "plan": "free",
    "price": "0",
    "status": "active"
  }
}
```

### <a id=working-with-stores-update></a>update
#### update store renders store when data is valid

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/stores/some-store-name
* __Request headers:__
```
accept: application/json
authorization: OdGdo6UYKJx3m6yHPOaS38FgkOFhvPmhkfKdwZeKiTw
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "city": "Jerusalem",
  "delivery_areas": [
    {
      "area": "Jerusalem",
      "fee": 0
    },
    {
      "area": "Ramallah",
      "fee": 20
    }
  ],
  "social_links": {
    "facebook": "http://fb.me/some-name"
  },
  "store_name": "some updated name",
  "store_policy": "some policy",
  "street_address": "Jaffa Street"
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkryFp-Yg084AAATC
```
* __Response body:__
```json
{
  "address": {
    "city": "Jerusalem",
    "country": "Egypt",
    "country_code": "EG",
    "street_address": "Jaffa Street"
  },
  "contact_phone_number": "+201102536843",
  "delivery_areas": [
    {
      "area": "Jerusalem",
      "fee": 0.0,
      "id": "44b8b4c0-a18c-4f70-bf0b-0da128e06dd9"
    },
    {
      "area": "Ramallah",
      "fee": 20.0,
      "id": "710bb3e1-7bed-4ff4-abe1-75ea6020ee1d"
    }
  ],
  "id": 75175,
  "industry": "fnb",
  "logo": "https://vatrin-dev.s3.amazonaws.com/placeholders/logo-placeholder.png",
  "phone_number": "+201111707905",
  "shareable_link": "https://dev.vatrin.app/some-store-name?shared=true",
  "slug": "some-store-name",
  "social_links": {
    "facebook": "http://fb.me/some-name"
  },
  "store_link": "https://dev.vatrin.app/some-store-name",
  "store_name": "some updated name",
  "store_policy": "some policy",
  "subscription": {
    "currency": "EGP",
    "customer_id": "vatrex_test_some-store-name",
    "has_active_paid_plan": false,
    "last_bill_date": null,
    "next_bill_date": null,
    "payment_link": "http://localhost:4002/en/billing/upgrade?plan_code=premium&store_name=some+updated+name&phone_number=%2B201111707905",
    "plan": "free",
    "price": "0",
    "status": "active"
  }
}
```

#### Not providing a store name

##### Request
* __Method:__ PUT
* __Path:__ /api/v1/stores/some-store-name
* __Request headers:__
```
accept: application/json
authorization: umDtRgTx4Ld-iP7TJT1gNv-o5x7aw_QKR93B08fWvuo
content-type: multipart/mixed; boundary=plug_conn_test
```
* __Request body:__
```json
{
  "store_name": null
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwkuaGjpM2XiQAAAZn
```
* __Response body:__
```json
{
  "errors": {
    "name": [
      "can't be blank"
    ]
  }
}
```

### <a id=working-with-stores-delete></a>delete
#### Drops the account along with the created store

##### Request
* __Method:__ DELETE
* __Path:__ /api/v1/stores/some-store-name
* __Request headers:__
```
accept: application/json
authorization: KzyWRteC4PgH5YjK2jojcCkp3-TEWEcphB2vf4R0HQ0
```

##### Response
* __Status__: 204
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:35 GMT; max-age=864000; HttpOnly
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwktdFA2fF00oAAAyh
```
* __Response body:__
```json

```

## Working with Subsbase Webhooks
### <a id=working-with-subsbase-webhooks-process_webhook></a>process_webhook
#### create subscription accepts an event to create new subscription

##### Request
* __Method:__ POST
* __Path:__ /api/v1/webhooks/subsbase
* __Request headers:__
```
content-type: application/json
authorization: Dsanl2V-Cfwcu_gcCW6fYDrBfmibR6bwhI5zOs0wSRw
signature: c61a1d09582e96a9e2e2ee9824c87367b0555856de7ec3a3dcf2c9e6f5929829
```
* __Request body:__
```json
{
  "customer": {
    "id": "subsbase_test_customer_id",
    "infoFields": {
      "phone-number": "+970598765432"
    }
  },
  "event_name": "new_subscriber_signed_up",
  "plan": {
    "planCode": "premium",
    "price": 150
  }
}
```

##### Response
* __Status__: 200
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk7CFTB49eWoAABUB
```
* __Response body:__
```json
"ok"
```

#### Not providing a defined plan in plans list

##### Request
* __Method:__ POST
* __Path:__ /api/v1/webhooks/subsbase
* __Request headers:__
```
content-type: application/json
authorization: K_HtUrxxUYuTsjbb9i0uJjKFbChoIBMyDfadFAookFo
signature: 8660258823b4520c059cd647990a6a781aeb36144c813ffabfcd2814232b2126
```
* __Request body:__
```json
{
  "customer": {
    "id": "subsbase_test_customer_id",
    "infoFields": {
      "phone-number": "+970598765432"
    }
  },
  "event_name": "new_subscriber_signed_up",
  "plan": {
    "planCode": "unknown",
    "price": 200
  }
}
```

##### Response
* __Status__: 422
* __Response headers:__
```
set-cookie: locale=en; path=/; expires=Fri, 06 Oct 2023 11:50:39 GMT; max-age=864000; HttpOnly
content-type: application/json; charset=utf-8
cache-control: max-age=0, private, must-revalidate
x-request-id: F4hwk769bFqoDecAAAzC
```
* __Response body:__
```json
{
  "errors": {
    "plan": [
      "is invalid"
    ]
  }
}
```

