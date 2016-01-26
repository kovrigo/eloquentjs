---
layout: default
active: starting
---

<div class="ui basic segment">

  <h1 class="ui centred header">Getting Started</h1>

  <div class="ui right toc rail">
    <div class="ui right aligned vertical sticky menu">
      <div class="header item">Getting Started</div>
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
