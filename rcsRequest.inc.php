<?php
session_start();
include "db_conn.inc.php";

if (isset($_POST['postRe'])) {
    $rcs = $_POST["rcsNo"];
    $to = $_POST["to"];
    $partName = $_POST["partName"];
    $partNo = $_POST["partNo"];
    $model = $_POST["model"];
    $requester = $_POST["requester"];
    $currentCon = $_POST["currentCon"];
    $deChange = $_POST["deChange"];
    $obj = $_POST['obj'];
    $status = 'Manager1';

    $stmt1 = $conn->prepare("INSERT INTO request (re_rcsNo, re_to, re_pName, re_pNo, re_model, re_obj, re_from, re_problem, re_change, re_user_Rname, rcs_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters using separate variables
    $stmt1->bind_param("sssssssssss", $rcs, $to, $partName, $partNo, $model, $rcs, $requester, $currentCon, $deChange, $_SESSION['user_Rname'], $status);

    if ($stmt1->execute()) {
        header("Location: home.php?error=Successful");
        $stmt1->close();
    } else {
        header("Location: home.php?error=error somtthing went wrong");
    }

    // Insert data into 'objects' table for each item in $obj array
    foreach ($obj as $item) {
        if ($item != "") {
            $stmt2 = $conn->prepare("INSERT INTO objects (obj_id, obj_value) VALUES (?, ?)");
            $stmt2->bind_param("ss", $rcs, $item);
            if ($stmt2->execute()) {
                header("Location: home.php?error=Successful");
                $stmt2->close();
            } else {
                header("Location: home.php?error=error somtthing went wrong");
            }
        }
    }

    $conn->close();
}
