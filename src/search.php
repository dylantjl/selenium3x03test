<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>

    <?php
    if (isset($_POST['search'])) {
        $search = $_POST['search'];

        // Sanitize the input (strip_tags removes any HTML/PHP tags)
        $search = strip_tags($search);

        // Connect to your database using PDO
        $dsn = 'mysql:host=localhost;dbname=your_database_name;charset=utf8mb4';
        $username = 'your_username';
        $password = 'your_password';

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Use a prepared statement to execute the query
            $stmt = $pdo->prepare("SELECT * FROM your_table_name WHERE column_name LIKE :search");
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();

            // Display the search results
            echo '<ul>';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li>' . htmlspecialchars($row['column_name']) . '</li>';
            }
            echo '</ul>';
            
            // Add a button to return to the homepage
            echo '<a href="index.php">Back to Homepage</a>';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        // If no search term is provided, display a message
        echo '<p>No search term provided.</p>';
        echo '<a href="index.php">Back to Homepage</a>';
    }
    ?>
</body>
</html>
