<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realtime Chat Application</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Sign Up Form -->
    <div class="wrapper">
        <section class="form signup">
            <header>Realtime Chat Application</header>
            <form action="#">
                <div class="error-text">This is an error message.</div>
                <div class="field input">
                    <label>Email</label>
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" placeholder="Password" name="password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field submit">
                    <input type="submit" value="Login">
                </div>
            </form>
            <div class="link">Don't have an account? <a href="index.php">Register</a></div>
        </section>
    </div>

    <!-- External JS -->
    <script src="js/password.js"></script>
    <script src="js/login.js"></script>
</body>
</html>