<?php
$DB_HOST='localhost';
$DB_LOGIN='root';
$DB_PASSWORD='';
$DB_NAME='eshop';
$ORDERS_LOG='orders.log';
$basket=[];
$count=0;
$link = mysqli_connect("$DB_HOST", "$DB_LOGIN", "$DB_PASSWORD", "$DB_NAME");
    if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL,"<br>";
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL,"<br>";
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL,"<br>";
    exit;
     }
basketInit();
?>