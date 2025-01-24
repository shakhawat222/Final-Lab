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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID of the book to be deleted
    $book_id = (int)$_POST['book_id']; // Ensure ID is an integer

    // SQL query to delete the book
    $sql = "DELETE FROM books WHERE id = $book_id";

    if ($conn->query($sql) === TRUE) {
        echo "Book deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .container h3 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .form-row {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .form-row label {
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .form-row select {
            width: 100%;
            padding: 8px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-row input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-row input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Delete Book</h3>
        <form action="" method="POST">
            <div class="form-row">
                <label for="book_id">Select Book to Delete:</label>
                <select id="book_id" name="book_id" required>
                    <option value="">--Select Book--</option>
                    <?php
                    // Fetch the list of books from the database
                    $sql_books = "SELECT id, title FROM books";
                    $result_books = $conn->query($sql_books);

                    if ($result_books->num_rows > 0) {
                        while ($row = $result_books->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No books available</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-row">
                <input type="submit" value="Delete Book">
            </div>
        </form>
    </div>
</body>
</html>
