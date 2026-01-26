<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <link rel="stylesheet" href="~/css/loginForm.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel ="stylesheet" href="login.css">
    

</head>
<body>

<div class="container">
    <?php
        if (isset($_POST["submit"])) {
        $fullName = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["repeat_password"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = array();
        
        if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat) || empty($address) || empty($phone)) {
        $errors[] = "All fields are required";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
        if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
        }
        if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
        }
        require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount>0) {
            array_push($errors,"Email already exists!");
        }
           $sql = "SELECT * FROM users WHERE phone = '$phone'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        $errors[] = "Phone already exists!";
        }

        if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }else{
            
            $sql = "INSERT INTO users(user_name, email, password_hash, address, phone)VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sssss",$fullName, $email, $passwordHash, $address, $phone);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
        }
        

        }
        ?>
    <h2>Create account</h2>
<form action="registration.php"  method="post">
    <div class = "form-group">
    <input type="text" class = "form-control" name = "fullname" placeholder="Full name" required /> 
    </div>
    <div class = "form-group">
    <input type="email" class = "form-control" name = "email" placeholder="youremail@" required />
    </div>
    <div class = "form-group">
    <input type="password" class = "form-control" name = "password" placeholder="password" required />
    </div>
    <div class = "form-group">
    <input type="text" class="form-control" name="address" placeholder="Address" required />
    </div>
    <div class = "form-group">
    <input type="text" class="form-control" name="phone" placeholder="Phone" required />
    </div>
    <div class = "form-group">
    <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password" required />
    </div>
    <div class="form-btn">
        <input type="submit" class = "btn btn-primary" value = "Register" name = "submit">
    </div>
    
    

    
</form>
    <p class="signup-text">
        Already have an account?
        <a href="/login-register/login.php">Login</a>
    </p>
</div>

</body>
</html>
