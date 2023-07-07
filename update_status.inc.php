<?php
session_start();
include "db_conn.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        // Handle the "Approve" button action here
        $rowId = $_POST['rowId'];

        // Perform the update query to set the status as "Approved"
        $updateSql = "UPDATE request SET rcs_status = 'Approved' WHERE re_rcsNo = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("s", $rowId);

        if ($stmt->execute()) {
            header("Location: home.php?success=Request approved successfully");
            exit();
        } else {
            header("Location: home.php?error=Error: Failed to approve the request");
            exit();
        }
    } elseif (isset($_POST['decline'])) {
        // Handle the "Decline" button action here
        $rowId = $_POST['rowId'];

        // Perform the update query to set the status as "Declined"
        $updateSql = "UPDATE request SET rcs_status = 'Declined' WHERE re_rcsNo = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("s", $rowId);

        if ($stmt->execute()) {
            header("Location: home.php?success=Request declined successfully");
            exit();
        } else {
            header("Location: home.php?error=Error: Failed to decline the request");
            exit();
        }
    }
}
