---
layout: default
active: starting
---

## Installation

The package is available on [Packagist](https://packagist.org/packages/parsnick/eloquentjs)

<div class="ui segment php sample">
{% highlight php startinline %}
use Illuminate\Database\Eloquent\Model;

class Post extends Model {

}
{% endhighlight %}
</div>

<div class="ui segment es6 sample">
{% highlight js %}
import { Model } from 'laravel-eloquentjs';

class Post extends Model {

}
{% endhighlight %}
</div>

<div class="ui segment es5 sample">
{% highlight js %}
let Post = Eloquent('Post');
{% endhighlight %}
</div>
