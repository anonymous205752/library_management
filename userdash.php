<?php 
    include 'conn.php';
     session_start();
     if(!isset($_SESSION['email'])){
        header("Location:login.php");
        exit();
     }
     $email = $_SESSION['email'];

     

    if (isset($_POST['borrow_book'])) {
        $title = $_POST['title'];

        $result = mysqli_query($conn, "SELECT title, copies FROM books WHERE title = '$title'");
        $book = mysqli_fetch_assoc($result);

        if ($book) {
            if ($book['copies'] > 0) {
                
                mysqli_query($conn, "UPDATE books SET copies = copies - 1 WHERE title = '$title'");
                mysqli_query($conn, "UPDATE users SET borrowedbook = 1 WHERE email = '$email'");
                echo "Book borrowed successfully.";
            } else {
                echo "No copies available.";
            }
        } else {
            echo "Book does not exist.";
        }
    }

    
    if (isset($_POST['return_book'])) {
        $title = $_POST['title'];

        
        $result = mysqli_query($conn, "SELECT * FROM books WHERE title = '$title'");
        $book = mysqli_fetch_assoc($result);

        if ($book) {
            
            mysqli_query($conn, "UPDATE books SET copies = copies + 1 WHERE title = '$title'");
            mysqli_query($conn, "UPDATE users SET borrowed book = 0 WHERE email = '$email'");
            echo "Book returned successfully.";
        } else {
            echo "Book does not exist.";
        }
    }

    
    $booksResult = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        h1 { color: #2c3e50; }
    </style>
</head>
<body>
<h1>User Dashboard</h1>

<h3>Available Books</h3>
<table>
    <tr><th>Title</th><th>Author</th><th>Available Copies</th><th>Actions</th></tr>
    <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
        <tr>
            <td><?php echo $book['title']; ?></td>
            <td><?php echo $book['author']; ?></td>
            <td><?php echo $book['copies']; ?></td>
            <td>
                <form method="post" style="display:inline-block">
                    <input type="hidden" name="title" value="<?php echo $book['title']; ?>">
                    <input type="submit" name="borrow_book" value="Borrow">
                </form>
                <form method="post" style="display:inline-block">
                    <input type="hidden" name="title" value="<?php echo $book['title']; ?>">
                    <input type="submit" name="return_book" value="Return">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<p>
    Logged in as: <?php echo $_SESSION['email']; ?> |
    <a href="logout.php">Logout</a>
</p>

</body>
</html>

