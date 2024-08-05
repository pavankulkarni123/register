<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Responsive Registration Form</title>
</head>
<body>
    <div class="container">
        <header>Registration</header>
        <form action="submit.php" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" name="full_name" placeholder="Enter your name" required>
                        </div>
                        <div class="input-field">
                            <label>Gender</label>
                            <select name="gender" required>
                                <option disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" name="birth_date" placeholder="Enter birth date" required>
                        </div>
                        <div class="input-field">
                            <label>Country Code</label>
                            <select name="country_code" id="country_code" placeholder="Select your Country Code" required>
                                <option disabled selected>Select your country code</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="mobile_number" placeholder="Enter mobile number" required>
                        </div>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="input-field">
                            <label>Country</label>
                            <select name="country" id="country" placeholder="Select your Country" required>
                                <option disabled selected>Select your country</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>State</label>
                            <select name="state" id="state" placeholder="Select your State" required>
                                <option disabled selected>Select your state</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>City</label>
                            <select name="city" id="city" placeholder="Select your City" required>
                                <option disabled selected>Select your city</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button class="submit">
                        <span class="btnText">Submit</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div>
            </div> 
        </form>
    </div>
    <script src="app.js"></script>
</body>
</html>
