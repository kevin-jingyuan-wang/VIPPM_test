<?php
    session_start();

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
    <title>Sign Up</title>
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
        input[type="password"],
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

    <h2>User Registration</h2>

    <form method="POST" action="signup_db.php">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Prefer not to respond">Prefer not to respond</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" pattern="[0-9]{10}" required>
        </div>

        <div class="form-group">
            <label for="emergency_phone">Emergency Phone:</label>
            <input type="text" id="emergency_phone" name="emergency_phone" pattern="[0-9]{10}">
            <span>(Optional)</span>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <select id="province" name="province" required>
                <option value="">-- Select Province --</option>
                <option value="AB">Alberta</option>
                <option value="BC">British Columbia</option>
                <option value="MB">Manitoba</option>
                <option value="NB">New Brunswick</option>
                <option value="NL">Newfoundland and Labrador</option>
                <option value="NS">Nova Scotia</option>
                <option value="ON">Ontario</option>
                <option value="PE">Prince Edward Island</option>
                <option value="QC">Quebec</option>
                <option value="SK">Saskatchewan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" pattern="[A-Za-z]\d[A-Za-z] \d[A-Za-z]\d" required>
            <span>(e.g., A1B 2C3)</span>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" maxlength="50" required>
        </div>

        <div class="form-group">
            <label for="captcha">CAPTCHA:</label>
            <input type="text" name="captcha" id="captcha" required><br>
            <img src="captcha.php?action=image&t=<?php echo time(); ?>" alt="Captcha Image"><br>
        </div>

        <div class="form-group submit-button">
            <input type="submit" value="Sign Up">
        </div>
    </form>
</body>
</html>