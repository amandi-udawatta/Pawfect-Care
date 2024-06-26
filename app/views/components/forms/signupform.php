 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="<?php echo ROOT?>/assets/css/forms.css">
</head>
<body>
    <div class="form-container">
    <form id="sign-up-form" method="POST">
            <h1>Sign Up</h1>
            
            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full-name" required><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br>

            <label for="contact-number">Contact Number:</label>
            <input type="tel" id="contact-number" name="contact-number" required pattern="[0-9]{10}"><br>

            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required><br>

           
            <div class="flex-container">
                <button type="submit" id="sign-up-button" onclick="signUp()">Sign Up</button>
            </div>
        </form>
    </div>

    <script src="signupform.js"></script>
</body>
</html> 

