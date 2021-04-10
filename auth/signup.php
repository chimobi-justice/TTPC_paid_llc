<?php

    error_reporting(E_ALL ^ E_NOTICE);
    include('../config/db_connect.php');

    $firstname = '';
    $lastname = '';
    $email = '';
    $password = '';

    $errors = ['firstname' => '', 'lastname' => '', 'email' => '', 'password' => ''];
    $response = ['message' => ''];
    
    if (isset($_POST['submit'])) {
        if (empty($_POST['firstname'])) {
            $errors['firstname'] = 'Please Enter Your Firstname';
        } else {
            $firstname = $_POST['firstname'];
            if (!preg_match('/^[a-zA-Z]+$/', $firstname)) {
                $errors['firstname'] = 'Firstname contains Letters Only';
            }
        }
        if (empty($_POST['lastname'])) {
            $errors['lastname'] = 'Please Enter Your Lastname';
        } else {
            $lastname = $_POST['lastname'];
            if (!preg_match('/^[a-zA-Z]+$/', $lastname)) {
                $errors['lastname'] = 'Lastname contains Letters Only';
            }
        }
        if (empty($_POST['email'])) {
            $errors['email'] = 'Enter Your Email Address';
        } else {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Enter A Valid Email Address';            
            }
        }
        if (empty($_POST['password'])) {
            $errors['password'] = 'Please Enter Your Password';
        } else {
            $password = $_POST['password'];
            if (strlen($password) < 8) {
                $errors['password'] = 'Your Password is Weak';            
            }
        }

        if (!array_filter($errors)) {
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $hash_password = md5($password);


            $sql = "SELECT `emailaddress` FROM user_account WHERE `emailaddress` = '$email'";
            $result = mysqli_query($conn, $sql);
            $count_user = mysqli_num_rows($result);

            if ($count_user > 0) {
                $response['message'] = 'Email address Already Exit';
            } else {
                $sql = "INSERT INTO user_account(`firstname`, `lastname`, `emailaddress`, `password`) VAlUES('$firstname', '$lastname', '$email', '$hash_password')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $response['message'] = 'Your Account Has Been Created';
                } else {
                    $response['message'] = 'Account Not Created, Please Try Again';
                }
            }
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/form.css">
    <title>TTPC paid llc | sign up</title>
</head>
<body>
    <div class="mt-5 brand">
        <h3 class="text-center"><a href="../index.php" title="TTPC paid llc Home">TTPC paid llc</a></h3>
    </div>
        
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-group col-md-3 mx-auto p-3" id="form" method="POST">

        <?php if (!$response): ?>
            <p></p>
        <?php elseif($response['message'] === 'Email address Already Exit'): ?>    
            <p class="alert alert-danger text-center"><?php echo $response['message']; ?></p>
        <?php elseif($response['message'] === 'Your Account Has Been Created'): ?>    
            <p class="alert alert-success text-center"><?php echo $response['message']; ?></p>
        <?php elseif($response['message'] === 'Account Not Created, Please Try Again'): ?>    
            <p class="alert alert-danger text-center"><?php echo $response['message']; ?></p>
        <?php else: ?>    
            <p></p>     
        <?php endif; ?>

        <div class="input-group mb-2">
            <label for="firstname" class="mb-0">Firstname</label>
            <input type="text" id="firstname" name="firstname" class="form-control w-100" placeholder="Enter Firstname" value="<?php echo htmlspecialchars($firstname); ?>">
            <p class="err"><?php echo $errors['firstname']; ?></p>
        </div>
        <div class="input-group mb-2">
            <label for="lastname" class="mb-0">Lastname</label>
            <input type="text" id="lastname" name="lastname" class="form-control w-100" placeholder="Enter Lastname" value="<?php echo htmlspecialchars($lastname); ?>">
            <p class="err"><?php echo $errors['lastname']; ?></p>
        </div>
        <div class="input-group mb-2">
            <label for="email" class="mb-0">Email</label>
            <input type="email" id="email" name="email" class="form-control w-100" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>">
            <p class="err"><?php echo $errors['email']; ?></p>
        </div>    
        <div class="input-group mb-2">
            <label for="password" class="mb-0">Password</label>
            <input type="password" id="password" name="password" class="form-control w-100" placeholder="Enter Password" value="<?php echo htmlspecialchars($password); ?>">
            <p class="err"><?php echo $errors['password']; ?></p>
        </div>           
        <input type="submit" name="submit" class="btn btn-block btn-info mb-1 mt-3" value="Sign up">
    </form>
    <div class="text-center">
        <p>Already have an account!<a href="login.php">Login</a></p>
    </div>
</body>
</html>