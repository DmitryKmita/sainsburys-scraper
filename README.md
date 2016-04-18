# Sainsburys scraper

To set app working you need:

  - clone the project from the git
  - install composer on your machine
  - install all dependencies
  ```composer install
```
  - run the app (-v flag will enable verbose mode)
  ```
  php ./app.php app:scrape (-v)
```

To run tests

- run phpunit
  ```
  phpunit --bootstrap vendor/autoload.php
```