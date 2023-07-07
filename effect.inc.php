<?php
session_start();
include "db_conn.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['center-action'])) {
        // Retrieve the value of $row["row_Idd"] from the hidden input field
        $re_rcsNo = $_POST['rowIdd'];

        // Retrieve the values of the checkboxes
        $radioValue1 = $_POST["troubleCheckbox"][$re_rcsNo][1];
        $radioValue2 = $_POST["troubleCheckbox"][$re_rcsNo][2];
        $radioValue3 = $_POST["troubleCheckbox"][$re_rcsNo][3];
        $radioValue4 = $_POST["troubleCheckbox"][$re_rcsNo][4];
        $radioValue5 = $_POST["troubleCheckbox"][$re_rcsNo][5];
        $radioValue6 = $_POST["troubleCheckbox"][$re_rcsNo][6];
        $radioValue7 = $_POST["troubleCheckbox"][$re_rcsNo][7];
        $radioValue8 = $_POST["troubleCheckbox"][$re_rcsNo][8];
        $radioValue9 = $_POST["troubleCheckbox"][$re_rcsNo][9];
        $radioValue10 = $_POST["troubleCheckbox"][$re_rcsNo][10];

        // Prepare and execute the INSERT statement
        $stmt1 = $conn->prepare('INSERT INTO effects (e_rcsNo, e_1, e_2, e_3, e_4, e_5, e_6, e_7, e_8, e_9, e_allow, e_Rname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt1->bind_param("ssssssssssss", $re_rcsNo, $radioValue1, $radioValue2, $radioValue3, $radioValue4, $radioValue5, $radioValue6, $radioValue7, $radioValue8, $radioValue9, $radioValue10, $_SESSION['user_Rname']);

        $stmt2 = $conn->prepare("UPDATE request SET rcs_status = 'F MANAGER' WHERE re_rcsNo = ?");
        $stmt2->bind_param("s", $re_rcsNo);
        if ($stmt1->execute() && $stmt2->execute()) {
            header("Location: home.php?error=Successful");
            exit();
        } else {
            header("Location: home.php?error=Error: Something went wrong");
            exit();
        }
    }
}
