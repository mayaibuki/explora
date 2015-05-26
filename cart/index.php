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
       <form method="post" class="form" action="https://gateway.payulatam.com/ppp-web-gateway/">
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
          <p class="text-muted">*Solo envíos a Colombia, por ahora…</p>
        </div>
        <!--<div class="form-group">
          <label>Pais de envío</label>
          <p>Solo envios a Colombia</p>
          <!--
          <select id="shippingCountry" name="countries" class="form-control">
            <option value="AF">Afghanistan</option>
            <option value="AX">Åland Islands</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="BN">Brunei Darussalam</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CA">Canada</option>
            <option value="CV">Cape Verde</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos (Keeling) Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo</option>
            <option value="CD">Congo, The Democratic Republic of The</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="CI">Cote D'ivoire</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands (Malvinas)</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="GF">French Guiana</option>
            <option value="PF">French Polynesia</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GG">Guernsey</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea-bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard Island and Mcdonald Islands</option>
            <option value="VA">Holy See (Vatican City State)</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran, Islamic Republic of</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IM">Isle of Man</option>
            <option value="IL">Israel</option>
            <option value="IT">Italy</option>
            <option value="JM">Jamaica</option>
            <option value="JP">Japan</option>
            <option value="JE">Jersey</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KP">Korea, Democratic People's Republic of</option>
            <option value="KR">Korea, Republic of</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Lao People's Democratic Republic</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libyan Arab Jamahiriya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macao</option>
            <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia, Federated States of</option>
            <option value="MD">Moldova, Republic of</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="ME">Montenegro</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="AN">Netherlands Antilles</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PS">Palestinian Territory, Occupied</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Reunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russian Federation</option>
            <option value="RW">Rwanda</option>
            <option value="SH">Saint Helena</option>
            <option value="KN">Saint Kitts and Nevis</option>
            <option value="LC">Saint Lucia</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent and The Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="RS">Serbia</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="GS">South Georgia and The South Sandwich Islands</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SJ">Svalbard and Jan Mayen</option>
            <option value="SZ">Swaziland</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syrian Arab Republic</option>
            <option value="TW">Taiwan, Province of China</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania, United Republic of</option>
            <option value="TH">Thailand</option>
            <option value="TL">Timor-leste</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VE">Venezuela</option>
            <option value="VN">Viet Nam</option>
            <option value="VG">Virgin Islands, British</option>
            <option value="VI">Virgin Islands, U.S.</option>
            <option value="WF">Wallis and Futuna</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
          </select>
        </div>
        -->
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

</body>
</html>