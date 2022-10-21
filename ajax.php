<?php
include('functions.php');
$courses = new Courses();
echo json_encode($courses->getColors($_GET['course']));
?>