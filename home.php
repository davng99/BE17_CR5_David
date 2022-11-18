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

$query = "SELECT * FROM users WHERE id={$_SESSION['user']}";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

$fname = $row['first_name'];
$lname = $row['last_name'];
$email = $row['email'];
$pic = $row['picture'];
$pnumber = $row['phone_number'];
$address = $row['address'];
$status = $row['status'];

// $sql = "SELECT * FROM `products` 
// left JOIN car_rental on products.fk_rentalId = car_rental.rentalId
// JOIN booking on booking.fk_productsID = products.id
// JOIN users on booking.fk_userId = users.id
// WHERE users.id = $_SESSION[user]";

// $result = mysqli_query($connect, $sql);
// $tbody = ''; //this variable will hold the body for the table
// if (mysqli_num_rows($result)  > 0) {
//     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//         $tbody .= "<tr>
//             <td>" . $row['bookingId'] . "</td>
//             <td>" . $row['name'] . "</td>
//             <td>" . $row['price'] . "</td>
//             <td>" . $row['rental_name'] . "</td>
//             <td><a href='./products/actions/a_delete_rent.php?bookId=" . $row['bookingId'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
//             </tr>";
//     };
// } else {
//     $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
// }

mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= $fname ?></title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container py-5 h100">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="pictures/<?= $pic ?>" alt=" avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-4">Hi, <?= $fname ?></h5>
                        <div class="d-flex justify-content-center mb-2">
                            <a class=" btn btn-primary ms-1" href="update.php?id=<?= $_SESSION['user'] ?>">Update your profile</a>
                            <a class="btn btn-outline-primary ms-1" href="logout.php?logout">Log Out</a>
                        </div>
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
                            <p class="text-muted mb-0"><?= $fname ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Lastname</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $lname ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Phone number</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $pnumber ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $address ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $email ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Status</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $status ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="manageProduct w-75 mt-3">

            <p class='h2'>Bookings</p>
            <table class='table table-striped'>
                <thead class='table-success'>
                    <tr>
                        <th>Booking ID</th>
                        <th>Name</th>
                        <th>price</th>
                        <th>Car Rental</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div> -->
    </div>

</body>

</html>