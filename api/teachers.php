<?php
header("Content-Type:application/json");

$data = array(
  array("name" => "استاد ۱", "rank" => 7.2),
  array("name" => "استاد ۲", "rank" => 2),
  array("name" => "استاد ۳", "rank" => 10),
);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
