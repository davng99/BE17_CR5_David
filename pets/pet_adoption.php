<?php
session_start();
require_once '../components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];

$pet_query = "SELECT pets.name, pets.picture, pet_adoption.adoption_date FROM `pets` 
JOIN pet_adoption on pet_adoption.fk_pet_id = pets.id
JOIN users on pet_adoption.fk_user_id = users.id
WHERE users.id = $id";

$pet_result = mysqli_query($connect, $pet_query);
$body = ''; //this variable will hold the body for the table

if (mysqli_num_rows($pet_result)  > 0) {
    while ($row = mysqli_fetch_array($pet_result, MYSQLI_ASSOC)) {
        $body .= "<div class = 'col mt-5 d-flex justify-content-center'><div class='card' style='width: 22rem;'>
        <img src='../pictures/" . $row['picture'] . "' class='card-img-top' style='height: 300px; object-fit: cover;' alt='" . $row['name'] . "'>
        <div class='card-body'>
          <h5 class='card-title mb-3'>" . $row['name'] . "</h5>
          <hr>
          <p class='card-text'>Adoptive Date: " . $row['adoption_date'] . "</p>
        </div>
      </div></div>";
    };
} else {
    $body = "No pets adopted";
}


$query = "SELECT * FROM users WHERE id={$_SESSION['user']}";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

$fname = $row['first_name'];
$pic = $row['picture'];

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <?php require_once '../components/boot.php' ?>
    <link rel="stylesheet" href="../css/style.css">
    <style type="text/css">
        .manageProduct {
            margin: auto;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 100px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../pictures/<?= $pic ?>" alt=" avatar" class="rounded-circle img-fluid" style="width: 50px;">
                Hi, <?= $fname ?>
            </a>

            <div class="navbar-nav">
                <a class=" btn btn-primary ms-1" href="../home.php?id=<?= $_SESSION['user'] ?>">Home</a>
                <a class=" btn btn-secondary ms-1" href="update.php?id=<?= $_SESSION['user'] ?>">Profile Settings</a>
                <a class="btn btn-outline-danger ms-1" href="logout.php?logout">Log Out</a>
            </div>
        </div>
    </nav>

    <div class="manageProduct w-75 mt-3">
        <p class='h1 text-center heading-pet'>Your Pets</p>
        <div class="container text-center mt-5 mb-5">
            <div class="d-flex justify-content-center row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-4">
                <?= $body; ?>
            </div>
        </div>
    </div>
</body>

</html>