<?php
include 'conn.php';
session_start();


if (($_SESSION['email'] !== "Micheal@gmail.com")) {
    header("Location: login.php");
    exit();
}


if (isset($_POST['delete_user'])) {
    $email = $_POST['email'];
    mysqli_query($conn, "DELETE FROM users WHERE `email` = $email");
    echo "User deleted.";
}

if (isset($_POST['update_user'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    mysqli_query($conn, "UPDATE users SET fname='$fname', lname='$lname' WHERE email = '$email'");
    echo "User updated.";
}

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $copies = $_POST['copies'];
    $check = mysqli_query($conn, "SELECT * FROM books WHERE title = '$title'");
    if (mysqli_num_rows($check) > 0) {
        echo "Book already exists..";
    } else {
        
        mysqli_query($conn, "INSERT INTO books (title, author, copies) VALUES ('$title', '$author', $copies)");
        echo "New book added.";
    }
    // mysqli_query($conn, "INSERT INTO `books`(`title`, `author`, `copies`) VALUES ('$title','$author','$copies')");
    // echo "Book added.";
}
if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $copies = $_POST['copies'];
    mysqli_query($conn, "UPDATE books SET title='$title', author='$author', copies=$copies WHERE `title` = '$title'");
    echo "Book updated.";
}

if (isset($_POST['delete_book'])) {
    $title = $_POST['title'];
    mysqli_query($conn, "DELETE FROM books WHERE    title = '$title'");
    echo "Book deleted.";
}


$usersResult = mysqli_query($conn, "SELECT * FROM users");
$booksResult = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        h1 { color: #34495e; }
    </style>
</head>
<body>
<h1>Admin Dashboard</h1>

<h3>All Users</h3>
<table>
    <tr><th>Name</th><th>Email</th><th>Borrowed</th><th>Actions</th></tr>
    <?php while ($user = mysqli_fetch_assoc($usersResult)): ?>
        <tr>
            <td><?php echo $user['fname'] . ' ' . $user['lname']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['borrowed book'] ? 'Yes' : 'No'; ?></td>
            <td>
               
                <form method="post" style="display:inline-block">
                    <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                    <input type="submit" name="delete_user" value="Delete">
                </form>
                <form method="post" style="display:inline-block">
                    <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                    <input type="text" name="fname" placeholder="First" value="<?php echo $user['fname']; ?>">
                    <input type="text" name="lname" placeholder="Last" value="<?php echo $user['lname']; ?>">
                    <input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
                    <input type="submit" name="update_user" value="Edit">
                </form>
                
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Add New Book</h3>
<form method="post">
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <input type="number" name="copies" placeholder="Copies" required>
    <input type="submit" name="add_book" value="Add Book">
</form>

<h3>Books List</h3>
<table>
    <tr><th>Title</th><th>Author</th><th>Available Copies</th><th>Actions</th></tr>
    <?php mysqli_data_seek($booksResult, 0); while ($book = mysqli_fetch_assoc($booksResult)): ?>
        <tr>
            <td><?php echo $book['title']; ?></td>
            <td><?php echo $book['author']; ?></td>
            <td><?php echo $book['copies']; ?></td>
            <td>
                <form method="post" style="display:inline-block">
                    <input type="hidden" name="title" value="<?php echo $book['title']; ?>">
                    <input type="submit" name="delete_book" value="Delete">
                </form>
                <form method="post" style="display:inline-block">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <input type="text" name="title" placeholder="Title" value="<?php echo $book['title']; ?>">
                    <input type="text" name="author" placeholder="Author" value="<?php echo $book['author']; ?>">
                    <input type="number" name="copies" placeholder="Copies" value="<?php echo $book['copies']; ?>">
                    <input type="submit" name="update_book" value="Update">
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
