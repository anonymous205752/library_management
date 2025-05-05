<?php

    include 'conn.php';
    session_start();
    $msg = '';
    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password']; 
        if($email === 'Micheal@gmail.com' && $password === '123456'){
            $_SESSION['email'] = $email;
            header("Location: admindash.php");
            exit();
            
        }


        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify the password using password_verify() function
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $user['email'];
                header("location: userdash.php");
            } else {
                $msg = 'Invalid password, please try again.';
            }
        } else {
            $msg = 'User not found.';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <?php echo $msg ?>
        <input type="email" name="email" id="" placeholder="input your email" required>
        <input type="password" name="password" id="" placeholder="input your password" required>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>