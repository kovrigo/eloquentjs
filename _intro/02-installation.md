---
title: Installation
---

The package is available on [Packagist](https://packagist.org/packages/parsnick/eloquentjs). Install with composer.

<div class="ui segment terminal sample">
{% highlight bash %}
composer require parsnick/eloquentjs:dev
{% endhighlight %}
</div>

Add the service provider to `config/app.php` **before** your application's `RouteServiceProvider`.

<div class="ui segment php sample">
{% highlight php startinline %}
$providers = [
    // ...
    EloquentJs\EloquentJsServiceProvider::class,
    // ...
];
{% endhighlight %}
</div>
