<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawfect Care - Sign Up</title>
    <link rel="stylesheet" href="<?=ROOT?>assets/css/signup.css">
   
</head>
<body>
  
   <div>
   <div class="logo">
                    <img src="<?=ROOT?>assets/images/footer-logo.png" alt="Pawfect Care Logo">
     </div>

    <div class="container">
        <div class="img-container">
            <img src="<?=ROOT?>assets/images/signup-photo.jpg" alt="Sign Up Photo">
        </div>
          
        <div class="form-container">
            <form method="post">
               
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
                
                <input type="checkbox" name="terms" checked> I agree to the terms and conditions.
               
                <div class="flex-container">
                    <button class="button" type="submit" name="signup">Sign up</button>
                </div>
                <p>Already have an account? <a href="<?=ROOT?>/login">Login</a>.</p>
                
            </form>
               
        </div>
       
    </div>
</body>
</html>
