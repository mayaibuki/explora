<?php 
include_once '../functions.php';
$result = $mysqli->query('SELECT * FROM orders WHERE (payed=true OR pending=true) AND hidden=false') or die("Error in the consult.." . mysqli_error($mysqli));
if (!$result) {
  die('Could not query:' . mysqli_error());
}

while($row = $result->fetch_assoc()) {

  ?>
  <div class="grey-mod">
    <table class="table">
      <thead>
        <tr>
          <td colspan="2"><strong>Orden NO.</strong> <?php echo $row['order_id']; if($row['pending']==TRUE && $row['payed']==False){ echo ' - Transacción pendiente'; } ?></td>
          <td style="text-align: right;"><strong>Cliente:</strong> <?php if ($row['name']!=''){ echo $row['name'].'/'; } ?><?php echo $row['email'] ?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Valor:</strong> $<?php echo number_format($row['amount']); ?></td>
          <td style="text-align: left;"></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Referencia:</strong> <?php echo $row['reference'] ?></td>
          <td style="text-align: right;"><strong>Fecha:</strong> <?php echo $row['transaction_date'] ?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Dirección:</strong> <?php echo $row['address'].', '.$row['city'].', '.$row['country']?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Telefono: </strong><?php echo $row['telephone']; ?></td>

        </tr>
        <tr>
          
        </tr>
      </thead>
      <tbody>
        <tr>
        <th>SKU</th>
          <th>Producto</th>
          <th>Cantidad</th>
        </tr>
        <?php
        $order_id=$row['order_id'];
        $order_itm = $mysqli->query("SELECT * FROM order_item WHERE order_id='$order_id'") or die("Error in the consult.." . mysqli_error($mysqli));
        while ($item = $order_itm->fetch_assoc() )  {
          $p_id = $item['product_id'];
          $product = $mysqli->query("SELECT * FROM product WHERE product_id='$p_id' LIMIT 1") or die("Error in the consult.." . mysqli_error($mysqli));
          $prod = $product->fetch_object();
         ?>
         <tr>
         <td><?php echo $prod->SKU; ?></td>
           <td><?php echo $item['name']; ?></td>
           <td><?php echo $item['quantity']; ?></td>
         </tr>
         <?php
       }
       $product->close();
       $order_itm->close();
       ?>
     </tbody>
   </table>
   <button class="btn btn-error btn-block hide-btn" data-id="<?php echo $row['order_id']; ?>">Esconder</button>
 </div>
 <?php
}
$result->close();