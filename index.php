<?php
    include 'conn.php';
    if (isset($_POST['signup'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        if ((empty($fname)) || (empty($lname)) || (empty($email)) || (empty($password))) {
            echo 'fill all inputs';
        }
        else {
            
            $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
            if (mysqli_num_rows($checkEmail) > 0) {
                echo "Email already exists!";
            } else {
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                
                $sql = "INSERT INTO `users`(`fname`, `lname`, `email`, `password`) 
                        VALUES ('$fname', '$lname', '$email', '$hashedPassword')";
                $insert = mysqli_query($conn, $sql);
    
                if ($insert) {
                    echo "Account created successfully";
                    header("refresh:2;url=login.php");
                } else {
                    echo "Error: " . mysqli_error($conn);
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
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="fname" id="" placeholder="input your first name" required>
        <input type="text" name="lname" id="" placeholder="input your last name" required>
        <input type="email" name="email" id="" placeholder="input your email" required>
        <input type="password" name="password" id="" placeholder="input your password" required>
        <button type="submit" name="signup">Signup</button>
    </form> 
</body>
</html>