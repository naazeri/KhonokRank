<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{% yield title %}</title>
  <style>
  </style>
  <link rel="stylesheet" href="public/simplecss/simple.dark.min.css">
  <link rel="stylesheet" href="public/style.css">
</head>

<body dir="rtl">
  {% include ui-header.php %}
  {% yield content %}
  {% include ui-footer.php %}
  <script>
    //determines if the user has a set theme
    function detectColorScheme() {
      localStorage.setItem('theme', 'dark');
      document.documentElement.setAttribute('data-theme', 'dark');

      var theme = "dark"; //default to light

      //local storage is used to override OS theme settings
      if (localStorage.getItem("theme")) {
        if (localStorage.getItem("theme") == "dark") {
          var theme = "dark";
        }
      } else if (!window.matchMedia) {
        //matchMedia method not supported
        return false;
      } else if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        //OS theme setting detected as dark
        var theme = "dark";
      }

      //dark theme preferred, set document with a `data-theme` attribute
      if (theme == "dark") {
        document.documentElement.setAttribute("data-theme", "dark");
      }
    }
    detectColorScheme();
  </script>
</body>

</html>