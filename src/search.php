<?php
// Include your database connection here

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isSQLInjection($input) {
    $sql_keywords = ["SELECT", "INSERT", "UPDATE", "DELETE", "DROP", "UNION", "WHERE", "OR", "AND"];
    foreach ($sql_keywords as $keyword) {
        if (stripos($input, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

// Check if the query parameter is set
if (isset($_GET['query'])) {
    $query = sanitize_input($_GET['query']);

    // Check for SQL injection
    if (isSQLInjection($query)) {
        echo "Invalid search query.";
    } else {
        // Perform your database query here
        // For example: SELECT * FROM your_table WHERE your_column LIKE '%$query%'

        // Fetch and display the results
        // Example: while ($row = mysqli_fetch_assoc($result)) { echo $row['your_column']; }
    }
} else {
    echo "No search query provided.";
}

?>
