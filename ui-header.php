<?php
$baseUrl = '/php/khonokrank';
$menu = array(
  "صفحه اصلی" => "$baseUrl/index.php",
  "اضافه کردن" => "$baseUrl/create.php",
);
?>

<header>
  <nav>
    <?php
    foreach ($menu as $name => $link) {
      echo "<a href='$link'>$name</a>";
    }
    ?>
  </nav>
</header>