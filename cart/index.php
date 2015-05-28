<?php
session_start();
@include_once '../functions.php';
include_once '../_contenido/_header.php';

echo '<body><br><br>';
$currency = '$';
$current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
include '../_contenido/navigation_producto.php';
?>

<section>
  <div class="container">
    <div class="row">
	    <div class="col-sm-offset-2 col-sm-8">
	      <h1>Tu Carrito</h1>
	
	      <?php
	      if(isset($_SESSION["products"]))
	      {
	        $total = 0;
	        echo '<form method="post" action="PAYMENT-GATEWAY">';
	        echo '<table class="table">';
	        echo '<thead><tr><th></th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Precio Total</th><th></th></thead>';
	        $cart_items = 0;
	        foreach ($_SESSION["products"] as $cart_itm)
	        {
	         $product_code = $cart_itm["code"];
	         $results = $mysqli->query("SELECT name,description,price FROM product WHERE product_id='$product_code' LIMIT 1");
	         $obj = $results->fetch_object();
	         $img_results = $mysqli->query("SELECT full_img FROM product_img WHERE product_id='$product_code' LIMIT 1");
	         $img = $img_results->fetch_object();
	
	         echo '<tr class="cart-itm">';
	
	
	         echo '<td><img src="/media/timthumb.php?src='.$img->full_img.'&amp;h=50"></td>';
	         echo '<td><h4>'.$obj->name.'</h4></td> ';
	         echo '<td><div class="p-price">'.$currency.number_format($obj->price).'</div></td>';
	         echo '<td><div class="p-qty">'.$cart_itm["qty"].'</div></td>';
	         $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
	         echo '<td>'.$currency.number_format($subtotal).'</td>';
	         echo '<td><a href="/cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'" class="btn btn-sm btn-error">quitar</a></td>';
	         $total = ($total + $subtotal);
	         if ($total>85000) {
	          $grandTotal = $total;
	          $shipping = 0;
	        } else{
	          $grandTotal = $total + 5500;
	          $shipping = 5500;
	        }
	
	        echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->name.'" />';
	        echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
	        echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$obj->description.'" />';
	        echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
	        $cart_items ++;
	        echo '</tr>';
	
	      }
	      echo '<tfoot>';
	      echo '<tr><td colspan="5">Subtotal</td>';
	      echo '<td>'.$currency.number_format($total).'</td></tr>';
	      echo '<tr><td colspan="5">Costos de envio</td>';
	      echo '<td>'.$currency.number_format($shipping).'</td></tr>';
	      echo '<tr><td colspan="5">Total</td>';
	      echo '<td>'.$currency.number_format($grandTotal).'</td></tr>';
	      echo '</tfoot>';
	      echo '</table>';
	      echo '<span class="check-out-txt">';
	      echo '</span>';
	      echo '<a href="/comprar" class="btn btn-lg btn-primary" style="margin-right:1em;">Seguir Comprando</a>';
	      echo '<span class="empty-cart"><a href="/cart_update.php?emptycart=1&return_url='.$current_url.'">Vaciar Carrito de compras</a></span>';
	      echo '</form>';
	
	    }else{
	      echo '<p>Tu carrito de compras esta vacío, pero puedes comprar <a href="../comprar/">productos acá</a></p>';
	    }
	
	    ?>
	    </div>
    </div>
  </div>
</section>
<section class="bg-light-gray">
  <div class="container">
    <div class="row">
     <div class="col-sm-offset-2 col-sm-8">
       <h2>Paga con PayU </h2>
       <?php
       $ApiKey = 'Khrho3F1omIZYrvOMNXAYRU1FI';
       $merchant_id = '530309';
       $account_id = '532198';
       $referenceCode = 'explora.life-'.session_id();
       $currency_code = 'COP';
       $sign = $ApiKey.'~'.$merchant_id.'~'.$referenceCode.'~'.$grandTotal.'~'.$currency_code;
       $signature = md5($sign);
       ?>
       <form method="post" name="checkout" class="form" action="https://gateway.payulatam.com/ppp-web-gateway/" onsubmit="return validate();">
        <input name="merchantId"    type="hidden"  value="<?php echo $merchant_id; ?>"   >
        <input name="accountId"     type="hidden"  value="<?php echo $account_id; ?>" >
        <input name="description"   type="hidden"  value="Explora.life"  >
        <input name="referenceCode" type="hidden"  value="<?php echo $referenceCode; ?>" >
        <input name="amount"        type="hidden"  value="<?php echo $grandTotal; ?>"   >
        <input name="tax"           type="hidden"  value="0"  >
        <input name="taxReturnBase" type="hidden"  value="0" >
        <input name="extra1" type="hidden" value="<?php echo $referenceCode; ?>">
        <input name="currency"      type="hidden"  value="<?php echo $currency_code; ?>" >
        <input name="signature"     type="hidden"  value="<?php echo $signature; ?>"  >
        <div class="form-group">
          <label>Nombre y Apellido</label>
          <input required name="buyerFullName" type="text" class="form-control" placeholder="Daniela Aquite">
        </div>
        <div class="form-group">
          <label>E-mail</label>
          <input name="buyerEmail" required class="form-control"   type="email"  placeholder="hola@explora.life" >
        </div>
        <div class="form-group">
          <label>Teléfono</label>
          <input required name="telephone" type="text" class="form-control" placeholder="316 874 9597">
        </div>
        <div class="form-group">
          <label>Dirección de envío</label>
          <input required name="shippingAddress" type="text" class="form-control" placeholder="Calle 123 N 45-67 Apartamento 8 Torre 9">

        </div>
        <div class="form-group">
          <label>Ciudad de envío</label>
          <input required name="shippingCity" type="text" class="form-control" placeholder="Bogotá, Medellín, Cartagena, Barranquilla, Cali...">
        </div>
        <div class="form-group">
          <label>Pais de envío</label>
          <select id="shippingCountry" name="countries" class="form-control" required>
            <option value="AR">Argentina</option>
            <option value="BO">Bolivia</option>
            <option value="BR">Brazil</option>
            <option value="CL">Chile</option>
            <option value="CO" selected>Colombia</option>
            <option value="CR">Costa Rica</option>
            <option value="CU">Cuba</option>
            <option value="DO">Dominican Republic</option>
            <option value="GF">French Guiana</option>
            <option value="GD">Grenada</option>
            <option value="GT">Guatemala</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HN">Honduras</option>
            <option value="JM">Jamaica</option>
            <option value="MX">Mexico</option>
            <option value="NI">Nicaragua</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="VE">Venezuela</option>
          </select>
        </div>
        <input name="responseUrl"    type="hidden"  value="http://explora.life/transaccion/index.php" >
        <input name="confirmationUrl"    type="hidden"  value="http://explora.life/transaccion/transaction_complete.php" >
        <center><button type="submit" class="btn btn-xl">Pagar</button></center>
      </form>
    </div>
  </div>
</div>
</section>

</div>
</section>
<?php include("../_contenido/newsletter.php"); ?>
<?php include("../_contenido/footer.php"); ?>
<?php include("../_contenido/javas_2.php"); ?>
<script type="text/javascript">
    function validate(){
        var err = 0;
        if (document.checkout.buyerFullName.value===''){
            err = 1;
            alert('Por favor llene su Nombre completo');
            document.checkout.buyerFullName.focus();
        }

        if (document.checkout.buyerEmail.value===''){
            err = 1;
            alert('Por favor llene su Correo');
            document.checkout.buyerEmail.focus();
        }

        if (document.checkout.telephone.value===''){
            err = 1;
            alert('Por favor llene su Teléfono');
            document.checkout.telephone.focus();
        }

        if (document.checkout.shippingAddress.value===''){
            err = 1;
            alert('Por favor llene su Dirección de envío');
            document.checkout.shippingAddress.focus();
        }

        if (document.checkout.shippingCity.value===''){
            err = 1;
            alert('Por favor llene su Ciudad de envío');
            document.checkout.shippingCity.focus();
        }

        if (document.checkout.shippingCountry.value===''){
            err = 1;
            alert('Por favor llene su Pais de envío');
            document.checkout.shippingCountry.focus();
        }

        if (document.checkout.shippingCountry.value!='CO'){
            err = 1;
            alert('Proximamente llegaremos a '+ document.checkout.shippingCountry.options[document.checkout.shippingCountry.selectedIndex].innerHTML +', por el momento solo envios a Colombia');
            document.checkout.shippingCountry.focus();
        }

        if(err===0){
            return true;
        } else{
            return false;
        }


    }
</script>
</body>
</html>