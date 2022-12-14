<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: home.php");
    exit;
}

if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

$error = false;

$fname = $lname = $pnumber = $email = $address = $pass = $picture = "";
$fnameError = $lnameError = $pnumberError = $emailError = $addressError = $passError = $picError = "";

function cleanString($param){
    $val = trim($param);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);

    return $val;
}

if (isset($_POST['btn-signup'])) {

    $fname = cleanString($_POST['fname']);
    $lname = cleanString($_POST['lname']);
    $pnumber = cleanString($_POST['pnumber']);
    $email = cleanString($_POST['email']);
    $address = cleanString($_POST['address']);
    $pass = cleanString($_POST['pass']);

    $uploadError = "";
    $picture = file_upload($_FILES['picture']);


    if (empty($fname) || empty($lname)) {
        $error = true;
        $fnameError = "Please enter your name and surname";
    } elseif (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and surname must have at least 3 characters";
    } elseif (!preg_match("/^[a-zA-z]+$/", $fname) || !preg_match("/^[a-zA-z]+$/", $lname)) {
        $error = true;
        $fname = "Name and surname must contain only letters and no spaces";
    }

    if (empty($pnumber)) {
        $error = true;
        $pnumberError = "Please enter your phone number";
    } else if (!is_numeric($pnumber)){
        $error = true;
        $pnumberError = "Your phone number must not include any letter";
    }
    else {
        $query = "SELECT phone_number FROM users WHERE phone_number ='$pnumber'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $pnumberError = "Phone number already exists";
        }
    }

    if (empty($address)){
        $error = true;
        $addressError = "Please enter your address";
    }

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address";
    } else {
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided email already exists";
        }
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter the password";
    } elseif (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters";
    }

    $password = hash('sha256', $pass);

    if (!$error) {
        $query = "INSERT INTO users(`first_name`, `last_name`, `password`, `email`, `phone_number`, `address`, `picture`) VALUES 
        ('$fname', '$lname','$password','$email','$pnumber','$address', '$picture->fileName')";

        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        }
    }
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration System</title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
                            <?php
                            if (isset($errMSG)) {
                            ?>
                                <div class="alert alert-<?php echo $errTyp ?>">
                                    <p><?php echo $errMSG; ?></p>
                                    <p><?php echo $uploadError; ?></p>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" name="fname" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $fname ?>" />
                                        <span class="text-danger"> <?php echo $fnameError; ?> </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" name="lname" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $lname ?>" />
                                        <span class="text-danger"> <?php echo $fnameError; ?> </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 d-flex align-items-center">
                                    <div class="form-outline datepicker w-100">
                                        <input type="text" name="pnumber" class="form-control" placeholder="Phone number" maxlength="50" value="<?php echo $pnumber ?>" />
                                        <span class="text-danger"> <?php echo $pnumberError; ?> </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 d-flex align-items-center">
                                    <div class="form-outline datepicker w-100">
                                        <input type="text" name="address" class="form-control" placeholder="Address" maxlength="50" value="<?php echo $address ?>" />
                                        <span class="text-danger"> <?php echo $addressError; ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2 pb-2">
                                    <div class="form-outline">
                                        <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                                        <span class="text-danger"> <?php echo $emailError; ?> </span>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-4 pb-2">
                                    <div class="form-outline">
                                        <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                                        <span class="text-danger"> <?php echo $passError; ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input class='form-control' type="file" name="picture">
                                        <span class="text-danger"> <?php echo $picError; ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" style="width:100%" name="btn-signup">Register</button>
                            </div>
                            <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="index.php" class="fw-bold text-body"><u>Login here</u></a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>