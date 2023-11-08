<?php
include 'Template.php';
include 'db.php';

Template::view('page-home.php', [
    'title' => 'صفحه اصلی',
    'teachers' => getTeachers()
]);
