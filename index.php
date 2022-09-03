<?php
require_once 'Services/DB.php';
require_once 'Services/consoleLog.php';

session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Тестовое задание</title>
    <style>
        th, td {
            padding: 10px;
        }

        th {
            background: grey;
        }

        td {
            background: #f1f1eb;
        }
    </style>
</head>
<body>
<a href="http://test/Services/parse.php">Загрузить в бд данные с сайтов</a>
<br>
<br>

<?php if (isset ($_SESSION['posts']) && isset($_SESSION['comments'])) {
    console_log($_SESSION['posts'], $_SESSION['comments']);
    Session_destroy();
}
?>

<form action=""<?= $_SERVER['REQUEST_URI'] ?>"" method="post">
<input type="text" name="search" ">
<input type="submit" value="Найти"/>
</form>

<?php
$_SESSION['search'] = $_REQUEST['search'];
if (isset($_REQUEST['search'])) {

    $inputSearch = $_REQUEST['search'];
    if (strlen($_REQUEST['search']) >= 3) {
        $sql = "SELECT p.id, p.title,c.id, c.body FROM `posts` AS p INNER JOIN `comments` AS c ON p.id = c.postId WHERE c.body LIKE '%" . $inputSearch . "%'";
        $db = new DB();
        $result = mysqli_query($db->connect, $sql);
        $result = mysqli_fetch_all($result);
    }
}
?>

<table>
    <tr>
        <th>ID записи</th>
        <th>Заголовок записи</th>
        <th>ID комментария</th>
        <th>Комментарий</th>
    </tr>
    <?php if (isset($result)) {
        foreach ($result as $row) {
            $newRow = str_replace($inputSearch, "<b>{$inputSearch}</b>", $row[3]);

            echo "
            <tr>
                <td>{$row[0]} </td>
                <td>{$row[1]}</td>
                <td>{$row[2]}</td>
                <td>{$newRow}</td>
                
            </tr>
           ";
        }
    } ?>
</table>
</body>
</html>



















