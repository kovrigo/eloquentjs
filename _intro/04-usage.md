---
title: Usage
---

* The model is now available to your own javascript as a property of the `Eloquent` global.
* It shares the Eloquent API you already know.

<div class="ui segment es5 sample">
    <div class="ui right corner label"></div>
{% highlight js %}
var Post = Eloquent.Post;

// Update the first post
Post.find(1).then(function (post) {
    post.update({
        title: prompt('Enter a new title')
    });
});

// Fetch the last updated post
Post.where('archived', false)
    .orderBy('updated_at', 'desc')
    .first(function (post) {
        console.log('last updated post: ' + post.title);
    });

// Add a listener to the 'saving' event
Post.saving(function (post) {
    if ( ! post.title) return false;
});

// Make a new post instance using the constructor
var myPost = new Post({
    title: 'A new post',
    body: 'Hello'
});

// Save the post
if (confirm('Save post?')) {
    myPost.save().then(function (post) {
        console.log('saved!');
    });
}
{% endhighlight %}
</div>