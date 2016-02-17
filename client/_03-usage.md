
Once configured (either manually or with the Artisan command) you can access each model
from the `Eloquent` global.

```language-js
var Post = Eloquent('Post');
// or, as a property
var Comment = Eloquent.Comment;
```

<div class="ui basic tertiary segment">
  <p>
    Models are not initialised as soon as they're defined, but rather upon first use.
    For instance, defining the Comment model merely attaches a <code class="small">Comment</code> property with a <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty#Custom_Setters_and_Getters">getter function</a>
    to the <code class="small">Eloquent</code> object.
  </p>
  <p>
    This allows you to include the configuration for <em>all</em> your models on every page with minimal cost.
  </p>
</div>
