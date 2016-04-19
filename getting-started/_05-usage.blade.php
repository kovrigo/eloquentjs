
<ul>
  <li>Simply include the javascript file generated above to start using Eloquent in the browser.</li>
  <li>You can access models as properties of the <code>Eloquent</code> global.</li>
</ul>

@highlight('js')
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
@endhighlight

