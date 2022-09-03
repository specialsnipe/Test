<?php
session_start();
require_once 'consoleLog.php';
require_once 'DB.php';

$pagePosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$pageComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
preg_match_all('#{(.+?)}#su', $pagePosts, $posts);
preg_match_all('#{(.+?)}#su', $pageComments, $comments);

function getDecode($arr)
{
    $result = [];
    foreach ($arr as $item) {
        $result[] = json_decode($item, true);
    }
    return $result;
}

$countPosts = count($posts[0]);
$countComments = count($comments[0]);

$decodePosts = getDecode($posts[0]);
$decodeComments = getDecode($comments[0]);


$db = new DB();
foreach ($decodePosts as $key => $value) {

    $val1= mysqli_real_escape_string($db->connect, $value['userId']);
    $val2= mysqli_real_escape_string($db->connect, $value['id']);
    $val3= mysqli_real_escape_string($db->connect, $value['title']);
    $val4= mysqli_real_escape_string($db->connect, $value['body']);
    $query = "INSERT INTO `posts` (`userId`, `id`, `title`, `body`) VALUES ('".$val1."','".$val2."','".$val3."','".$val4."')";
    $addPosts = mysqli_query($db->connect, $query);
    if (!$addPosts) {
        $countPosts = null;
    }
}

foreach ($decodeComments as $key => $value) {

    $val1= mysqli_real_escape_string($db->connect, $value['postId']);
    $val2= mysqli_real_escape_string($db->connect, $value['id']);
    $val3= mysqli_real_escape_string($db->connect, $value['name']);
    $val4= mysqli_real_escape_string($db->connect, $value['email']);
    $val5= mysqli_real_escape_string($db->connect, $value['body']);
    $query = "INSERT INTO `comments` (`postId`, `id`, `name`, `email`, `body`) VALUES ('".$val1."','".$val2."','".$val3."','".$val4."','".$val5."')";
    $addComments = mysqli_query($db->connect, $query);
    if (!$addComments) {
        $countComments = null;
    }
}


if(isset($countPosts)&& isset($countComments)) {
    $_SESSION['posts'] = $countPosts;
    $_SESSION['comments'] = $countComments;
}

header("Location: http://test/index.php");
exit( );
?>
