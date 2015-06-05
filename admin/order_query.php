<?php 
include_once '../functions.php';
$result = $mysqli->query('SELECT * FROM orders WHERE (payed=true OR pending=true) AND hidden=false');
if (!$result) {
  die('Could not query:' . mysqli_error());
}

while($row = $result->fetch_assoc()) {

  ?>
  <div class="grey-mod">
    <table class="table">
      <thead>
        <tr>
          <td><strong>Orden NO.</strong> <?php echo $row['order_id']; if($row['pending']==TRUE && $row['payed']==False){ echo ' - Transacción pendiente'; } ?></td>
          <td style="text-align: right;"><strong>Cliente:</strong> <?php if ($row['name']!=''){ echo $row['name'].'/'; } ?><?php echo $row['email'] ?></td>
        </tr>
        <tr>
          <td><strong>Valor:</strong> $<?php echo number_format($row['amount']); ?></td>
          <td style="text-align: left;"></td>
        </tr>
        <tr>
          <td><strong>Referencia:</strong> <?php echo $row['reference'] ?></td>
          <td style="text-align: right;"><strong>Fecha:</strong> <?php echo $row['transaction_date'] ?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Dirección:</strong> <?php echo $row['address'].', '.$row['city'].', '.$row['country']?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Telefono: </strong><?php echo $row['telephone']; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
        </tr>
        <?php
        $order_id=$row['order_id'];
        $order_itm = $mysqli->query("SELECT * FROM order_item WHERE order_id='$order_id'");
        while ($item = $order_itm->fetch_assoc() )  {
         ?>
         <tr>
           <td><?php echo $item['name']; ?></td>
           <td><?php echo $item['quantity']; ?></td>
         </tr>
         <?php
       }
       $order_itm->close();
       ?>
     </tbody>
   </table>
   <button class="btn btn-error btn-block hide-btn" data-id="<?php echo $row['order_id']; ?>">Esconder</button>
 </div>
 <?php
}
$result->close();
?>