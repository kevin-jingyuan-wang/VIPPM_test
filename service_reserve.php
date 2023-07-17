order_show_db.php
<?php
    session_start();

    // Check if the user is logged in and the user type is "user"
    if (!(isset($_SESSION['username']) && $_SESSION['user_type'] === 'user')) {
        header("Location: index.php");
        exit;
    }

    // Display error message, if any
    if (isset($_SESSION['error_message'])) {
        echo '<p class="error">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);
    }

    // Display success message, if any
    if (isset($_SESSION['success_message'])) {
        echo '<p class="success">' . $_SESSION['success_message'] . '</p>';
        unset($_SESSION['success_message']);
    }
    ?>



<!DOCTYPE html>
<html>
<head>
    <title>Service Reserve Request</title>
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

        .upload-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <h2>Service Reserve Request</h2>

    <form method="POST" action="service_reserve_db.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="contact_email">Contact Email:</label>
            <input type="email" id="contact_email" name="contact_email" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="contact_phone">Contact Phone:</label>
            <input type="text" id="contact_phone" name="contact_phone" maxlength="20" required>
        </div>

        <div class="form-group">
            <label for="house_address">House Address:</label>
            <input type="text" id="house_address" name="house_address" maxlength="100" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <select id="province" name="province" required>
                <option value="">Select Province</option>
                <option value="Alberta">Alberta</option>
                <option value="British Columbia">British Columbia</option>
                <option value="Manitoba">Manitoba</option>
                <option value="New Brunswick">New Brunswick</option>
                <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                <option value="Nova Scotia">Nova Scotia</option>
                <option value="Ontario">Ontario</option>
                <option value="Prince Edward Island">Prince Edward Island</option>
                <option value="Quebec">Quebec</option>
                <option value="Saskatchewan">Saskatchewan</option>
                <option value="Northwest Territories">Northwest Territories</option>
                <option value="Nunavut">Nunavut</option>
                <option value="Yukon">Yukon</option>
            </select>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" maxlength="7" required>
        </div>

        <div class="form-group">
            <label for="house_type">House Type:</label>
            <select id="house_type" name="house_type" required>
                <option value="">Select House Type</option>
                <option value="house">House</option>
                <option value="townhouse">Townhouse</option>
                <option value="apartment">Apartment</option>
                <option value="condo">Condo</option>
                <option value="duplex">Duplex</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_type">Service Type:</label>
            <select id="service_type" name="service_type" required>
                <option value="">Select Service Type</option>
                <option value="repair">Repair</option>
                <option value="maintenance">Maintenance</option>
                <option value="cleaning">Cleaning</option>
                <option value="moving">Moving/Transportation</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_area">Service Area:</label>
            <select id="service_area" name="service_area" required>
                <option value="">Select Service Area</option>
                <option value="kitchen">Kitchen</option>
                <option value="bedroom">Bedroom</option>
                <option value="bathroom">Bathroom</option>
                <option value="laundry room">Laundry Room</option>
                <option value="garden">Garden</option>
                <option value="roof">Roof</option>
                <option value="attic">Attic</option>
                <option value="basement">Basement</option>
                <option value="driveway">Driveway</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_item">Service Item:</label>
            <select id="service_item" name="service_item" required>
                <option value="">Select Service Item</option>
                <option value="washing machine">Washing Machine</option>
                <option value="dishwasher">Dishwasher</option>
                <option value="faucet">Faucet</option>
                <option value="sink">Sink</option>
                <option value="outlet">Outlet</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_content">Service Content:</label>
            <select id="service_content" name="service_content" required>
                <option value="">Select Service Content</option>
                <option value="drainage problem">Drainage Problem</option>
                <option value="malfunctioning">Malfunctioning</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_details">Service Details:</label>
            <textarea id="service_details" name="service_details" rows="5" cols="30"></textarea>
        </div>

        <div class="form-group">
            <label for="customer_prefer_service_date">Prefer Service Date:</label>
            <input type="text" id="customer_prefer_service_date" name="customer_prefer_service_date" maxlength="100" required>
        </div>

        <div class="form-group">
            <label for="photos">Upload Photos:</label>
            <input type="file" id="photos" name="photos[]" accept="image/*" multiple>
        </div>

        <div class="form-group">
            <label for="captcha">CAPTCHA:</label>
            <input type="text" name="captcha" id="captcha" required><br>
            <img src="captcha.php?action=image&t=<?php echo time(); ?>" alt="Captcha Image"><br>
        </div>

        <div class="form-group">
            <label></label>
            <span style="font-size: 12px;">Make sure to provide correct contact information and clear description of your requirements.</span>
        </div>

        <div class="form-group submit-button">
            <input type="submit" value="Submit">
        </div>
    </form>
</body>
</html>