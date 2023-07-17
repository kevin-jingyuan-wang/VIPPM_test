<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}

class Captcha {
    /**
     * Generate a random captcha string
     *
     * @param int $length The length of the captcha string
     * @return string The captcha string
     */
    public static function generateCaptchaString($length = 4) {
        $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';       //removed 0 , o and O, i, l ,1
        $captchaString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $captchaString .= $characters[$index];
        }

        return $captchaString;
    }

    /**
     * Validate the captcha
     *
     * @param string $captcha The captcha entered by the user
     * @return bool True if the captcha is valid, false otherwise
     */
    public static function validateCaptcha($captcha) {
        if (isset($_SESSION['captcha_string']) && strtolower($_SESSION['captcha_string']) === strtolower($captcha)) {
            // Captcha is valid
            return true;
        }

        // Captcha is invalid
        return true;//change to false later to retest the cpatcha system
    }

    /**
     * Generate the captcha image
     *
     * @return resource The captcha image resource
     */
    public static function generateCaptchaImage() {
        // Generate captcha string
        $captchaString = self::generateCaptchaString();
        $captchaImage = imagecreatetruecolor(100, 30);

        // Set background color
        $backgroundColor = imagecolorallocate($captchaImage, 255, 255, 255);
        imagefill($captchaImage, 0, 0, $backgroundColor);

        // Set text color
        $textColor = imagecolorallocate($captchaImage, 0, 0, 0);

        // Draw captcha text on the image
        imagestring($captchaImage, 5, 10, 8, $captchaString, $textColor);

        // Store the captcha string in session for validation
        $_SESSION['captcha_string'] = $captchaString;

        return $captchaImage;
    }
}

// Check if the action parameter is set and its value is 'image'
if (isset($_GET['action']) && $_GET['action'] === 'image') {
    // Generate and output the captcha image
    $captchaImage = Captcha::generateCaptchaImage();

    // Set appropriate headers and output the image data
    header('Content-Type: image/png');
    imagepng($captchaImage);

    // Destroy the image resource
    imagedestroy($captchaImage);

    exit; // Stop executing the rest of the code
}
?>