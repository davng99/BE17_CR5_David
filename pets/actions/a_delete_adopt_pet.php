<?php
session_start();
require_once '../../components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

if (isset($_SESSION['user'])){
    header("Location: ../../home.php");
    exit;
}


$adopt_id = $_GET['adoptId'];

$sql = "DELETE FROM pet_adoption WHERE id = $adopt_id";

if (mysqli_query($connect, $sql) === TRUE) {
    $class = "success";
    $message = "Successfully Deleted!";
} else {
    $class = "danger";
    $message = "The entry was not deleted due to: <br>" . $connect->error;
}
mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete</title>
    <?php require_once '../../components/boot.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Delete request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?= $message; ?></p>
            <a href='../../home.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>