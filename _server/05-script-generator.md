---
title: Create your eloquent.js build
---

If you've read through the docs up to here, you already know how to use the *EloquentJs* package.

1. Set up the server-side handling as described on this page.
2. Configure and use the javascript library as described in the [client docs](client/).

But there's more!

Simply run the Artisan [<i class="tiny external icon"></i>](https://laravel.com/docs/5.2/artisan) command
to create a custom build of the eloquent.js library pre-configured for the models in your Laravel application:

<div class="ui segment terminal sample">
    <div class="ui right corner label"></div>
{% highlight bash %}
php artisan eloquentjs:generate
{% endhighlight %}
</div>

This scans your app directory for any classes implementing
<code><abbr title="EloquentJs\Model\AcceptsEloquentJsQueries">AcceptsEloquentJsQueries</abbr></code>
and adds them to your eloquent.js build. Query scopes and date mutators are taken from the model
class and added to the javascript config.

<div class="ui basic tertiary segment">
    <i class="configure icon"></i> <code>@todo</code> include relations in the generated javascript
</div>

By default all models are included. Pass a CSV list to specify which models you want in your eloquent.js build.

<div class="ui segment terminal sample">
    <div class="ui right corner label"></div>
{% highlight bash %}
php artisan eloquentjs:generate --models=Post,Comment
{% endhighlight %}
</div>

The `--output` option can change where the generated eloquent.js is saved. The default is `public/eloquent.js`.
