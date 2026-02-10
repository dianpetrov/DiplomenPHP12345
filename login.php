<?php
session_start();

/* Ако вече е логнат → пращаме в магазина */
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$msg = "";

if (isset($_POST["login"])) {
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    require_once "database.php";

    /* Взимаме user по email */
    $sql = "SELECT user_id, user_name, email, password_hash, roles 
            FROM users 
            WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user["password_hash"])) {

            /* Записваме в сесията */
            $_SESSION["user_id"]   = $user["user_id"];
            $_SESSION["user_name"] = $user["user_name"];
            $_SESSION["roles"]     = $user["roles"];

            /* ВСИЧКИ отиват първо в магазина */
            header("Location: index.php");
            exit;

        } else {
            $msg = "<div class='msg msg-error'>Password does not match</div>";
        }
    } else {
        $msg = "<div class='msg msg-error'>Email does not match</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php echo $msg; ?>

    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" class="primary-btn" name="login">
            Login
        </button>
    </form>

    <p class="bottom-text">
        Not registered yet?
        <a href="registration.php">Register Here</a>
    </p>
</div>

</body>
</html>
