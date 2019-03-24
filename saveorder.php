<?php
header('Content-Type: text/html; charset=utf-8');
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
$orid=array_shift($basket);
$order=$_POST['name'].'|'.$_POST['email'].'|'.$_POST['phone'].'|'.$_POST['address'].'|'.$orid.'|'.$datetime=time();
$fp = fopen("$ORDERS_LOG", "a");
fwrite($fp, $order . PHP_EOL);
fclose($fp);
saveOrder($datetime);
?>
<html>
<head>
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>