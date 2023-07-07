<?php
session_start();
include "db_conn.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Check which button was clicked
        $action = $_POST['action'];

        // Get the ID of the row to update
        $rowId = $_POST['rowId'];

        // Perform the corresponding action based on the button clicked
        if (in_array($action, ['approve', 'decline'])) {
            // Get the approval comment from the form
            $approvalComment = $_POST['approvalComment'][$rowId];

            // Update the database or perform the decline action based on the row ID

            if ($action === 'approve') {
                // Update the database with the approval comment
                $sql = "UPDATE request SET rcs_status = 'center' WHERE re_rcsNo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $rowId);

                $sql1 = "INSERT INTO center (c_rcs_No , c_Name) Values (?, ?)";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("ss", $rowId, $approvalComment);

                if ($stmt->execute() && $stmt1->execute()) {
                    // Set a session variable to indicate that the button should be hidden
                    $_SESSION['hiddenButtons'][$rowId] = true;
                    header("Location: home.php?error=Successful");
                    exit();
                } else {
                    header("Location: home.php?error=Something went wrong");
                    exit();
                }

                // Perform any additional actions after the update
            } elseif ($action === 'decline') {
                // Perform the decline action (e.g., delete the row, update another column, etc.)
                $sql = "UPDATE request SET rcs_status = 'ไม่อนุญาติ' WHERE re_rcsNo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $rowId);

                if ($stmt->execute()) {
                    // Set a session variable to indicate that the button should be hidden
                    $_SESSION['hiddenButtons'][$rowId] = true;
                    header("Location: home.php?error=Successful");
                    exit();
                } else {
                    header("Location: home.php?error=Something went wrong");
                    exit();
                }
            }
        }
    }
}
