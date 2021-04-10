<?php

    error_reporting(E_ALL ^ E_NOTICE);
    include('../config/db_connect.php');

    $email = '';
    $password = '';

    $errors = ['email' => '', 'password' => ''];
    $response = ['message' => ''];
    
    if (isset($_POST['submit'])) {
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
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $hash_password = md5($password);

            $sql = "SELECT * FROM user_account WHERE `emailaddress` = '$email' AND `password` = '$hash_password'";
            $result = mysqli_query($conn, $sql);
            $count_user = mysqli_num_rows($result);
            
            if ($count_user > 0) {
                $user = mysqli_fetch_assoc($result);

                $_SESSION['id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['emailaddress'];

                header('location: ../index.php');
            } else {
                $response['message'] = 'Wrong Email Address Or Password';
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
    <title>TTPC paid llc | login up</title>
</head>
<body>
    <div class="mt-5 brand">
        <h3 class="text-center"><a href="../index.php" title="TTPC paid llc Home">TTPC paid llc</a></h3>
    </div>
     
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-group col-md-3 mx-auto p-3" id="form" method="POST">
        <?php if (!$response): ?>
            <p></p>
        <?php elseif($response['message'] === 'Wrong Email Address Or Password'): ?>    
            <p class="alert alert-danger text-center"><?php echo $response['message']; ?></p>
        <?php else: ?>    
            <p></p>     
        <?php endif; ?>
        
        <div class="input-group mb-2">
            <label for="email" class="mb-0">Email</label>
            <input type="email" name="email" id="email" class="form-control w-100" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>">
            <p class="err"><?php echo $errors['email']; ?></p>
        </div>    
        <div class="input-group mb-2">
            <label for="password" class="mb-0">Password</label>
            <input type="password" name="password" id="password" class="form-control w-100" placeholder="Enter Password" value="<?php echo htmlspecialchars($password); ?>">
            <p class="err"><?php echo $errors['password']; ?></p>
        </div>           
        <input type="submit" name="submit" class="btn btn-block btn-info mb-1 mt-3" value="Login">
    </form>
    <div class="text-center">
        <p>Don't have an account!<a href="register.php">Sign up</a></p>
    </div>
</body>
</html>