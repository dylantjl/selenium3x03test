<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
    <form action="search.php" method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Enter your search term">
        <button type="submit">Search</button>
    </form>

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
            
            // Process and display the results
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Display the results here
                echo htmlspecialchars($row['column_name']) . '<br>';
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    ?>
</body>
</html>
