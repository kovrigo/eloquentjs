---
layout: default
active: starting
---

<div class="ui basic segment">

  <h1 class="ui inverted block header">Getting Started</h1>

  <div class="ui left toc close rail">
    <div class="ui large fluid vertical pointing sticky menu">
      {% for article in site.intro %}
        <a href="getting-started/#{{ article.title | slugify }}" class="item">{{ article.title }}</a>
      {% endfor %}
    </div>
  </div>

{% for article in site.intro %}
  <h2 id="{{ article.title | slugify }}" class="ui dividing header">{{ article.title }}</h2>
  {{ article.content }}
{% endfor %}

</div>
