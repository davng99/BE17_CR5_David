<?php
session_start();
require_once '../components/db_connect.php';

if (isset($_SESSION['adm'])) {
    header('Location: ../dashboard.php');
    exit;
}
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$pets_query = "SELECT * FROM pets WHERE age > 8";
$pets_result = mysqli_query($connect, $pets_query);
$cardbody = '';

if (mysqli_num_rows($pets_result)  > 0) {
    while ($row = mysqli_fetch_array($pets_result, MYSQLI_ASSOC)) {
        $cardbody .= "<div class = 'col d-flex justify-content-center mt-5'><div class='card' style='width: 22rem;'>
        <img src='../pictures/" . $row['picture'] . "' class='card-img-top' style='height: 300px; object-fit: cover;' alt='" . $row['name'] . "'>
        <div class='card-body'>
          <h5 class='card-title mb-3'>" . $row['name'] . "</h5>
          <hr>
          <p class='card-text'>Size: " . $row['size'] . "</p>
          <p class='card-text'>Age: " . $row['age'] . "</p>
          <p class='card-text'>Vaccinated: " . $row['vaccinated'] . "</p>
          <p class='card-text'>Breed: " . $row['breed'] . "</p>
          <hr>
          <a href='./details.php?petId=". $row['id']. "' class='btn btn-primary'>Details</a>
        </div>
      </div></div>";
    };
}
else{
    $cardbody = "No pets available";
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
    <title>Senior</title>
    <?php require_once '../components/boot.php' ?>
    <style type="text/css">
        .manageProduct {
            margin: auto;
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
                <a class=" btn btn-warning ms-1" href="../home.php">Back</a>
                <a class=" btn btn-secondary ms-1" href="../update.php?id=<?= $_SESSION['user'] ?>">Profile Settings</a>
                <a class="btn btn-outline-danger ms-1" href="../logout.php?logout">Log Out</a>
            </div>

        </div>
    </nav>

    <div class="manageProduct w-75 mt-3">
        <h1 class="text-center">Seniors</h1>
        <div class="container text-center mt-5 mb-5">
            <div class = "row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-4">
            <?= $cardbody; ?>
            </div>
        </div>
    </div>

</body>

</html>