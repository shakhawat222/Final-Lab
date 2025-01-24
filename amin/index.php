 <!-- Header Section -->
 <header style="text-align: center; padding: 10px; background-color: #0d1e55; color: #fff;">
        <h1>Library Management</h1>
    </header>
    <div class="logo-container">
        <img src="images/jarjis.jpg" alt="Library Logo" class="logo">
    </div>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <?php
    // Database configuration
    $servername = "localhost";
    $username = "root"; 
    $password = "";
    $dbname = "library"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Add book to the database
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_book_title'])) {
        $new_book_title = $_POST['new_book_title'];
        $book_author = $_POST['book_author'];
        $publish_year = $_POST['publish_year'];
        $isbn = $_POST['isbn'];
        $quantity = $_POST['quantity'];

        $sql_add_book = "INSERT INTO books (title, author, publish_year, isbn, quantity)
                         VALUES ('$new_book_title', '$book_author', '$publish_year', '$isbn', '$quantity')";

        if ($conn->query($sql_add_book) === TRUE) {
            $success_message = "Book added successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }

    // Fetch books for the list
    $books = [];
    $sql_books = "SELECT * FROM books";
    $result_books = $conn->query($sql_books);
    if ($result_books->num_rows > 0) {
        while ($row = $result_books->fetch_assoc()) {
            $books[] = $row;
        }
    }
    ?>

    <div class="container">
        <!-- Add Book Form -->
        <div class="form-box">
            <h3>Add a New Book</h3>
            <form action="" method="post">
                <div class="form-row">
                    <label for="new_book_title">Book Title:</label>
                    <input type="text" id="new_book_title" name="new_book_title" placeholder="Enter book title" required>
                </div>
                <div class="form-row">
                    <label for="book_author">Author:</label>
                    <input type="text" id="book_author" name="book_author" placeholder="Enter author's name" required>
                </div>
                <div class="form-row">
                    <label for="publish_year">Publish Year:</label>
                    <input type="text" id="publish_year" name="publish_year" placeholder="Enter publish year" required>
                </div>
                <div class="form-row">
                    <label for="isbn">ISBN Number:</label>
                    <input type="text" id="isbn" name="isbn" placeholder="Enter ISBN number" required>
                </div>
                <div class="form-row">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Enter book quantity" required>
                </div>
                <div class="submit-row">
                    <input type="submit" value="Add Book">
                </div>
            </form>

            <!-- Show success or error message -->
            <?php if (isset($success_message)) : ?>
                <p class="success"><?= $success_message ?></p>
            <?php elseif (isset($error_message)) : ?>
                <p class="error"><?= $error_message ?></p>
            <?php endif; ?>
        </div>

        <!-- Book List -->
        <div class="book-list-box">
            <h3>Book List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publish Year</th>
                        <th>ISBN</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book) : ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['publish_year']) ?></td>
                            <td><?= htmlspecialchars($book['isbn']) ?></td>
                            <td><?= htmlspecialchars($book['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 SHAKHAWAT. All rights reserved.</p>
    </footer>

    <script>
        // You can add additional JavaScript if necessary
    </script>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    header {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 20px;
    }

    .container {
        display: flex;
        justify-content: space-between;
        padding: 20px;
    }

    .form-box, .book-list-box {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 48%;
    }

    .form-row {
        margin-bottom: 15px;
    }

    .form-row label {
        display: block;
        font-weight: bold;
    }

    .form-row input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .submit-row input {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .submit-row input:hover {
        background-color: #45a049;
    }

    .success {
        color: green;
        margin-top: 10px;
    }

    .error {
        color: red;
        margin-top: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
    }
</style>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Borrowing Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Footer styling */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #0d1e55;
            color: #fff;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Adding padding to the body content so the footer won't cover it */
        body {
            padding-bottom: 60px;  /* Adjust this based on the height of your footer */
        }
    </style>
</head>
<body>
   



    

    <?php
    // Database configuration
    $servername = "localhost";
    $username = "root"; 
    $password = "";
    $dbname = "library"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $books = [];
    $sql_books = "SELECT title FROM books";
    $result_books = $conn->query($sql_books);
    if ($result_books->num_rows > 0) {
        while ($row = $result_books->fetch_assoc()) {
            $books[] = $row['title'];
        }
    }


    $tokens = [];
    $sql_tokens = "SELECT token FROM tokens";
    $result_tokens = $conn->query($sql_tokens);
    if ($result_tokens->num_rows > 0) {
        while ($row = $result_tokens->fetch_assoc()) {
            $tokens[] = $row['token'];
        }
    }

    $search_result = [];
    if (isset($_POST['search_query'])) {
        $search_query = $_POST['search_query'];
        $sql_search = "SELECT * FROM books WHERE title LIKE '%$search_query%'";
        $result_search = $conn->query($sql_search);
        if ($result_search->num_rows > 0) {
            while ($row = $result_search->fetch_assoc()) {
                $search_result[] = $row;
            }
        }
    }
    ?>

<?php
// Fetch books from the database
$sql_books = "SELECT * FROM books";
$result_books = $conn->query($sql_books);
if ($result_books->num_rows > 0) {
    echo "<ul>";
    while ($row = $result_books->fetch_assoc()) {
        echo "<li>
                <strong>" . htmlspecialchars($row['title']) . "</strong> 
                <a href='update_book.php?id=" . $row['id'] . "'>Edit</a>
              </li>";
    }
    echo "</ul>";
} else {
    echo "No books found.";
}
?>
    
 
        <!-- Right Column: Book List -->
        <div class="right-column">
            <div class="form-box search-book-box">
                <h3>Search for a Book</h3>
                <form action="" method="post">
                    <div class="form-row">
                        <label for="search_query">Search by Book Title:</label>
                        <input type="text" id="search_query" name="search_query" placeholder="Enter book title" required>
                    </div>
                    <div class="submit-row">
                        <input type="submit" value="Search">
                    </div>
                </form>

                <!-- Search Results -->
                <?php if (!empty($search_result)) : ?>
                    <h3>Search Results</h3>
                    <ul>
                        <?php foreach ($search_result as $book) : ?>
                            <li>
                                <strong>Title:</strong> <?= htmlspecialchars($book['title']) ?><br>
                                <strong>Author:</strong> <?= htmlspecialchars($book['author']) ?><br>
                                <strong>Publish Year:</strong> <?= htmlspecialchars($book['publish_year']) ?><br>
                                <strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?><br>
                                <strong>Quantity:</strong> <?= htmlspecialchars($book['quantity']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif (isset($search_query)) : ?>
                    <p>No books found matching your search query.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Featured Books Section -->
    <div class="container">
        <h3>Featured Books</h3>
        <div class="book-images-row">
            <div class="book-image">
                <img src="images/pic1.jpg" alt="Book 1">
                <p>হিমু মামা </p>
            </div>
            <div class="book-image">
                <img src="images/pic2.jpg" alt="Book 2">
                <p>Introduction To Java</p>
            </div>
            <div class="book-image">
                <img src="images/pic3.jpg" alt="Book 3">
                <p>How to Win Friends and influence people</p>
            </div>
            <div class="book-image">
                <img src="images/pic4.jpg" alt="Book 4">
                <p>Small Business Big Money</p>
            </div>
        </div>
    </div>

    <!-- Borrowing Form and Token Management Section -->
    <div class="container">
        <!-- Borrowing Form Box -->
        <div class="form-box borrowing-box">
            <h3>Borrowing Form</h3>
            <form action="process.php" method="post">
                <div class="form-row">
                    <label for="student_name">Full Name:</label>
                    <input type="text" id="student_name" name="student_name" placeholder="Enter full name">
                </div>
                <div class="form-row">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" placeholder="e.g., 18-38312-2">
                </div>
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter email">
                </div>
                <div class="form-row">
                    <label for="book_title">Book Title:</label>
                    <select id="book_title" name="book_title">
                        <option value="">--Select--</option>
                        <?php foreach ($books as $book) : ?>
                            <option value="<?= htmlspecialchars($book) ?>"><?= htmlspecialchars($book) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="borrow_date">Borrow Date:</label>
                    <input type="date" id="borrow_date" name="borrow_date">
                </div>
                <div class="form-row">
                    <label for="token">Token:</label>
                    <select id="token" name="token" required>
                        <option value="">--Select--</option>
                        <?php foreach ($tokens as $token) : ?>
                            <option value="<?= htmlspecialchars($token) ?>"><?= htmlspecialchars($token) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="return_date">Return Date:</label>
                    <input type="date" id="return_date" name="return_date">
                </div>
                <div class="form-row">
                    <label for="fees">Fees:</label>
                    <input type="text" id="fees" name="fees" placeholder="Enter fees">
                </div>
                <div class="submit-row">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>

        <!-- Token Management Box -->
        <div class="form-box token-box">
            <h3>Token Management</h3>
            <form action="save_token.php" method="post">
                <div class="form-row">
                    <label for="new_token">Add New Token:</label>
                    <input type="text" id="new_token" name="new_token" placeholder="Enter new token" required>
                </div>
                <div class="submit-row">
                    <input type="submit" value="Save Token">
                </div>
            </form>

            <h3>Token List</h3>
            <div id="token-list">
                <?php if (!empty($tokens)) : ?>
                    <ul>
                        <?php foreach ($tokens as $token) : ?>
                            <li><?= htmlspecialchars($token) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No tokens available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 SHAKHAWAT. All rights reserved.</p>
    </footer>
</body>
</html>
