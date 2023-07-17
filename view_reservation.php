<?php
session_start();
require_once('view_reservation_db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>View/Modify Service Reserve Request</title>
    <style>
        .error {
            color: red;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: inline-block;
            width: 150px;
        }

        input[type="text"],
        input[type="email"] {
            width: 250px;
            padding: 5px;
        }

        select {
            width: 264px;
            padding: 5px;
        }

        .submit-button {
            margin-top: 10px;
        }

        /* 弹窗样式 */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            z-index: 9999;
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?> 

    <h2>View/Modify Service Reservation</h2>

    <form>
        <div class="form-group">
            <label for="task_num">Task Number:</label>
            <input type="text" id="task_num" name="task_num" maxlength="50" value="<?php echo $reservationInfo['task_num']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name" maxlength="50" value="<?php echo $reservationInfo['contact_name']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="house_address">House Address:</label>
            <input type="text" id="house_address" name="house_address" maxlength="50" value="<?php echo $reservationInfo['house_address']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="house_type">House Type:</label>
            <input type="text" id="house_type" name="house_type" maxlength="100" value="<?php echo $reservationInfo['house_type']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="service_type">Service Type:</label>
            <input type="text" id="service_type" name="service_type" maxlength="20" value="<?php echo $reservationInfo['service_type']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="service_area">Service Area:</label>
            <input type="text" id="service_area" name="service_area" maxlength="20" value="<?php echo $reservationInfo['service_area']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="service_item">Service Item:</label>
            <input type="text" id="service_item" name="service_item" maxlength="100" value="<?php echo $reservationInfo['service_item']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="service_content">Service Content:</label>
            <input type="text" id="service_content" name="service_content" maxlength="50" value="<?php echo $reservationInfo['service_content']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="service_details">Service Details:</label>
            <input type="text" id="service_details" name="service_details" maxlength="50" value="<?php echo $reservationInfo['service_details']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="Task_Status">Service Content:</label>
            <input type="text" id="Task_Status" name="Task_Status" maxlength="50" value="<?php echo $reservationInfo['Task_Status']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="Start_Date">Service Schedule Date:</label>
            <input type="text" id="Start_Date" name="Start_Date" maxlength="50" value="<?php echo $reservationInfo['Start_Date']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="Total_Amount">Service Content:</label>
            <input type="text" id="Total_Amount" name="Total_Amount" maxlength="50" value="<?php echo $reservationInfo['Total_Amount']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="Admin_Comments">Service Details:</label>
            <input type="text" id="Admin_Comments" name="Admin_Comments" maxlength="50" value="<?php echo $reservationInfo['Admin_Comments']; ?>" readonly>
        </div>

        <button type="button" onclick="openPaymentDetails()">Payment Details</button>
    </form>

    <!-- 支付详情弹窗 -->
    <div class="popup" id="paymentDetailsPopup">
        <h3>Payment Details</h3>
        <form method="POST" action="view_reservation_db.php">
            <div class="form-group">
                <label for="task_num">Task Id:</label>
                <?php if ($paymentInfo['paymentStatus'] === 'unpaid'): ?>
                    <input type="text" id="task_num" name="task_num" maxlength="50" value="<?php echo $paymentInfo['task_num']; ?>" readonly>
                <?php else: ?>
                    <input type="text" id="task_num" name="task_num" maxlength="50" value="<?php echo $paymentInfo['task_num']; ?>" readonly>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="paymentAmount">Payment Amount:</label>
                <?php if ($paymentInfo['paymentStatus'] === 'unpaid'): ?>
                    <input type="text" id="paymentAmount" name="paymentAmount" maxlength="50" value="<?php echo $paymentInfo['paymentAmount']; ?>" readonly>
                <?php else: ?>
                    <input type="text" id="paymentAmount" name="paymentAmount" maxlength="50" value="<?php echo $paymentInfo['paymentAmount']; ?>" readonly>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="paymentDate">Payment Date:</label>
                <?php if ($paymentInfo['paymentStatus'] === 'unpaid'): ?>
                    <input type="text" id="paymentDate" name="paymentDate" maxlength="50" required>
                <?php else: ?>
                    <input type="text" id="paymentDate" name="paymentDate" maxlength="50" value="<?php echo $paymentInfo['paymentDate']; ?>" readonly>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="paymentEmail">Received Email:</label>
                <?php if ($paymentInfo['paymentStatus'] === 'unpaid'): ?>
                    <input type="text" id="paymentEmail" name="paymentEmail" maxlength="50" value="<?php echo "8888*@888.com"; ?>" readonly>
                <?php else: ?>
                    <input type="text" id="paymentEmail" name="paymentEmail" maxlength="50" value="<?php echo "8888*@888.com"; ?>" readonly>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="payerName">Payer Name:</label>
                <?php if ($paymentInfo['paymentStatus'] === 'unpaid'): ?>
                    <input type="text" id="payerName" name="payerName" maxlength="50" required>
                <?php else: ?>
                    <input type="text" id="payerName" name="payerName" maxlength="50" value="<?php echo $paymentInfo['payerName']; ?>" readonly>
                <?php endif; ?>
            </div>

            <?php if ($paymentInfo['paymentStatus'] === 'unpaid'): ?>
                <p>Information confirmed. Waiting for staff verification.</p>
                <div class="form-group submit-button">
                    <input type="submit" value="Submit">
                </div>
            <?php else: ?>
                <p>Payment details have been submitted and verified by staff.</p>
            <?php endif; ?>
        </form>




        <button onclick="closePaymentDetails()">Close</button>
    </div>

    <script>
        // 打开支付详情弹窗
        function openPaymentDetails() {
            var popup = document.getElementById("paymentDetailsPopup");
            popup.style.display = "block";
        }

        // 关闭支付详情弹窗
        function closePaymentDetails() {
            var popup = document.getElementById("paymentDetailsPopup");
            popup.style.display = "none";
        }
    </script>
</body>
</html>