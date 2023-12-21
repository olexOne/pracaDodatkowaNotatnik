<?php
require_once "db.php";

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addNote"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $category = $_POST["category"];
    $user_id = $_SESSION["user_id"];

    $category_id = getCategoryID($category, $user_id);

    $sql = "INSERT INTO Notes (title, content, category_id, user_id) VALUES ('$title', '$content', '$category_id', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Udało ci się dodać notatkę!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getCategoryID($category, $user_id)
{
    global $conn;

    $sql = "SELECT id FROM Categories WHERE name = '$category' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["id"];
    } else {
        $sql = "INSERT INTO Categories (name, user_id) VALUES ('$category', '$user_id')";
        $conn->query($sql);

        $sql = "SELECT id FROM Categories WHERE name = '$category' AND user_id = '$user_id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        return $row["id"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Twój prywatny notatnik</title>
</head>

<body>
    <div class="container">
        <div id="addNoteForm">
            <h3>Notatnik</h3>
            <form id="addNote" action="notes.php" method="post">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="content" placeholder="Content" required></textarea>
                <input type="text" name="category" placeholder="Category" required>
                <button type="submit" name="addNote">Dodaj notatkę</button>
            </form>
        </div>
    </div>
</body>

</html>