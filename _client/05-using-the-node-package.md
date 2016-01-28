---
title: Using the node package
---

For advanced usage, you can use *EloquentJs* as a node module and customise the build
process. The default build uses [browserify](http://browserify.org/) - check the build script in
[package.json](https://github.com/parsnick/eloquentjs-client/blob/master/package.json)
for the exact command.

Perhaps you want to use the ES6 class syntax to augment your models, or maybe
you just want to exclude some of the default components from your build.

Whatever the reason, you can install with npm:

<div class="ui segment terminal sample">
  <div class="ui right corner label"></div>
{% highlight bash %}
npm install laravel-eloquentjs
{% endhighlight %}
</div>

And then you can import and extend whichever components you want:

<div class="ui segment es6 sample">
  <div class="ui right corner label"></div>
{% highlight js %}
// javascript/Post.js
import { Model } from 'laravel-eloquentjs';
import Comment from './Comment';

class Post extends Model {

  /**
   * Comment on this post.

   * @param {string} message
   * @return {Promise}
   */
  addComment(message) {
    let attributes = {
      message
    };

    attributes.post_id = this.getKey();

    return Comment.create(attributes);
  }

}

// Configuration for the model - that is, anything that would be
// passed as `options` to `Eloquent(name, options)` during normal
// usage - should be attached to its constructor.
Post.endpoint = '/api/posts';

export default Post;
{% endhighlight %}
</div>

<div class="ui basic secondary segment">
  Using the node module is not required for this. You may prefer to use the
  standard ES5 build included with the PHP package, then add your own logic
  by modifying the prototypes.
</div>