<?php
// index.php or a separate script to handle search

// This function can be used to sanitize your inputs
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get search data from the form and clean the input
    $departureCity = clean_input($_POST['departureCity']);
    $arrivalCity = clean_input($_POST['arrivalCity']);
    $date = clean_input($_POST['date']);
    $passengers = clean_input($_POST['passengers']);
    
    // Assuming you have a PostgreSQL database connection
    $db_connection = pg_connect("host=localhost dbname=your_db_name user=your_username password=your_password");
    
    // Check the connection
    if(!$db_connection){
        die("Connection failed: " . pg_last_error());
    }

    // Prepare a query statement to prevent SQL injection
    $result = pg_prepare($db_connection, "my_query", 'SELECT * FROM trips WHERE departure_city = $1 AND arrival_city = $2 AND date = $3 AND available_seats >= $4');
    $result = pg_execute($db_connection, "my_query", array($departureCity, $arrivalCity, $date, $passengers));
    
    if ($result) {
        // Fetch and display the results
        while ($row = pg_fetch_assoc($result)) {
            // Output data of each row
            // Modify this part to display the data as you need
            echo "Trip ID: " . $row['trip_id'] . " - Departure: " . $row['departure_city'] . " - Arrival: " . $row['arrival_city'] . "<br>";
        }
    } else {
        echo "Error: " . pg_last_error($db_connection);
    }
    
    // Close the connection
    pg_close($db_connection);
} else {
    // Display your search form here or inform the user to provide input
}
?>
