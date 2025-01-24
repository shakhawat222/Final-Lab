<?php
// Database configuration
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "library"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a new book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    // Get data from the form
    $new_book_title = $conn->real_escape_string($_POST['new_book_title']);
    $book_author = $conn->real_escape_string($_POST['book_author']);
    $publish_year = $conn->real_escape_string($_POST['publish_year']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $quantity = (int)$_POST['quantity']; // Ensure quantity is an integer

    // Insert the new book into the database
    $sql = "INSERT INTO books (title, author, publish_year, isbn, quantity) 
            VALUES ('$new_book_title', '$book_author', '$publish_year', '$isbn', $quantity)";

    if ($conn->query($sql) === TRUE) {
        echo "New book added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deleting a book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    // Get the book ID to delete
    $book_id = (int)$_POST['book_id']; // Ensure it's an integer
    
    if ($book_id > 0) {
        // Delete the book from the database
        $sql = "DELETE FROM books WHERE id = $book_id";

        if ($conn->query($sql) === TRUE) {
            echo "Book deleted successfully.";
        } else {
            echo "Error deleting book: " . $conn->error;
        }
    } else {
        echo "Invalid book ID.";
    }
}

// Fetch all books to display for deletion
$books_result = $conn->query("SELECT id, title FROM books");

$books = [];
if ($books_result->num_rows > 0) {
    while ($row = $books_result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Add or Delete Book</title>
    <style>
        /* Add some basic styling for the boxes */
        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-box {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-row {
            margin-bottom: 15px;
        }
        .form-row label {
            display: block;
            margin-bottom: 5px;
        }
        .form-row input, .form-row select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-row input {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-row input:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Add Book Form -->
        <div class="form-box">
            <h3>Add New Book</h3>
            <form action="" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-row">
                    <label for="new_book_title">Book Title:</label>
                    <input type="text" id="new_book_title" name="new_book_title" required>
                </div>
                <div class="form-row">
                    <label for="book_author">Author:</label>
                    <input type="text" id="book_author" name="book_author" required>
                </div>
                <div class="form-row">
                    <label for="publish_year">Publish Year:</label>
                    <input type="text" id="publish_year" name="publish_year" required>
                </div>
                <div class="form-row">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" required>
                </div>
                <div class="form-row">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div class="submit-row">
                    <input type="submit" value="Add Book">
                </div>
            </form>
        </div>

        <!-- Delete Book Form -->
        <div class="form-box">
            <h3>Delete a Book</h3>
            <form action="" method="POST">
                <input type="hidden" name="action" value="delete">
                <div class="form-row">
                    <label for="book_id">Select Book to Delete:</label>
                    <select name="book_id" id="book_id" required>
                        <option value="">--Select Book--</option>
                        <?php foreach ($books as $book) : ?>
                            <option value="<?= $book['id']; ?>"><?= htmlspecialchars($book['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="submit-row">
                    <input type="submit" value="Delete Book">
                </div>
            </form>
        </div>
    </div>

</body>
</html>
