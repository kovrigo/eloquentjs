---
title: Usage
---

The model is available to your own javascript from the `Eloquent` global.
The API is largely the same as Laravel's Eloquent, aside from a [few key differences](comparison_of_laravel_eloquent_and_eloquentjs.html).

<div class="ui segment es5 sample">
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

// Create a new post instance
var myPost = new Post({
    title: 'A new post',
    body: 'Hello'
});

if (confirm('Save post?')) {
    myPost.save().then(function (post) {
        console.log('saved!');
    });
}
{% endhighlight %}
</div>