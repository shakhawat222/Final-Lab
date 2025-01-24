<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newToken = $_POST['new_token'] ?? '';

    if (!empty($newToken)) {
        if (!preg_match('/^[A-Za-z0-9]+$/', $newToken) || strlen($newToken) < 4 || strlen($newToken) > 20) {
            echo "Token must be alphanumeric and between 4 and 20 characters!";
            exit;
        }

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if token already exists
        $stmt = $conn->prepare("SELECT * FROM tokens WHERE token = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $newToken);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Token already exists!";
        } else {
            // Insert new token
            $stmt = $conn->prepare("INSERT INTO tokens (token) VALUES (?)");
            if (!$stmt) {
                die("Error preparing insert statement: " . $conn->error);
            }

            $stmt->bind_param("s", $newToken);
            if ($stmt->execute()) {
                // Successfully added token, now fetch all tokens for display
                $stmt = $conn->prepare("SELECT token FROM tokens");
                $stmt->execute();
                $result = $stmt->get_result();

                // Display the token list in a colorful box
                echo "<div class='container'>";
                echo "<h3>All Tokens:</h3>";
                echo "<div class='token-list'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='token-item'>" . htmlspecialchars($row['token']) . "</div>";
                }
                echo "</div>";

                // Show the Go Home button
                echo "<a href='index.php' class='go-home-btn'>Go Home</a>";
                echo "</div>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please enter a valid token.";
    }
} else {
    echo "Invalid request method!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h3 {
            color: #4caf50;
            font-size: 1.6em;
            margin-bottom: 20px;
        }

        .token-list {
            margin: 20px 0;
            padding: 10px;
            background-color: #ffeb3b;
            border-radius: 10px;
            text-align: left;
        }

        .token-item {
            background-color: #2196f3;
            color: white;
            margin: 5px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .go-home-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #009688;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            margin-top: 20px;
        }

        .go-home-btn:hover {
            background-color: #00796b;
        }
    </style>
</head>
<body>

</body>
</html>
