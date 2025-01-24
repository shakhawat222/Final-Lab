<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$book_updated = false;  // Variable to check if the book is updated

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    
    // Fetch existing book details based on the ID
    $sql_book = "SELECT * FROM books WHERE id = $book_id";
    $result_book = $conn->query($sql_book);
    
    if ($result_book->num_rows > 0) {
        $book = $result_book->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated values from the form
    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $publish_year = $_POST['publish_year'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];

    // Update the book in the database
    $sql_update = "UPDATE books SET 
                    title='$title', 
                    author='$author', 
                    publish_year='$publish_year', 
                    isbn='$isbn', 
                    quantity='$quantity' 
                   WHERE id=$book_id";

    if ($conn->query($sql_update) === TRUE) {
        $book_updated = true;  // Set flag to true if book is updated successfully
    } else {
        echo "Error updating book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Center the container */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            background-color: #fce4ec;
            color: #333;
        }

        h3 {
            text-align: center;
            color: #d81b60;
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .form-row {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="text"], input[type="number"] {
            font-size: 14px;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #d81b60;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #c2185b;
        }

        .submit-row {
            text-align: center;
        }

        /* Go Back Home Button */
        .go-back-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #009688;
            color: white;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }

        .go-back-btn:hover {
            background-color: #00796b;
        }

        /* Responsive Styles */
        @media (max-width: 500px) {
            .container {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Update Book Details</h3>
        <?php if ($book_updated): ?>
            <div style="text-align:center; color: green; margin-bottom: 20px;">
                <p>Book updated successfully!</p>
                <a href="index.php" class="go-back-btn">Go Back Home</a>
            </div>
        <?php else: ?>
            <form action="update_book.php?id=<?php echo $book_id; ?>" method="POST">
                <div class="form-row">
                    <label for="book_title">Book Title:</label>
                    <input type="text" id="book_title" name="book_title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="book_author">Author:</label>
                    <input type="text" id="book_author" name="book_author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="publish_year">Publish Year:</label>
                    <input type="text" id="publish_year" name="publish_year" value="<?php echo htmlspecialchars($book['publish_year']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="isbn">ISBN Number:</label>
                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($book['quantity']); ?>" required>
                </div>
                <div class="submit-row">
                    <input type="submit" value="Update Book">
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
