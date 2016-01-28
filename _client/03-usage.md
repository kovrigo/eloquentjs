---
title: Usage
---

Once configured (either manually or with the Artisan command) you can access each model
from the `Eloquent` global.

<div class="ui segment es5 sample">
  <div class="ui right corner label"></div>
  {% highlight js %}
var Post = Eloquent('Post');

// or, if you prefer

var Comment = Eloquent.Comment;
  {% endhighlight %}
</div>

<div class="ui basic tertiary segment">
  Both styles are equally valid - the latter case invokes a getter function which is simply a wrapper around the former.
</div>

Defining a model is relatively inexpensive - it simply stores the configuration.
If and when a model is first used, it then undergoes a `boot` process.
This means you can configure as many models as you want without causing a performance hit.

