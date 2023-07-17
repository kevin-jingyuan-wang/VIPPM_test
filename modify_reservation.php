<?php
session_start();
require_once('modify_reservation_db.php');
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
    </style>
</head>
<body>
    <?php include 'header.php'; ?> 

    <h2>View/Modify Service Reservation</h2>

    <?php if (!isset($_GET['edit'])) { ?>
    <!-- Display non-editable reservation information -->
    <form>
        <div class="form-group">
            <label for="task_num">Contact Name:</label>
            <input type="text" id="task_num" name="task_num" maxlength="50" value="<?php echo $reservationInfo['task_num']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name" maxlength="50" value="<?php echo $reservationInfo['contact_name']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="contact_email">Contact Email:</label>
            <input type="email" id="contact_email" name="contact_email" maxlength="50" value="<?php echo $reservationInfo['contact_email']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="contact_phone">Contact Phone:</label>
            <input type="text" id="contact_phone" name="contact_phone" maxlength="50" value="<?php echo $reservationInfo['contact_phone']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="house_address">House Address:</label>
            <input type="text" id="house_address" name="house_address" maxlength="50" value="<?php echo $reservationInfo['house_address']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="50" value="<?php echo $reservationInfo['city']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" maxlength="50" value="<?php echo $reservationInfo['province']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" maxlength="10" value="<?php echo $reservationInfo['postal_code']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="house_type">House Type:</label>
            <input type="house_type" id="house_type" name="house_type" maxlength="100" value="<?php echo $reservationInfo['house_type']; ?>" readonly>
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
            <label for="customer_prefer_service_date">Prefer Service Date:</label>
            <input type="text" id="customer_prefer_service_date" name="customer_prefer_service_date" maxlength="50" value="<?php echo $reservationInfo['customer_prefer_service_date']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="photo">Upload Photos:</label>
            <?php if (!empty($reservationInfo['photos'])) {
                $photos = explode(",", $reservationInfo['photos']);
                foreach ($photos as $photo) { ?>
                <img src="<?php echo $photo; ?>" alt="Service Photo" width="150">
            <?php }
            } else { ?>
                No photos available
            <?php } ?>
        </div>


        <div class="form-group submit-button">
            <a href="view_modify_service_reservation.php?reservation_id=<?php echo $reservationId; ?>&edit=true">Edit Information</a>
        </div>
    </form>
    <?php } else { ?>
    <!-- Display editable reservation information -->
    <form method="POST" action="modify_reservation_db.php">
        <div class="form-group">
            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name" maxlength="50" value="<?php echo $reservationInfo['contact_name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="contact_email">Contact Email:</label>
            <input type="email" id="contact_email" name="contact_email" maxlength="50" value="<?php echo $reservationInfo['contact_email']; ?>" required>
        </div>

        <div class="form-group">
            <label for="contact_phone">Contact Phone:</label>
            <input type="text" id="contact_phone" name="contact_phone" maxlength="50" value="<?php echo $reservationInfo['contact_phone']; ?>" required>
        </div>

        <div class="form-group">
            <label for="house_address">House Address:</label>
            <input type="text" id="house_address" name="house_address" maxlength="50" value="<?php echo $reservationInfo['house_address']; ?>" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="50" value="<?php echo $reservationInfo['city']; ?>" required>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" maxlength="50" value="<?php echo $reservationInfo['province']; ?>" required>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" maxlength="10" value="<?php echo $reservationInfo['postal_code']; ?>" required>
        </div>

        <div class="form-group">
            <label for="house_type">House Type:</label>
            <input type="text" id="house_type" name="house_type" maxlength="100" value="<?php echo $reservationInfo['house_type']; ?>" required>
        </div>

        <div class="form-group">
            <label for="service_type">Service Type:</label>
            <input type="text" id="service_type" name="service_type" maxlength="20" value="<?php echo $reservationInfo['service_type']; ?>" required>
        </div>

        <div class="form-group">
            <label for="service_area">Service Area:</label>
            <input type="text" id="service_area" name="service_area" maxlength="20" value="<?php echo $reservationInfo['service_area']; ?>" required>
        </div>

        <div class="form-group">
            <label for="service_item">Service Item:</label>
            <input type="text" id="service_item" name="service_item" maxlength="100" value="<?php echo $reservationInfo['service_item']; ?>" required>
        </div>

        <div class="form-group">
            <label for="service_content">Service Content:</label>
            <input type="text" id="service_content" name="service_content" maxlength="50" value="<?php echo $reservationInfo['service_content']; ?>" required>
        </div>

        <div class="form-group">
            <label for="service_details">Service Details:</label>
            <input type="text" id="service_details" name="service_details" maxlength="50" value="<?php echo $reservationInfo['service_details']; ?>" required>
        </div>

        <div class="form-group">
            <label for="customer_prefer_service_date">Prefer Service Date:</label>
            <input type="text" id="customer_prefer_service_date" name="customer_prefer_service_date" maxlength="50" value="<?php echo $reservationInfo['customer_prefer_service_date']; ?>" required>
        </div>

        <div class="form-group">
            <label for="photo">Upload Photos:</label>
            <?php if (!empty($reservationInfo['photos'])) {
                $photos = explode(",", $reservationInfo['photos']);
                foreach ($photos as $photo) { ?>
                <img src="<?php echo $photo; ?>" alt="Service Photo" width="150">
            <?php }
            } else { ?>
                No photos available
            <?php } ?>
        </div>

        <div class="form-group submit-button">
            <input type="submit" value="Save Information">
        </div>
    </form>
    <?php } ?>
</body>
</html>