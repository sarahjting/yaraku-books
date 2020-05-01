# yaraku-books

A book-keeping app for Yaraku's coding challenge.

View the live deployment here: https://yaraku-books.herokuapp.com/

## Installation

1. Clone the repo.
    ```
    git clone https://github.com/sarahjting/yaraku-books.git
    ```
1. Install composer dependencies.
    ```
    composer install
    ```
1. Generate app key.
    ```
    php artisan key:generate
    ```
1. Copy `.env.example` to `.env` and set up your database settings per your requirements.
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```
1. Migrate & seed database.
    ```
    php artisan migrate:refresh --seed
    ```
1. Install npm dependencies.
    ```
    npm i
    ```
1. Build assets.
    ```
    npm run prod
    ```
1. For a locally hosted version, put your server up with [Valet](https://laravel.com/docs/7.x/valet) or [Homestead](https://laravel.com/docs/7.x/homestead).

    By default, the GraphQL endpoint will be at `https://127.0.0.1/graphql`, the GraphiQL playground will be at `https://127.0.0.1/graphiql`, and the frontend client will be at `https://127.0.0.1/`.

## Tests

-   PHPUnit tests: `phpunit`
-   Mocha tests: `npm run test`

## Tech

-   Technologies used:
    -   Backend: PHP, Laravel 7, GraphQL (graphql-laravel)
    -   Backend testing: PHPUnit
    -   Frontend: Vue, Vuex, Vuetify
    -   Frontend testing: Jest
-   Requirements:
    -   Requires the `php-xml` php extension.

## Usage

Documentation and a playground for the backend's GraphQL API can be found at `/graphiql`, or at the following live deployment: https://yaraku-books.herokuapp.com/graphiql

Some example queries:

-   Get a list of books:

```
query {
    books {
        title author { name }
    }
}
```

-   Get a list of books sorted by author, where the author's name starts with "C":

```
query {
    books(orderBy:AUTHOR_ASC, author:"C") {
        title author { name }
    }
}
```

-   Get a list of books starting with "A", sorted by title:

```
query {
    books(orderBy:TITLE_ASC, title:"A") {
     title author { name }
    }
}
```
