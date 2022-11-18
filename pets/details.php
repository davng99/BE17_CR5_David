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

$id = $_GET['petId'];

$sql = "SELECT * FROM pets WHERE id = $id";
$result = mysqli_query($connect, $sql);
$data = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) == 1) {
    $name = $data['name'];
    $location = $data['location'];
    $description = $data['description'];
    $size = $data['size'];
    $age = $data['age'];
    $vaccinated = $data['vaccinated'];
    $breed = $data['breed'];
    $picture = $data['picture'];
} else {
    header("location: error.php");
}
mysqli_close($connect);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details</title>
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

        tr {
            text-align: center;
        }
    </style>
</head>

<body>
    

    <div class="manageProduct w-75 mt-3">
        <div class='mb-3'>
            <a href="../home.php"><button class='btn btn-danger' type="button">Back</button></a>
        </div>

        <div class="container py-5 h100">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="text-center">
                            <img src="../pictures/<?= $picture ?>" alt=" avatar" class="img-fluid" style="width: 100%;">
                            <h1><?= $name ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card card-body ">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $name ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Location</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $location ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Description</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $description ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Size</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $size ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Age</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $age ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Vaccinated</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $vaccinated ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Breed</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?= $breed ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>