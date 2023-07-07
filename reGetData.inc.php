<?php
session_start();
include "db_conn.inc.php";


if (isset($_POST['getDataButton'])) {
    $sql = "SELECT * FROM request WHERE re_user_Rname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user_Rname']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display the table headers
        echo "<table>";
        echo "<tr><th>Column 1</th><th>Column 2</th></tr>";

        // Loop through the result set and display each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["re_rcsNo"] . "</td>";
            echo "<td>" . $row["re_user_Rname"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No data found.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
