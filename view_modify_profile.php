<?php
session_start();
require_once('view_modify_profile_db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>View/Modify User Information</title>
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

    <h2>View/Modify User Information</h2>

    <?php if (!isset($_GET['edit'])) { ?>
    <!-- Display non-editable user information -->
    <form>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="50" value="<?php echo $userInfo['first_name']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="50" value="<?php echo $userInfo['last_name']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $userInfo['gender']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" maxlength="100" value="<?php echo $userInfo['email']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" maxlength="20" value="<?php echo $userInfo['phone']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="emergency_phone">Emergency Phone:</label>
            <input type="text" id="emergency_phone" name="emergency_phone" maxlength="20" value="<?php echo $userInfo['emergency_phone']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" maxlength="100" value="<?php echo $userInfo['address']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="50" value="<?php echo $userInfo['city']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" maxlength="50" value="<?php echo $userInfo['province']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" maxlength="10" value="<?php echo $userInfo['postal_code']; ?>" readonly>
        </div>

        <div class="form-group submit-button">
            <a href="view_modify_profile.php?edit=true">Edit Information</a>
        </div>
    </form>
    <?php } else { ?>
    <!-- Display editable user information -->
    <form method="POST" action="view_modify_profile_db.php">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="50" value="<?php echo $userInfo['first_name']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="50" value="<?php echo $userInfo['last_name']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" <?php if(!isset($_GET['edit'])) { echo "disabled"; } ?> required>
                <option value="">-- Select Gender --</option>
                <option value="Male" <?php if ($userInfo['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($userInfo['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Prefer not to respond" <?php if ($userInfo['gender'] == 'Prefer not to respond') echo 'selected'; ?>>Prefer not to respond</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" maxlength="100" value="<?php echo $userInfo['email']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" maxlength="20" value="<?php echo $userInfo['phone']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="emergency_phone">Emergency Phone:</label>
            <input type="text" id="emergency_phone" name="emergency_phone" maxlength="20" value="<?php echo $userInfo['emergency_phone']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?>>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" maxlength="100" value="<?php echo $userInfo['address']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="50" value="<?php echo $userInfo['city']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" maxlength="50" value="<?php echo $userInfo['province']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" maxlength="10" value="<?php echo $userInfo['postal_code']; ?>" <?php if(!isset($_GET['edit'])) { echo "readonly"; } ?> required>
        </div>

        <?php if (isset($_GET['edit'])) { ?>
        <div class="form-group submit-button">
            <input type="submit" value="Save Information">
        </div>
        <?php } ?>
    </form>
    <?php } ?>
</body>
</html>