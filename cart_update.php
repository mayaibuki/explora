<?php
session_start(); //start session
include_once("functions.php"); //include config file

$reference = 'explora.life-'.session_id();
$query = "SELECT * FROM orders WHERE reference='$reference' LIMIT 1";
$query_new = "INSERT INTO orders SET reference='$reference'";
$c_result = $mysqli->query($query);
if($c_result){
    $cobj = $c_result->fetch_object();
    if($cobj){
        $cart_id = $cobj->order_id;
    } else{
        $mysqli->query($query_new);
        $cart_id = $mysqli->insert_id;
    }
}
//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
    $return_url = base64_decode($_GET["return_url"]); //return url
    session_destroy();
    $mysqli->query("DELETE FROM order_item WHERE order_id='$cart_id'");
    header('Location:/cart/');
}

//add item in shopping cart
if(isset($_POST["type"]) && $_POST["type"]=='add')
{
    $product_code   = filter_var($_POST["product_id"], FILTER_SANITIZE_STRING); //product code
    $product_qty    = filter_var($_POST["product_qty"], FILTER_SANITIZE_NUMBER_INT); //product code
    $return_url     = base64_decode($_POST["return_url"]); //return url

    //MySqli query - get details of item from db using product code
    $results = $mysqli->query("SELECT name,price FROM product WHERE product_id='$product_code' LIMIT 1");
    $obj = $results->fetch_object();
    
    if ($results) { //we have the product info 

        //prepare array for the session variable
        $new_product = array(array('name'=>$obj->name, 'code'=>$product_code, 'qty'=>$product_qty, 'price'=>$obj->price));
        $p_result = $mysqli->query("SELECT * FROM order_item WHERE order_id='$cart_id' LIMIT 1");
            $name = $obj->name;
            if($p_result){
                $pobj = $p_result->fetch_object();
                if ($pobj) {
                    $mysqli->query("UPDATE order_item SET quantity='$product_qty', product_id='$product_code' WHERE name='$name'");
                } else{
                    $mysqli->query("INSERT INTO order_item SET order_id='$cart_id', quantity='$product_qty', name='$name', price='$obj->price', product_id='$product_code'");
                }
            }
        if(isset($_SESSION["products"])) //if we have the session
        {
            $found = false; //set found item to false
            foreach ($_SESSION["products"] as $cart_itm) //loop through session array
            {
                if($cart_itm["code"] == $product_code){ //the item exist in array

                    $product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$product_qty, 'price'=>$cart_itm["price"]);
                    $found = true;
                    $_SESSION["count"] = ($_SESSION["count"] - $cart_itm["qty"])+$product_qty;  
                }else{
                    //item doesn't exist in the list, just retrive old info and prepare array for session var
                    $product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
                }
            }
            
            if($found == false) //we didn't find item in array
            {
                //add new user item in array
                $_SESSION["products"] = array_merge($product, $new_product);
                $_SESSION["count"] += $product_qty;
            }else{
                //found user item in array list, and increased the quantity
                $_SESSION["products"] = $product;
            }
            
        }else{
            //create a new session var if does not exist
            $_SESSION["products"] = $new_product;
            $_SESSION["count"] = $product_qty;
        }
        
    }
    
    //redirect back to original page
    header('Location:/cart/');
}

//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{
    $product_code   = $_GET["removep"]; //get the product code to remove
    $return_url     = base64_decode($_GET["return_url"]); //get return url
    $mysqli->query("DELETE FROM order_item WHERE order_id='$cart_id' AND product_id='$product_code' LIMIT 1");
    
    foreach ($_SESSION["products"] as $cart_itm) //loop through session array var
    {
        if($cart_itm["code"]!=$product_code){ //item does,t exist in the list
            $product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
        } else{
            $_SESSION["count"] -= $cart_itm['qty'];
        }
        
        //create a new product list for cart
        $_SESSION["products"] = $product;
    }
    
    //redirect back to original page
    header('Location:/cart/');
}