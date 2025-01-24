<?php
$errors = [];
$receipt_data = [];  // Store the receipt data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation for Student Name
    if (preg_match("/^[A-Za-z ]+$/", $_POST["student_name"])) {
        $student_name = $_POST['student_name'];
        $receipt_data['Student Name'] = $student_name;
    } else {
        $errors[] = "Invalid Student Name";
    }

    // Validation for Student ID
    if (preg_match("/^[0-9]{2}-[0-9]{5}-[0-9]{1}$/", $_POST["student_id"])) {
        $student_id = $_POST['student_id'];
        $receipt_data['Student ID'] = $student_id;
        setcookie("student_id", $student_id, time() + 10, "/");
    } else {
        $errors[] = "Invalid Student ID Format";
    }

    // Validation for Email
    if (preg_match("/^[a-zA-Z0-9._%+-]+@student\.aiub\.edu$/", $_POST['email'])) {
        $email = $_POST['email'];
        setcookie("email", $email, time() + 10, "/");
    } else {
        $errors[] = "Provide the correct email format.";
    }

    // Validation for Fees
    if (preg_match("/^[0-9]+$/", $_POST["fees"])) {
        $fees = $_POST['fees'];
        $receipt_data['Fees'] = $fees;
    } else {
        $errors[] = "Invalid Fees Format";
    }

    // Validation for Book Title
    if (!empty($_POST['book_title'])) {
        $book_title = $_POST['book_title'];
        $receipt_data['Book Title'] = $book_title;
        setcookie("book_title", $book_title, time() + 10, "/");
    } else {
        $errors[] = "No Book Selected";
    }

    // Validation for Borrow and Return Dates
    $borrow_date = $_POST['borrow_date'] ?? '';
    $return_date = $_POST['return_date'] ?? '';

    if (!empty($borrow_date) && !empty($return_date)) {
        $borrow_date_obj = DateTime::createFromFormat('Y-m-d', $borrow_date);
        $return_date_obj = DateTime::createFromFormat('Y-m-d', $return_date);
        $date_diff = $borrow_date_obj->diff($return_date_obj)->days;

        if ($date_diff <= 10) {
            $receipt_data['Borrow Date'] = $borrow_date;
            $receipt_data['Return Date'] = $return_date;
        } else {
            $errors[] = "Borrow and Return Date gap exceeds 10 days.";
        }
    } else {
        $errors[] = "Both Borrow and Return Dates are required.";
    }

    // Token Validation and Removal
    $token = $_POST['token'] ?? '';
    if (!empty($token)) {
        $receipt_data['Token'] = $token;

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

        // Check if the token is available for borrowing
        $stmt = $conn->prepare("SELECT * FROM tokens WHERE token = ?");
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $errors[] = "Token not found or already used.";
        } else {
            // Remove the token
            $stmt = $conn->prepare("DELETE FROM tokens WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
        }

        // Continue with inserting borrowing details into the database if no errors
        if (empty($errors)) {
            $sql = "INSERT INTO borrowings (student_name, student_id, email, book_title, borrow_date, return_date, fees, token) 
                    VALUES ('$student_name', '$student_id', '$email', '$book_title', '$borrow_date', '$return_date', '$fees', '$token')";
            
            if ($conn->query($sql) === TRUE) {
                // Display borrowing details including user's name
                echo "
                <div class='container'>
                    <table>
                        <thead>
                            <tr><th colspan='2'>Borrowing Details Submitted</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><strong>Student Name:</strong></td><td>$student_name</td></tr>
                            <tr><td><strong>Student ID:</strong></td><td>$student_id</td></tr>
                            <tr><td><strong>Email:</strong></td><td>$email</td></tr>
                            <tr><td><strong>Book Title:</strong></td><td>$book_title</td></tr>
                            <tr><td><strong>Borrow Date:</strong></td><td>$borrow_date</td></tr>
                            <tr><td><strong>Return Date:</strong></td><td>$return_date</td></tr>
                            <tr><td><strong>Fees:</strong></td><td>$fees</td></tr>
                            <tr><td><strong>Token:</strong></td><td>$token</td></tr>
                        </tbody>
                    </table>
                </div>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close the connection
        $conn->close();
// Add a "Back to Home" button
echo "<br><a href='index.php' style='padding: 10px 20px; background-color: red; color: white; text-decoration: none;'>Back to Home</a>";


    } else {
        $errors[] = "Token is required.";
    }

    // If errors, display them
    if (!empty($errors)) {
        echo "<h2>Errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }

} else {
    echo "Connection to the database is closed or lost!";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color:rgb(45, 99, 199);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    
    .container {
        background-color: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 10px;
        width: 60%;
        max-width: 800px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    ul li {
        background-color: #ffdddd;
        color: #d80000;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>
