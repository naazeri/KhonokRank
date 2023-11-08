{% extends ui-layout.php %}

{% block title %}{{ $title }}{% endblock %}

{% block content %}
<table>
  <thead>
    <tr>
      <th>نام</th>
      <th>امتیاز</th>
    </tr>
  </thead>
  <tbody>
    {% foreach($teachers as $teacher): %}
    <tr>
      <td>{{$teacher["name"]}}</td>
      <td>{{$teacher["rank"]}}</td>
    </tr>
    {% endforeach; %}
  </tbody>
</table>
{% endblock %}