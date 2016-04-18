# Sainsburys scraper

To set app working you need:

  - clone the project from the git
  - install composer on your machine
  - install all dependencies
  ```sh
        $ composer install
```
  - run the app (-v flag will enable verbose mode)
  ```sh
  php ./app.php app:scrape (-v)
```

To run tests

- run phpunit
  ```sh
  phpunit --bootstrap vendor/autoload.php
```