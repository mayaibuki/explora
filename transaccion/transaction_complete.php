<?php
header("Access-Control-Allow-Origin: *");
$ApiKey = 'Khrho3F1omIZYrvOMNXAYRU1FI';
$merchant_id = $_POST['merchantId'];
$state_pol = $_POST['state_pol'];
$reference = $_POST['reference_sale'];
$email = $_POST['email_buyer'];
$shippingCity = $_POST['shipping_city'];
$shippingCountry = $_POST['shipping_country'];
$shippingAddress = $_POST['shipping_address'];
$telephone = $_POST['phone'];
$value = $_POST['value'];
$date = $_POST['date'];
$name = $_POST['nickname_buyer'];
$referenceCode = $_POST['extra1'];
$discount_id = $_POST['extra2'];
$valor = $_POST['value'];
@include_once '../functions.php';

$order_result = $mysqli->query("SELECT * FROM orders WHERE reference='$reference' LIMIT 1");
$order = $order_result->fetch_object();
$items = $mysqli->query("SELECT * FROM order_item WHERE order_id='$order->order_id'");

if($state_pol==4){
	$mysqli->query("UPDATE orders SET name='$name', email='$email', city='$shippingCity', country='$shippingCountry', address='$shippingAddress', telephone='$telephone', transaction_date='$date', payed=true, amount='$value' WHERE order_id='$order->order_id'")	or die('Could not query:' . mysqli_error());
	$mysqli->query("UPDATE codes SET total_sold=total_sold+'$valor', times_used=times_used+1");
	if(!$order->stock_discount){
		while($itm = $items->fetch_assoc()){
			$qty = $itm['quantity'];
			$p_id = $itm['product_id'];
			$mysqli->query("UPDATE product SET stock=stock-'$qty' WHERE product_id='$p_id'");
		}

		$mysqli->query("UPDATE orders SET stock_discount=TRUE WHERE order_id='$order->order_id'");

	}

} else{

	$mysqli->query("UPDATE orders SET name='$name', email='$email', city='$shippingCity', country='$shippingCountry', address='$shippingAddress', telephone='$telephone', transaction_date='$date', payed=false, amount='$value', pending=false WHERE order_id='$order->order_id' ")	or die('Could not query:' . mysqli_error());

	if($order->stock_discount){
		while($itm = $items->fetch_assoc()){
			$qty = $itm['quantity'];
			$p_id = $itm['product_id'];
			$mysqli->query("UPDATE product SET stock=stock+'$qty' WHERE product_id='$p_id'");
		}

		$mysqli->query("UPDATE orders SET stock_discount=false WHERE order_id='$order->order_id'");

	}
}

?>