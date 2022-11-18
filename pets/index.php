<?php
session_start();
require_once '../components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
if (isset($_SESSION['user'])) {
    header("Location: ../home.php");
    exit;
}

$sql = "SELECT * FROM `pets`";
$result = mysqli_query($connect, $sql);
$cardbody = ''; //this variable will hold the body for the table
if (mysqli_num_rows($result)  > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $cardbody .= "<div class = 'col d-flex justify-content-center mt-5'><div class='card' style='width: 22rem;'>
        <img src='../pictures/" . $row['picture'] . "' class='card-img-top' style='height: 100%; object-fit: cover;' alt='" . $row['name'] . "'>
        <div class='card-body'>
          <h5 class='card-title mb-3'>" . $row['name'] . "</h5>
          <hr>
          <p class='card-text'>Size: " . $row['size'] . "</p>
          <p class='card-text'>Age: " . $row['age'] . "</p>
          <p class='card-text'>Vaccinated: " . $row['vaccinated'] . "</p>
          <p class='card-text'>Breed: " . $row['breed'] . "</p>
          <hr>
          <a href='update.php?id=". $row['id']. "' class='btn btn-success'>Edit</a>
          <a href='delete.php?id=". $row['id']. "' class='btn btn-danger'>Delete</a>
        </div>
      </div></div>";
    };
}
else{
    $cardbody = "No pets available";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <?php require_once '../components/boot.php' ?>
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
    <div class="manageProduct w-75 mt-3">
        <div class='mb-3'>
            <a href="create.php"><button class='btn btn-primary' type="button">Add pet</button></a>
            <a href="../dashboard.php"><button class='btn btn-success' type="button">Dashboard</button></a>
        </div>
        <p class='h2'>Pets</p>
       
        <div class="container text-center mt-5 mb-5">
            <div class = "row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-4">
            <?= $cardbody; ?>
            </div>
        </div>
    </div>
</body>

</html>