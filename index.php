<?php
require_once "db.php";

$visited = isset($_COOKIE["visited"]);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actionType"])) {
    if ($visited) {
        if ($_POST["actionType"] === "login") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $sql = "SELECT * FROM Users WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["password"])) {
                    session_start();
                    $_SESSION["user_id"] = $row["id"];
                    header("Location: notes.php");
                    exit();
                } else {
                    echo "<script>alert('Nie tym razem hakerze :)');</script>";
                }
            }
        }
    } else {
        if ($_POST["actionType"] === "register") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Udało ci się zalogować!');</script>";
                $visited = true;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

setcookie("visited", "1", time() + (86400 * 30), "/");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Notatnik</title>
</head>
<body>
    <div class="container">
        <?php if ($visited): ?>
            <div id="addNoteForm">
                <h3>Dodaj notatkę</h3>
            </div>
        <?php else: ?>
            <div id="registerForm">
                <h3>Rejestracja</h3>
                <form id="register" action="index.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="register">Zarejestruj się</button>
                </form>
            </div>
        <?php endif; ?>

        <div id="loginForm">
            <h3>Logowanie</h3>
            <form id="login" action="index.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Zaloguj się</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>