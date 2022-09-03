<?php
function console_log(int $countPosts = 0, int $countComments = 0)
{
    echo("<script>console.log('Загружено {$countPosts} записей и {$countComments} комментариев');</script>");
}