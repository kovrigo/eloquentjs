---
layout: docs
active: server
---

{% for article in site.server %}
  <h2 id="{{ article.title | slugify }}" class="ui dividing header">{{ article.title }}</h2>
  {{ article.content }}
{% endfor %}

