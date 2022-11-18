<?php
session_start();
require_once 'components/db_connect.php';

if (isset($_SESSION['adm'])) {
    header('Location: dashboard.php');
    exit;
}
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$pets_query = "SELECT * FROM pets";
$pets_result = mysqli_query($connect, $pets_query);
$cardbody = '';

if (mysqli_num_rows($pets_result)  > 0) {
    while ($row = mysqli_fetch_array($pets_result, MYSQLI_ASSOC)) {
        $cardbody .= "<div class = 'col mt-5'><div class='card' style='width: 22rem;'>
        <img src='pictures/" . $row['picture'] . "' class='card-img-top' style='height: 100%; object-fit: cover;' alt='" . $row['name'] . "'>
        <div class='card-body'>
          <h5 class='card-title mb-3'>" . $row['name'] . "</h5>
          <hr>
          <p class='card-text'>Size: " . $row['size'] . "</p>
          <p class='card-text'>Age: " . $row['age'] . "</p>
          <p class='card-text'>Vaccinated: " . $row['vaccinated'] . "</p>
          <p class='card-text'>Breed: " . $row['breed'] . "</p>
          <hr>
          <a href='./pets/details.php?petId=". $row['id']. "' class='btn btn-primary'>Details</a>
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
    <title>Welcome <?= $fname ?></title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        .manageProduct {
            margin: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="pictures/<?= $pic ?>" alt=" avatar" class="rounded-circle img-fluid" style="width: 50px;">
                Hi, <?= $fname ?>
            </a>

            <div class="navbar-nav">
                <a class=" btn btn-primary ms-1" href="update.php?id=<?= $_SESSION['user'] ?>">Update your profile</a>
                <a class="btn btn-outline-primary ms-1" href="logout.php?logout">Log Out</a>
            </div>

            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class=" btn btn-primary ms-1" href="update.php?id=<?= $_SESSION['user'] ?>">Update your profile</a>
                    <a class="btn btn-outline-primary ms-1" href="logout.php?logout">Log Out</a>
                </div>
            </div> -->
        </div>
    </nav>

    <div class="manageProduct w-75 mt-3">

        <div class="container text-center mt-5 mb-5">
            <div class = "d-flex justify-content-center row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-4">
            <?= $cardbody; ?>
            </div>
        </div>
    </div>

</body>

</html>