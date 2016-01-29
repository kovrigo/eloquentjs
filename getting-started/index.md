---
title: Getting Started
layout: docs
active: intro
---

{% for article in site.intro %}
  <h2 id="{{ article.title | slugify }}" class="ui dividing header">{{ article.title }}</h2>
  {{ article.content }}
{% endfor %}