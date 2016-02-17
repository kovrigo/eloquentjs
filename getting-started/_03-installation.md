
* The package is available on [Packagist](https://packagist.org/packages/parsnick/eloquentjs). Install with composer.
  
```language-bash
composer require parsnick/eloquentjs:dev-master
```

* Add the service provider to `config/app.php` **before** your application's `RouteServiceProvider`.
  
```language-php
'providers' => [
    // ...
    EloquentJs\EloquentJsServiceProvider::class,
    // ...
];
```
