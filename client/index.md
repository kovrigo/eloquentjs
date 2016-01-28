---
layout: docs
active: client
---

{% for article in site.client %}
  <h2 id="{{ article.title | slugify }}" class="ui dividing header">{{ article.title }}</h2>
  {{ article.content }}
{% endfor %}

<div class="ui divider"></div>

<div class="ui basic clearing segment">
    <a href="server/" class="ui right floated right labeled icon button">
      <i class="right arrow icon"></i>
      Docs for the PHP package
    </a>
</div>
