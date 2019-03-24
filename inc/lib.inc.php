<?php
 function clearString($link,$data){
	return mysqli_real_escape_string($link, trim(strip_tags($data)));
     }
function clearInt($data){
	return abs((int)$data);
     }
function addItemToCatalog($link,$title,$author,$pubyear,$price){
	$sql = "INSERT INTO catalog (title, author, pubyear, price) VALUES (?,?,?,?)";
    if (!$stmt=mysqli_prepare($link,$sql)){
        return false;
    } else
    mysqli_stmt_bind_param($stmt,'ssii', $title,$author,$pubyear,$price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
    }
function selectAllItems($link){//то что в базе есть список книг
	$sql="SELECT id,title,author,pubyear,price FROM catalog";
	if(!$result=mysqli_query($link,$sql)){
		return false;
	}
	else
	$items=mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $items;
    }
function saveBasket(){ //сохраняет корзину с товарами в куки
	global $basket;
	$basket=base64_encode(serialize($basket));
	setcookie('basket',$basket,0x7FFFFFFF);
    }
function basketInit(){ //создает либо загружает в переменную $basket корзину с товарами
	global $basket,$count;
	if(!isset($_COOKIE['basket'])){
		$basket=array('orderid'=>uniqid());
		saveBasket();
	}else{
		$basket=unserialize(base64_decode($_COOKIE['basket']));
		$count=count($basket)-1;
	}
	}
function add2Basket($id){ //добавляет товар в корзину пользователя и принимает в качестве аргумента идентификатор товара
    global $basket;
    $basket[$id]=1;
    saveBasket();
    }
function myBasket(){ //возвращает корзину в виде ассоциативного массива
	global $link,$basket;
	$goods=array_keys($basket);
	array_shift($goods);
	$ids=implode(",",$goods);
	$sql="SELECT id,title,author,title,pubyear,price FROM catalog WHERE id IN ($ids)";
	if(!$result=mysqli_query($link,$sql))
		return false;
	$items=result2Array($result);
	mysqli_free_result($result);
	return $items;
    }
function result2Array($data){ //принимает результат выполнения функции myBasket и возвращает ассоциативный массив товаров дополненный их количеством
	global $basket;
	$arr=array();
	while($row=mysqli_fetch_assoc($data)){
		$row['quantity']=$basket[$row['id']];
		$arr[]=$row;
	}
	return $arr;
    }
function deleteItemFromBasket($id){
	global $basket;
    unset($basket[$id]);
    saveBasket();
    }
function saveOrder($datetime){
	global $link,$basket;
	$goods=myBasket();
	$stmt=mysqli_stmt_init($link);
	$sql="INSERT INTO orders (title,author,pubyear,price,quantity,orderid,datetime) VALUES (?,?,?,?,?,?,?)";
	if(!mysqli_stmt_prepare($stmt,$sql))
		return false;
	foreach ($goods as $item){
		mysqli_stmt_bind_param($stmt,"ssiiisi", $item['title'],$item['author'],$item['pubyear'],$item['price'],$item['quantity'],$item['orderid'],$item['datetime']);
		mysqli_stmt_execute($stmt);
		}
	mysqli_stmt_close($stmt);
	$basket=base64_encode(serialize($basket));
	setcookie('basket',$basket,time()-3600);
	return true;
    }
?>