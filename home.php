<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>HOME</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-light bg-info">
            <span class="navbar-brand mb-0 h1 ">RCS SYSTEM</span>
            <span class="navbar-brand mb-0 h1 ml-auto"><?php echo $_SESSION['user_Rname']; ?></span>
            <a class="btn btn-primary" href="logout.inc.php">Logout</a>
        </nav>


        <div class="button-header" style="display: flex; justify-content: space-between; margin: 30px 450px ;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Create Request
            </button>
            <form method="POST" id="getDataForm">
                <button type="submit" class="btn btn-success" name="getDataButton">Get Data</button>
            </form>
            <form method="POST" id="getDataForm">
                <button type="submit" class="btn btn-warning" name="apButton">Manager Ap</button>
            </form>
            <form method="POST" id="getDataForm">
                <button type="submit" class="btn btn-danger" name="centerButton">Center</button>
            </form>
        </div>
        <div id="dataContainer" class="a1">
            <?php
            include "db_conn.inc.php";
            if (isset($_POST['getDataButton'])) {
                $sql = "SELECT * FROM request WHERE re_user_Rname = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $_SESSION['user_Rname']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Display the table headers
                    echo "<div class=\"table-responsive\">";
                    echo "<table class=\"table table-bordered table-hover\">";
                    echo "<thead class=\"thead-dark\">";
                    echo "<tr><th>RCS No.</th><th>Product name</th><th>Product No.</th><th>Model</th><th>ฝ่ายงานร้องขอ</th><th>ผู้ขอ</th><th>สถานะ</th></tr>";
                    echo "</thead>";

                    // Loop through the result set and display each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class=\"expandable-row\">";
                        echo "<td>" . $row["re_rcsNo"] . "</td>";
                        echo "<td>" . $row["re_pName"] . "</td>";
                        echo "<td>" . $row["re_pNo"] . "</td>";
                        echo "<td>" . $row["re_model"] . "</td>";
                        echo "<td>" . $row["re_from"] . "</td>";
                        echo "<td>" . $row["re_user_Rname"] . "</td>";
                        echo "<td>" . $row["rcs_status"] . "</td>";
                        echo "</tr>";
                        echo "<tr class=\"extra-info\">";
                        echo "<td colspan=\"7\">";
                        echo "<div class=\"card\">";
                        echo "<div class=\"card-body\">";

                        $objId = $row["re_rcsNo"];
                        $objSql = "SELECT obj_value FROM objects WHERE obj_id = ?";
                        $objStmt = $conn->prepare($objSql);
                        $objStmt->bind_param("s", $objId);
                        $objStmt->execute();
                        $objResult = $objStmt->get_result();

                        echo "<div class=\"card-body\">";
                        echo "<div class='ob1'>";
                        echo "<strong>วัตถุประสงค์:</strong>";
                        while ($objRow = $objResult->fetch_assoc()) {
                            echo "<p>" . $objRow["obj_value"] . "</p>";
                        }
                        echo "<div style='display:flex;'>";
                        echo "<strong style=' margin-left: 200px;'>Manager :</strong>";
                        echo "<p>" . $row["re_to"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";


                        echo "<div class='ob2'>";
                        echo "<div class='ob3'>";
                        echo "<strong>สภาพปัจจุบัน (ปัญหา + สาเหตุ)</strong>";
                        echo "<p>" . $row["re_problem"] . "</p>";
                        echo "</div>";

                        echo "<div class='ob3'>";
                        echo "<strong>สิ่งที่ต้องการเปลี่ยนแปลง</strong>";
                        echo "<p>" . $row["re_change"] . "</p>";
                        echo "</div>";
                        echo "</div>";

                        echo "<div class=\"card-body\">";
                        $isHidden = isset($_SESSION['hiddenButtons'][$row["re_rcsNo"]]) && $_SESSION['hiddenButtons'][$row["re_rcsNo"]];
                        $hideAttribute = $isHidden ? 'style="display: none;"' : '';
                        if ($row["rcs_status"] === 'Manager1' && $row["re_to"] === $_SESSION['user_Rname']) {
                            echo "<form method=\"POST\" action=\"assign.inc.php\">";
                            echo "<input type=\"hidden\" name=\"rowId\" value=\"" . $row["re_rcsNo"] . "\">";
                            echo "<input type=\"text\" name=\"approvalComment[" . $row["re_rcsNo"] . "]\" id=\"approvalComment\" $hideAttribute placeholder=\"Enter approval comment\">";
                            echo "<button type=\"submit\" class=\"btn btn-primary\" name=\"action\" value=\"approve\" $hideAttribute>Approve</button>";
                            echo "<button type=\"submit\" class=\"btn btn-danger\" name=\"action\" value=\"decline\" $hideAttribute>Decline</button>";
                            echo "</form>";
                        } elseif ($row["rcs_status"] === 'F MANAGER' || $row["rcs_status"] === 'Approved' || $row["rcs_status"] === 'Declined') {
                            $effectSql = "SELECT * FROM center JOIN effects ON center.c_rcs_No = effects.e_rcsNo WHERE effects.e_rcsNo = ?";
                            $effstmt = $conn->prepare($effectSql);
                            $effstmt->bind_param("s", $row["re_rcsNo"]);
                            $effstmt->execute();
                            $effresult = $effstmt->get_result();
                            while ($effrow = $effresult->fetch_assoc()) {
                                echo "<div class='eff1'>";
                                echo "<div class='eff2'>";
                                echo "<div class='eff3'>";
                                echo "<strong>ผลกระทบข้อกำหนดลูกค้า : </strong><p>" . $effrow["e_1"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อแผนผลิตของลูกค้า : </strong><p>" . $effrow["e_2"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต้อการใช้งานชิ้นส่วน : </strong><p>" . $effrow["e_3"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อรูปร่างเเละขนาดทั่วไปของชิ้นส่วน : </strong><p>" . $effrow["e_4"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อผู้ปฎิบัติงาน ณ จุดที่เปลี่ยนแปลง : </strong><p>" . $effrow["e_5"] . "</p>";
                                echo "</div>";
                                echo "</div>";

                                echo "<div class='eff2'>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อผู้ปฎิบัติงานในขั้นตอนไป : </strong><p>" . $effrow["e_6"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อเครื่องมือเเละอุปกรณ์ในการผลิต : </strong><p>" . $effrow["e_7"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อมาตรฐานในการปฎิบัติงาน : </strong><p>" . $effrow["e_8"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อต้นทุนการผลิต :  </strong><p>" . $effrow["e_9"] . "</p>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";


                                echo "<div style='display:flex; justify-content: space-between; margin:0 200px;'>";
                                echo "<div style='display:flex;  margin-left:250px;'>";
                                echo "<strong>สามารถดำเนินการได้หรือไม่ :</strong>";
                                echo "<p>" . $effrow["e_allow"] . "</p>";
                                echo "</div>";
                                echo "<div style='display:flex;'>";
                                echo "<strong>ผู้ประเมิน :</strong>";
                                echo "<p>" . $effrow["e_Rname"] . "</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }

                        echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>No requests found.</p>";
                }

                // Close the statement and the database connection
                $stmt->close();
                $conn->close();
            } else if (isset($_POST['apButton'])) {
                $sql = "SELECT * FROM request WHERE re_to = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $_SESSION['user_Rname']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Display the table headers
                    echo "<div class=\"table-responsive\">";
                    echo "<table class=\"table table-bordered table-hover\">";
                    echo "<thead class=\"thead-dark\">";
                    echo "<tr><th>RCS No.</th><th>Product name</th><th>Product No.</th><th>Model</th><th>ฝ่ายงานร้องขอ</th><th>ผู้ขอ</th><th>สถานะ</th></tr>";
                    echo "</thead>";

                    // Loop through the result set and display each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class=\"expandable-row\">";
                        echo "<td>" . $row["re_rcsNo"] . "</td>";
                        echo "<td>" . $row["re_pName"] . "</td>";
                        echo "<td>" . $row["re_pNo"] . "</td>";
                        echo "<td>" . $row["re_model"] . "</td>";
                        echo "<td>" . $row["re_from"] . "</td>";
                        echo "<td>" . $row["re_user_Rname"] . "</td>";
                        echo "<td>" . $row["rcs_status"] . "</td>";
                        echo "</tr>";
                        echo "<tr class=\"extra-info\">";
                        echo "<td colspan=\"7\">";
                        echo "<div class=\"card\">";
                        echo "<div class=\"card-body\">";

                        $objId = $row["re_rcsNo"];
                        $objSql = "SELECT obj_value FROM objects WHERE obj_id = ?";
                        $objStmt = $conn->prepare($objSql);
                        $objStmt->bind_param("s", $objId);
                        $objStmt->execute();
                        $objResult = $objStmt->get_result();

                        echo "<div class=\"card-body\">";
                        echo "<div class='ob1'>";
                        echo "<strong>วัตถุประสงค์:</strong>";
                        while ($objRow = $objResult->fetch_assoc()) {
                            echo "<p>" . $objRow["obj_value"] . "</p>";
                        }
                        echo "<div style='display:flex;'>";
                        echo "<strong style=' margin-left: 200px;'>Manager :</strong>";
                        echo "<p>" . $row["re_to"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";


                        echo "<div class='ob2'>";
                        echo "<div class='ob3'>";
                        echo "<strong>สภาพปัจจุบัน (ปัญหา + สาเหตุ)</strong>";
                        echo "<p>" . $row["re_problem"] . "</p>";
                        echo "</div>";

                        echo "<div class='ob3'>";
                        echo "<strong>สิ่งที่ต้องการเปลี่ยนแปลง</strong>";
                        echo "<p>" . $row["re_change"] . "</p>";
                        echo "</div>";
                        echo "</div>";

                        echo "<div class=\"card-body\">";
                        $isHidden = isset($_SESSION['hiddenButtons'][$row["re_rcsNo"]]) && $_SESSION['hiddenButtons'][$row["re_rcsNo"]];
                        $hideAttribute = $isHidden ? 'style="display: none;"' : '';
                        if ($row["rcs_status"] === 'Manager1' && $row["re_to"] === $_SESSION['user_Rname']) {
                            echo "<form method=\"POST\" action=\"assign.inc.php\">";
                            echo "<input type=\"hidden\" name=\"rowId\" value=\"" . $row["re_rcsNo"] . "\">";
                            echo "<input type=\"text\" name=\"approvalComment[" . $row["re_rcsNo"] . "]\" id=\"approvalComment\" $hideAttribute placeholder=\"Enter approval comment\">";
                            echo "<button type=\"submit\" class=\"btn btn-primary\" name=\"action\" value=\"approve\" $hideAttribute>Approve</button>";
                            echo "<button type=\"submit\" class=\"btn btn-danger\" name=\"action\" value=\"decline\" $hideAttribute>Decline</button>";
                            echo "</form>";
                        } elseif ($row["rcs_status"] === 'F MANAGER' || $row["rcs_status"] === 'Approved' || $row["rcs_status"] === 'Declined') {
                            $effectSql = "SELECT * FROM center JOIN effects ON center.c_rcs_No = effects.e_rcsNo WHERE effects.e_rcsNo = ?";
                            $effstmt = $conn->prepare($effectSql);
                            $effstmt->bind_param("s", $row["re_rcsNo"]);
                            $effstmt->execute();
                            $effresult = $effstmt->get_result();
                            while ($effrow = $effresult->fetch_assoc()) {
                                echo "<div class='eff1'>";
                                echo "<div class='eff2'>";
                                echo "<div class='eff3'>";
                                echo "<strong>ผลกระทบข้อกำหนดลูกค้า : </strong><p>" . $effrow["e_1"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อแผนผลิตของลูกค้า : </strong><p>" . $effrow["e_2"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต้อการใช้งานชิ้นส่วน : </strong><p>" . $effrow["e_3"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อรูปร่างเเละขนาดทั่วไปของชิ้นส่วน : </strong><p>" . $effrow["e_4"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อผู้ปฎิบัติงาน ณ จุดที่เปลี่ยนแปลง : </strong><p>" . $effrow["e_5"] . "</p>";
                                echo "</div>";
                                echo "</div>";

                                echo "<div class='eff2'>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อผู้ปฎิบัติงานในขั้นตอนไป : </strong><p>" . $effrow["e_6"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อเครื่องมือเเละอุปกรณ์ในการผลิต : </strong><p>" . $effrow["e_7"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อมาตรฐานในการปฎิบัติงาน : </strong><p>" . $effrow["e_8"] . "</p>";
                                echo "</div>";
                                echo "<div  class='eff3'>";
                                echo "<strong>ผลกระทบต่อต้นทุนการผลิต :  </strong><p>" . $effrow["e_9"] . "</p>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";

                                echo "<div style='display:flex; justify-content: space-between; margin:0 200px;'>";
                                echo "<div style='display:flex;  margin-left:250px;'>";
                                echo "<strong>สามารถดำเนินการได้หรือไม่ :</strong>";
                                echo "<p>" . $effrow["e_allow"] . "</p>";
                                echo "</div>";
                                echo "<div style='display:flex;'>";
                                echo "<strong>ผู้ประเมิน :</strong>";
                                echo "<p>" . $effrow["e_Rname"] . "</p>";
                                echo "</div>";
                                echo "</div>";


                                if ($row["rcs_status"] === 'F MANAGER') {
                                    echo "<div>";
                                    echo "<form method=\"POST\" action=\"update_status.inc.php\">";
                                    echo "<input type=\"hidden\" name=\"rowId\" value=\"" . $row["re_rcsNo"] . "\">";
                                    echo "<button type=\"submit\" class=\"btn btn-primary\"  name=\"approve\" $hideAttribute>Approve</button>";
                                    echo "<button type=\"submit\" class=\"btn btn-danger\" style='margin-left:30px;' name=\"decline\" $hideAttribute>Decline</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            }
                        }

                        echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>No requests found.</p>";
                }

                // Close the statement and the database connection
                $stmt->close();
                $conn->close();
            } else if (isset($_POST['centerButton'])) {
                $sql = "SELECT * FROM request JOIN center  on request.re_rcsNo=center.c_rcs_NO  WHERE center.c_Name = ? AND request.rcs_status=?";
                $status = 'center';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $_SESSION['user_Rname'], $status);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Display the table headers
                    echo "<div class=\"table-responsive\">";
                    echo "<table class=\"table table-bordered table-hover\">";
                    echo "<thead class=\"thead-dark\">";
                    echo "<tr><th>RCS No.</th><th>Product name</th><th>Product No.</th><th>Model</th><th>ฝ่ายงานร้องขอ</th><th>ผู้ขอ</th><th>สถานะ</th></tr>";
                    echo "</thead>";

                    // Loop through the result set and display each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class=\"expandable-row\">";
                        echo "<td>" . $row["re_rcsNo"] . "</td>";
                        echo "<td>" . $row["re_pName"] . "</td>";
                        echo "<td>" . $row["re_pNo"] . "</td>";
                        echo "<td>" . $row["re_model"] . "</td>";
                        echo "<td>" . $row["re_from"] . "</td>";
                        echo "<td>" . $row["re_user_Rname"] . "</td>";
                        echo "<td>" . $row["rcs_status"] . "</td>";
                        echo "</tr>";
                        echo "<tr class=\"extra-info\">";
                        echo "<td colspan=\"7\">";
                        // Add card-container class and inline style
                        echo "<div class=\"card\" style=\"display: flex; flex-wrap: wrap;\">";
                        echo "<div class=\"card-body\">";

                        $objId = $row["re_rcsNo"];
                        $objSql = "SELECT obj_value FROM objects WHERE obj_id = ?";
                        $objStmt = $conn->prepare($objSql);
                        $objStmt->bind_param("s", $objId);
                        $objStmt->execute();
                        $objResult = $objStmt->get_result();

                        echo "<div class=\"card-body\">";
                        echo "<div class='ob1'>";
                        echo "<strong>วัตถุประสงค์:</strong>";
                        while ($objRow = $objResult->fetch_assoc()) {
                            echo "<p>" . $objRow["obj_value"] . "</p>";
                        }
                        echo "<div style='display:flex;'>";
                        echo "<strong style=' margin-left: 200px;'>Manager :</strong>";
                        echo "<p>" . $row["re_to"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";


                        echo "<div class='ob2'>";
                        echo "<div class='ob3'>";
                        echo "<strong>สภาพปัจจุบัน (ปัญหา + สาเหตุ)</strong>";
                        echo "<p>" . $row["re_problem"] . "</p>";
                        echo "</div>";

                        echo "<div class='ob3'>";
                        echo "<strong>สิ่งที่ต้องการเปลี่ยนแปลง</strong>";
                        echo "<p>" . $row["re_change"] . "</p>";
                        echo "</div>";
                        echo "</div>";



                        echo "<form action='effect.inc.php' method='POST'> ";
                        echo "<div class='checkk'>";
                        echo "<div>";
                        // Checkbox set 1
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบข้อกำหนดลูกค้า</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][1]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][1]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";

                        // Checkbox set 2
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อแผนผลิตของลูกค้า</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][2]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][2]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";

                        // Checkbox set 3
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต้อการใช้งานชิ้นส่วน</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][3]' value='กระทบ' onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][3]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";
                        // Checkbox set 4
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อรูปร่างเเละขนาดทั่วไปของชิ้นส่วน</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][4]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][4]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";

                        // Checkbox set 5
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อผู้ปฎิบัติงาน ณ จุดที่เปลี่ยนเเปลง</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][5]' value='กระทบ'  onclick='handleCheckbox(this)'>กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][5]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";
                        echo "</div>";
                        // Checkbox set 6
                        echo "<div>";
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อผู้ปฎิบัติงานในขั้นตอนไป</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][6]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][6]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";

                        // Checkbox set 7
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อเครื่องมือเเละอุปกรณ์ในการผลิต</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][7]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][7]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";
                        // Checkbox set 8
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อมาตรฐานในการปฎิบัติงาน</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][8]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][8]' value='ไม่กระทบ'  onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";

                        // Checkbox set 9
                        echo "<div class=\"card-body\">";
                        echo "<strong>ผลกระทบต่อต้นทุนการผลิต</strong>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][9]' value='กระทบ'  onclick='handleCheckbox(this)'> กระทบ</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][9]' value='ไม่กระทบ' onclick='handleCheckbox(this)'> ไม่กระทบ</label>";
                        echo "</div>";

                        echo "<div class=\"card-body\" style='margin-bottom: 30px;'>";
                        echo "<strong></strong>";
                        echo "</div>";

                        echo "</div>";
                        echo "</div>";

                        echo "<strong>สามารถดำเนินการได้หรือไม่ </strong>";
                        echo "<input type=\"hidden\" name=\"rowIdd\" value=\"" . $row["re_rcsNo"] . "\">";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][10]' value='ได้'  onclick='handleCheckbox(this)'> ได้</label>";
                        echo "<label><input type='radio' name='troubleCheckbox[" . $row["re_rcsNo"] . "][10]' value='ไม่ได้' onclick='handleCheckbox(this)'> ไม่ได้</label>";

                        echo "<button type=\"submit\" style='margin-left: 10px;' class=\"btn btn-danger\" name=\"center-action\">SENT</button>";
                        echo "</div>";
                        echo "</form>";


                        // Close card-container
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "No data found.";
                }

                // Close the statement and the database connection
                $stmt->close();
                $conn->close();
            }
            ?>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Request System</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="rcsRequest.inc.php" method="post">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="exampleFormControlInput1">RCS. No.:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="rcsNo" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">เรียน</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="to" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">PART NAME</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="partName" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">PART NO. :</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="partNo" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">MODEL :</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="model" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">วัตถุประสงค์</label>
                                <div class="form-check">
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="ปรับปรุงกระบานการผลิต" id="exampleCheck1">
                                        <label class="form-check-label">ปรับปรุงกระบานการผลิต</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="ให้ตรงกับการปฏิบัติจริง" id="exampleCheck2">
                                        <label class="form-check-label">ให้ตรงกับการปฏิบัติจริง</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="ลดต้นทุน" id="exampleCheck1">
                                        <label class="form-check-label">ลดต้นทุน</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="แก้ไขปัญหาการผลิต" id="exampleCheck2">
                                        <label class="form-check-label">แก้ไขปัญหาการผลิต</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="ปรับปรุงคุณภาพ" id="exampleCheck1">
                                        <label class="form-check-label">ปรับปรุงคุณภาพ</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="เพิ่มผลผลิต" id="exampleCheck2">
                                        <label class="form-check-label">เพิ่มผลผลิต</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="obj[]" value="ECR หรือ ECN" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">ECR หรือ ECN</label>
                                    </div>

                                    <div class="form-row">
                                        <label class="form-check-label" for="exampleCheck3">อื่นๆ</label>
                                        <input class="form-control" type="text" name="obj[]" value="" id="exampleCheck3">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">ฝ่ายงานร้องขอ</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="requester">
                                    <option>ABC</option>
                                    <option>EIEI</option>
                                    <option>KAI</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">สภาพปัจจุบัน(ปัญหา + สาเหตุ)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="currentCon" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">สิ่งที่ต้องการเปลี่ยนแปลง</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deChange" required></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveChangesBtn" name="postRe">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <script>
            $(document).ready(function() {
                // Add event listener to the specific button
                $('#saveChangesBtn').on('click', function(event) {
                    // Call your custom function here
                    validateForm(event);
                });
            });
        </script>
        <script src="script/validation.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>

    </html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>