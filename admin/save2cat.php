<?php
header('Content-Type: text/html; charset=utf-8');
	// подключение библиотек
	//require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/db.inc.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = clearString($link, $_POST['title']);
        $author = clearString($link, $_POST['author']);
        $pubyear = clearInt($_POST['pubyear']);
        $price = clearInt($_POST['price']);

if(!addItemToCatalog($link,$title,$author,$pubyear,$price))
{
	echo 'Произошла ошибка при добавлении товара в каталог';
}
    else{
	header("Location: add2cat.php");
	exit;
}
}
?>