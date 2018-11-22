<?php
include_once '../../fn.php';

// echo '<pre>';
// print_r($_GET);
// echo '</pre>';

$name = $_GET['name'];
$slug = $_GET['slug'];


$sql = "insert into categories (name, slug) values ('$name', '$slug')";


if (my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }
    


?>