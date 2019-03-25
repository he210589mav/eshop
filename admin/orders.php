<?php
header('Content-Type: text/html; charset=utf-8');
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/db.inc.php";
?>
<html>
<head>
	<title>Поступившие заказы</title>
</head>
<body>
<h1>Поступившие заказы:</h1>
<?php
getOrders();
$orders=getOrders();
foreach ( $orders as $order) {
	
    
?>
<hr>
<h2>Заказ номер: <?=$order['orderid']?></h2>
<p><b>Заказчик</b>:<?=$order['name']?> </p>
<p><b>Email</b>: <?=$order['email']?></p>
<p><b>Телефон</b>: <?=$order['phone']?></p>
<p><b>Адрес доставки</b>:<?=$order['address']?> </p>
<p><b>Дата размещения заказа</b>:<?=date("d-m-Y H:i:s",$order['date'])?> </p>


<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, грн.</th>
	<th>Количество</th>
</tr>

	<tr>
		<td><?=$n?></td>
		<td><?=$order['title']?></td>
		<td><?=$order['author']?></td>
		<td><?=$order['pubyear']?></td>
		<td><?=$order['price']?></td>
		<td><?=$order['quantity']?></td>
</table>
</table>
</table>
<p>Всего товаров в заказе на сумму: грн.</p>
<?php } 
?>
</body>
</html>