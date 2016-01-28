---
title: Usage
---

* Simply include the javascript file generated above to start using Eloquent in the browser.
* You can access models as properties of the `Eloquent` global.

<div class="ui segment es5 sample">
    <div class="ui right corner label"></div>
{% highlight js %}
var Post = Eloquent.Post;


// Fetch the last updated post
Post.where('archived', false)
    .orderBy('updated_at', 'desc')
    .first()
    .then(logResult);


// Update the first post
Post.find(1).then(function (post) {
    post.update({
        title: prompt('Enter a new title')
    });
});


// Add a listener to the 'saving' event
Post.saving(validatePost);


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


function logResult(result) {
    console.log(result);
}
function validatePost(post) {
    if ( ! post.title) return false;
}
{% endhighlight %}
</div>