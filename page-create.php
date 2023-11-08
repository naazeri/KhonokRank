{% extends ui-layout.php %}

{% block title %}{{ $title }}{% endblock %}

{% block content %}
<hr>
<form action="" method="post">
  <p>
    <label for="name">نام</label>
    <input type="text" name="name" id="name" placeholder="نام" required>
  </p>
  <p>
    <label for="rank">امتیاز</label>
    <input type="number" name="rank" id="rank" placeholder="بین ۱ تا ۱۰" required>
  </p>
  <input type="submit" value="ارسال">
</form>
</table>
{% endblock %}