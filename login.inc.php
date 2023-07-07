<?php
session_start();
include "db_conn.inc.php";
if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: index.php?error=password is required");
        exit();
    } else {
        $sql = "select * from user where user_name='$uname' and user_password='$pass'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)) {
            $row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['user_password'] === $pass) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['user_Rname'] = $row['user_Rname'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: home.php");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect User Name or password ");
            exit();
        }
    }
} else {
    header("Location: index.php?error");
    exit();
}
