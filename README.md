# yaraku-books

A book-keeping app for Yaraku's coding challenge.

## Installation

1. Clone the repo.
    ```
    git clone https://github.com/sarahjting/yaraku-books.git
    ```
1. Install composer dependencies.
    ```
    composer install
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

    By default, the GraphQL endpoint will be at `https://127.0.0.1/graphql`, the GraphiQL playground will be at `https://127.0.0.1/graphiql`, and the frontend cient will be at `https://127.0.0.1/`.

## Tests

-   PHPUnit tests: `phpunit`
-   Mocha tests: `npm run test`

## Using

-   Laravel 7, Vue.js
-   Requirements:
    -   php-xml
