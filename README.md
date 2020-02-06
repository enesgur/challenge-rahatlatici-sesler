# Rahatlatıcı Sesler API

This application is an API service created using Laravel.


## Quick Start

    $ git clone https://github.com/enesgur/challenge-rahatlatici-sesler.git
    $ cd challenge-rahatlatici-sesler
    $ docker-compose up -d
    $ docker-compose exec php-fpm composer install -d /app
    $ docker-compose exec php-fpm php /app/artisan migrate
    $ docker-compose exec php-fpm php /app/artisan db:seed

## Authentication Method

This application using `Bearer token` method.

## Test User
**email**: `admin@localhost`

**pass**: `123456`

## Phpmyadmin info
**address**: `http://localhost:8080`

**user**: `root`

**pass**: `laravel`

## Endpoints

### Version Control

**URL** : `/api/version`

**Method** : `GET`

**Auth required** : NO

**Params**
```json
{
    "appVersion": "1.0.0",
    "langVersion": "2.0.0"
}
```
**Response**
```json
{
    "status": true,
    "response": {
        "app": {
            "min": "3.0.0",
            "latest": "3.2.0",
            "update": false
        },
        "lang": {
            "min": "4.5.0",
            "latest": "4.12.0",
            "update": false
        }
    }
}
```

### Authentication

**URL** : `/api/user/login`

**Method** : `POST`

**Auth required** : NO

**Params**
```json
{
	"email": "admin@localhost",
	"pass": "123456"
}
```
**Response**
```json
{
    "status": true,
    "response": {
        "authentication": true,
        "token": "X3VOe3IFX6LUdJurCMN35ibDK6o1Ol9XCIVJWAodBurC0dRmwC88ivScQ4DB7ZmXLwzXonyzLezr"
    }
}
```

### Revoke Token

**URL** : `/api/user/logout`

**Method** : `GET`

**Auth required** : YES

**Response**
```json
{
    "status": true,
    "response": "logout successfully."
}
```

### Category List

**URL** : `/api/category/list`

**Method** : `GET`

**Auth required** : YES

**Response**
```json
{
    "status": true,
    "response": [
        {
            "id": 1,
            "name": "Kuş Sesleri",
            "cover_image_url": "/path/image.jpg",
            "created_at": "2020-02-06 10:57:53",
            "updated_at": "2020-02-06 10:57:53",
            "songCount": 51
        },
        {
            "id": 2,
            "name": "Doğa Sesleri",
            "cover_image_url": "/path/image.jpg",
            "created_at": "2020-02-06 10:57:53",
            "updated_at": "2020-02-06 10:57:53",
            "songCount": 55
        },
        {
            "id": 3,
            "name": "Piyano Sesleri",
            "cover_image_url": "/path/image.jpg",
            "created_at": "2020-02-06 10:57:53",
            "updated_at": "2020-02-06 10:57:53",
            "songCount": 47
        },
        {
            "id": 4,
            "name": "Keman Sesleri",
            "cover_image_url": "/path/image.jpg",
            "created_at": "2020-02-06 10:57:53",
            "updated_at": "2020-02-06 10:57:53",
            "songCount": 47
        }
    ]
}
```

### Category Song List

**URL** : `/api/category/songs/[id]`

**Method** : `GET`

**Auth required** : YES

**Response**
```json
{
    "status": true,
    "response": [
        {
            "id": 3,
            "aid": 10,
            "length": 396,
            "name": "quae fugiat fugit",
            "stream_url": "/stream/object/sit.mp3/playlist.m3u8",
            "created_at": "2020-02-06 10:57:53",
            "updated_at": "2020-02-06 10:57:53",
            "artistID": 10,
            "artistName": "Nya Zemlak"
        },
        {
            "id": 17,
            "aid": 7,
            "length": 297,
            "name": "sint adipisci nesciunt",
            "stream_url": "/stream/object/velit.mp3/playlist.m3u8",
            "created_at": "2020-02-06 10:57:54",
            "updated_at": "2020-02-06 10:57:54",
            "artistID": 7,
            "artistName": "Aubrey Bruen"
        },
        
        {
            "id": 75,
            "aid": 19,
            "length": 370,
            "name": "est distinctio blanditiis",
            "stream_url": "/stream/object/qui.mp3/playlist.m3u8",
            "created_at": "2020-02-06 10:57:55",
            "updated_at": "2020-02-06 10:57:55",
            "artistID": 19,
            "artistName": "Prof. Buford Larkin Jr."
        }
    ]
}
```

### Favorite List

**URL** : `/api/favorites/songs`

**Method** : `GET`

**Auth required** : YES

**Response**
```json
{
    "status": true,
    "response": [
        {
            "id": 1,
            "aid": 7,
            "length": 274,
            "name": "non tempore iste",
            "stream_url": "/stream/object/dolor.mp3/playlist.m3u8",
            "created_at": "2020-02-06 10:57:53",
            "updated_at": "2020-02-06 10:57:53",
            "artistID": 7,
            "artistName": "Aubrey Bruen"
        }
    ]
}
```

### Favorite Add

**URL** : `/api/favorites/add`

**Method** : `POST`

**Auth required** : YES

**Params**
```json
{
	"id": 1,
}
```
**Response**
```json
{
    "status": true,
    "response": "Favorite add operation has been success"
}
```

### Favorite Delete

**URL** : `/api/favorites/remove/[id]`

**Method** : `DELETE`

**Auth required** : YES

**Response**
```json
{
    "status": true,
    "response": "Favorite remove operation has been success"
}
```
