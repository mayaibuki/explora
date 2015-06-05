<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
setcookie("PHPSESSID", "", 1);
session_unset();  
session_destroy(); 
session_start();
session_regenerate_id(true);
@include_once '../functions.php';
include '../_contenido/_header.php';
echo '<body><br><br>';
$currency = '$';
$current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
include '../_contenido/navigation_comprar.php';
?>

<section>
  <div class="container">
    <div class="row">
      <?php
      $ApiKey = 'Khrho3F1omIZYrvOMNXAYRU1FI';
      $merchant_id = $_REQUEST['merchantId'];
      $referenceCode = $_REQUEST['referenceCode'];
      $TX_VALUE = $_REQUEST['TX_VALUE'];
      $New_value = number_format($TX_VALUE, 1, '.', '');
      $currency = $_REQUEST['currency'];
      $transactionState = $_REQUEST['transactionState'];
      $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
      $firmacreada = md5($firma_cadena);
      $firma = $_REQUEST['signature'];
      $reference_pol = $_REQUEST['reference_pol'];
      $cus = $_REQUEST['cus'];
      $extra1 = $_REQUEST['description'];
      $pseBank = $_REQUEST['pseBank'];
      $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
      $transactionId = $_REQUEST['transactionId'];
      $email = $_REQUEST['buyerEmail'];

      if ($_REQUEST['polTransactionState'] == 6 && $_REQUEST['polResponseCode'] == 5) {
        $estadoTx = "Transacción fallida";
      }
      else if ($_REQUEST['polTransactionState'] == 6 && $_REQUEST['polResponseCode'] == 4) {
        $estadoTx = "Transacción rechazada";
      }
      else if ($_REQUEST['polTransactionState'] == 12 && $_REQUEST['polResponseCode'] == 9994) {
        $estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
      }
      else if ($_REQUEST['polTransactionState'] == 4 && $_REQUEST['polResponseCode'] == 1) {
        $estadoTx = "Transacción aprobada";
      }
      else {
        $estadoTx=$_REQUEST['lapTransactionState'];
      }

      if ($transactionState == 4 || $transactionState == 7){
        $order_result = $mysqli->query("SELECT * FROM orders WHERE reference='$referenceCode' LIMIT 1");
        $order = $order_result->fetch_object();
        $items = $mysqli->query("SELECT * FROM order_item WHERE order_id='$order->order_id'");
        if(!$order->stock_discount){
          while($itm = $items->fetch_assoc()){
            $qty = $itm['quantity'];
            $p_id = $itm['product_id'];
            $mysqli->query("UPDATE product SET stock=stock-'$qty' WHERE product_id='$p_id'");
          }
          $mysqli->query("UPDATE orders SET amount='$TX_VALUE', email='$email', stock_discount=TRUE, pending=TRUE WHERE reference='$referenceCode'");
        }
      }


      if (strtoupper($firma) == strtoupper($firmacreada)) {
        ?>
        <h1>Resumen Transacción</h1>
        <table class="table" id="factura">
          <tr>
            <td>Estado de la transaccion</td>
            <td><?php echo $estadoTx; ?></td>
          </tr>
          <tr>
            <tr>
              <td>ID de la transaccion</td>
              <td><?php echo $transactionId; ?></td>
            </tr>
            <tr>
              <td>Referencia de la venta</td>
              <td><?php echo $reference_pol; ?></td> 
            </tr>
            <tr>
              <td>Referencia de la transaccion</td>
              <td><?php echo $referenceCode; ?></td>
            </tr>
            <tr>
              <?php
              if($banco_pse != null) {
                ?>
                <tr>
                  <td>cus </td>
                  <td><?php echo $cus; ?> </td>
                </tr>
                <tr>
                  <td>Banco </td>
                  <td><?php echo $pseBank; ?> </td>
                </tr>
                <?php
              }
              ?>
              <tr>
                <td>Valor total</td>
                <td>$<?php echo number_format($TX_VALUE); ?></td>
              </tr>
              <tr>
                <td>Moneda</td>
                <td><?php echo $currency; ?></td>
              </tr>
              <tr>
                <td>Descripción</td>
                <td><?php echo ($extra1); ?></td>
              </tr>
              <tr>
                <td>Entidad:</td>
                <td><?php echo ($lapPaymentMethod); ?></td>
              </tr>
              <tfoot>
                <tr>
                  <td colspan="2">
                    Transacciones realizadas con tarjeta de credito pueden tomar hasta 4 horas en ser validadas dependiendo de la entidad bancaria
                  </td>
                </tr>
                <tr>
                  <td>
                    <button class="btn btn-lg btn-primary" onclick="PrintElem('#factura')">Imprimir</button>
                  </td>
                  <td>
                  </td>
                </tr>
              </tfoot>
            </table>
            <?
          }
          else
          {
            ?>
            <h1>Error validando firma digital.</h1>
            <?php
          }
          ?>
        </div>
      </div>
    </section>
    <?php include("../_contenido/newsletter.php"); ?>
    <?php include("../_contenido/footer.php"); ?>
    <?php include("../_contenido/javas_2.php"); ?>
    <script type="text/javascript">

      function PrintElem(elem)
      {
        Popup($(elem).html());
      }

      function Popup(data) 
      {
        var mywindow = window.open('', 'Resumen Transacción', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Resumen Transacción</title>');
        mywindow.document.write('<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
      }

    </script>

  </body>
  </html>