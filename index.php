<?php include_once "php/header.php"; ?>
<body>
    <!-- Sign Up Form -->
    <div class="wrapper">
        <section class="form signup">
            <header>Chat Application</header>
            <form action="#" enctype="multipart/form-data">
                <div class="error-text">This is an error message.</div>
                <div class="names">
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" placeholder="First Name" name="fname" required>
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" placeholder="Last Name" name="lname" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email</label>
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" placeholder="Password" name="password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field image">
                    <label>Select Image</label>
                    <input type="file" name="img" required>
                </div>
                <div class="field submit">
                    <input type="submit" value="Register">
                </div>
            </form>
            <div class="link">Already Have an account? <a href="login.php">Login</a></div>
        </section>
    </div>

    <!-- External JS -->
    <script src="js/password.js"></script>
    <script src="js/signup.js"></script>
</body>
</html>