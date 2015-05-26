<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>explora.life</title>
  <link rel="stylesheet" href="/css/bootstrap.css" />
  <meta charset="utf-8">
  <!--favicon-->
  <link rel=icon href=/_img_icons/favicon16x16.png sizes="16x16" type="image/png">
  <link rel=icon href=/_img_icons/windows48x48.ico sizes="32x32 48x48" type="image/vnd.microsoft.icon">
  <link rel=icon href=/_img_icons/mac.icns sizes="128x128 512x512 8192x8192 32768x32768">
  <link rel=icon href=/_img_icons/iphone.png sizes="57x57" type="image/png">
  <link rel=icon href=/_img_icons/gnome.svg sizes="any" type="image/svg+xml">
  <style>
    html, body{
      background: #eee;
    }
    .module{
      padding: 1em;
      background: #fff;
      margin-bottom: 1em;
    }
    .add-form-group, .add-form-group-how{
      display: block;
      padding: .5em;
      margin-bottom: 1em;
      color:inherit;
    }
    .panel-heading a{
      color:inherit;
      display: block;
    }
    .panel-heading a:hover, .panel-heading a:focus, .panel-heading a:active{
      color:inherit;
      text-decoration: none;
    }
    .add-form-group:hover, .add-form-group:active, .add-form-group:focus{
      color:#fff;
    }

    .grey-mod{
      background:#eee;
      margin:1em 0;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-default" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
          Welcome <?php echo $admin->get_nicename(); ?>
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="logout.php">Logout</a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="container">
    <div class="col-md-5">
      <div class="module">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">

              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Agregar Producto
              </a>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <form method="post" enctype="multipart/form-data" action="product.php">
                  <div class="form-group">
                    <input name="sku" type="text" class="form-control" placeholder="SKU del producto">
                  </div> 
                  <div class="form-group">
                    <input name="name" type="text" class="form-control" placeholder="Nombre del producto">
                  </div>
                  <div class="form-group">
                    <input name="color_code" type="text" class="form-control" placeholder="Código del grupo de productos">
                  </div>
                  <div class="form-group">
                    <input name="color" type="text" class="form-control" placeholder="Color del producto">
                  </div>   
                  <div class="form-group">
                    <input name="price" type="number" class="form-control" placeholder="Precio">
                  </div>
                  <div class="form-group">
                    <input name="how_to_use" type="text" class="form-control" placeholder="Como se Usa? (iframe del video)">
                  </div>
                  <div class="img-form-group-how">
                    <div class="form-group">
                      <label>Imagen de como usar</label>
                      <input type="file" name="how_img[]">
                    </div>
                    <a class="remove_field" href="#">Quitar Campo</a>
                    <!--
                    <div class="form-group">
                      <label>Thumbnail</label>
                      <input type="file" name="thumb_img">
                    </div>
                  -->
                </div>
                <a href="#" class="add-form-group-how bg-info"><i class="glyphicon glyphicon-plus"></i> Agregar más imagenes</a>
                  <div class="form-group">
                    <textarea name="description" class="form-control" placeholder="Descripción"></textarea>
                  </div>
                  <div class="form-group">
                    <input name="stock" type="number" class="form-control" placeholder="Stock">
                  </div>
                  <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" class="form-control" placeholder="Categoria">
                      <?php
                      $cat_result = $mysqli->query('SELECT * FROM category');
                      if (!$cat_result) {
                        die('Could not query:' . mysqli_error());
                      }
                      while($cat_row = $cat_result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $cat_row['category_id'] ?>"><?php echo $cat_row['name'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Atributos</label>
                    <select name="attribute_id[]" multiple="multiple" class="form-control" placeholder="Atributos">
                      <?php
                      $att_result = $mysqli->query('SELECT * FROM attributes');
                      if (!$att_result) {
                        die('Could not query:' . mysqli_error());
                      }
                      while($att_row = $att_result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $att_row['attribute_id'] ?>"><?php echo $att_row['name'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Productos Relacionados</label>
                    <select name="related[]" multiple="multiple" class="form-control" placeholder="Atributos">
                      <?php
                      $related_res = $mysqli->query('SELECT * FROM product');
                      if (!$related_res) {
                        die('Could not query:' . mysqli_error());
                      }
                      while($related = $related_res->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $related['product_id'] ?>"><?php echo $related['name'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="img-form-group">
                    <div class="form-group">
                      <label>Imagen</label>
                      <input type="file" name="full_img[]">
                    </div>
                    <a class="remove_field" href="#">Quitar Campo</a>
                    <!--
                    <div class="form-group">
                      <label>Thumbnail</label>
                      <input type="file" name="thumb_img">
                    </div>
                  -->
                </div>
                <a href="#" class="add-form-group bg-info"><i class="glyphicon glyphicon-plus"></i> Agregar más imagenes</a>  
                <button type="submit" class="btn btn-success">Guardar</button>
              </form>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingTwo">

            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              Agregar Categoria
            </a>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
              <form method="post" enctype="multipart/form-data" action="category.php">
                <div class="form-group">
                  <input type="text" name="name" placeholder="Nombre" class="form-control">
                </div>
                <div class="form-group">
                  <label>Descripción</label>
                  <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Imagen</label>
                  <input type="file" name="img" placeholder="Imagen">
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
              </form>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingThree">

            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
              Agregar Atributo
            </a>
          </div>
          <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
              <form method="post" enctype="multipart/form-data" action="attribute.php">
                <div class="form-group">
                  <input type="text" name="name" placeholder="Nombre" class="form-control">
                </div>
                <div class="form-group">
                  <textarea name="description" class="form-control" placeholder="Descripción"></textarea>
                </div>
                <div class="form-group">
                  <label>Icono</label>
                  <input type="file" name="icon" placeholder="Imagen">
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>     
  <div class="col-md-7">
    <div class="module">
      <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Productos</a></li>
          <li role="presentation"><a href="#category" aria-controls="category" role="tab" data-toggle="tab">Categorias</a></li>
          <li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">Atributos</a></li>
          <li role="presentation"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Ordenes</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>URL</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $result = $mysqli->query('SELECT * FROM product');
                if (!$result) {
                  die('Could not query:' . mysqli_error());
                }

                while($row = $result->fetch_assoc()) {
   // Your code goes here...
   // OR
                  ?>
                  <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo '$'.number_format($row['price']); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><a target="_blank" href="/comprar/<?php echo $row['slug']; ?>/">http://explora.life/comprar/<?php echo $row['slug']; ?></a></td>
                    <td><a class="btn-info btn-sm" href="editar/producto/<?php echo $row['slug']; ?>">Editar</a></td>
                    <td><a class="btn-error btn-sm" href="product.php?id=<?php echo $row['product_id'] ?>&amp;delete=1">Borrar</a></td>
                  </tr>
                  <?php
                }
                $result->close();
                ?>
              </tbody>
            </table>
          </div>
          <div role="tabpanel" class="tab-pane" id="category">
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Imagen</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $result = $mysqli->query('SELECT * FROM category');
                if (!$result) {
                  die('Could not query:' . mysqli_error());
                }

                while($row = $result->fetch_assoc()) {

                  ?>
                  <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><img src="/media/timthumb.php?src=<?php echo $row['img']; ?>"></td>
                    <td><a class="btn-info btn-sm" href="/admin/editar/categoria/<?php echo $row['category_id']; ?>">Editar</a></td>
                    <td><a class="btn-error btn-sm" href="category.php?id=<?php echo $row['product_id'] ?>&amp;delete=1">Borrar</a></td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <div role="tabpanel" class="tab-pane" id="attributes">
            <table class="table">
              <thead>
                <tbody>
                  <?php 
                  $result = $mysqli->query('SELECT * FROM attributes');
                  if (!$result) {
                    die('Could not query:' . mysqli_error());
                  }

                  while($row = $result->fetch_assoc()) {

                    ?>
                    <tr>
                      <td><img src="<?php echo $row['icon'] ?>"></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['description']; ?></td>
                      <td><a class="btn-info btn-sm" href="/admin/editar/atributo/<?php echo $row['attribute_id']; ?>">Editar</a></td>
                      <td><a class="btn-error btn-sm" href="attribute.php?id=<?php echo $row['attribute_id'] ?>&amp;delete=1">Borrar</a></td>
                    </tr>
                    <?php
                  }
                  $result->close();
                  ?>
                </tbody>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="orders">
              <?php 
              $result = $mysqli->query('SELECT * FROM orders WHERE payed=true');
              if (!$result) {
                die('Could not query:' . mysqli_error());
              }

              while($row = $result->fetch_assoc()) {

                ?>
                <div class="grey-mod">
                  <table class="table">
                    <thead>
                      <tr>
                        <td><strong>Orden NO.</strong> <?php echo $row['order_id']; ?></td>
                        <td style="text-align: right;"><strong>Cliente:</strong> <?php echo $row['name'] ?></td>
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
               </div>
               <?php
             }
             $result->close();
             ?>
           </div>
         </div>

       </div>
     </div>
   </div>

 </div>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script type="text/javascript">
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".img-form-group"); //Fields wrapper
    var add_button      = $(".add-form-group"); //Add button ID
    var wrapper2         = $(".img-form-group-how"); //Fields wrapper
    var add_button2      = $(".add-form-group-how"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group"><label>Imagen</label><input type="file" name="full_img[]"></div>'); //add input box
          }
        });
    
  
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).next('div').remove(); x--;
    })

    $(add_button2).click(function(e){ //on add input button click
      e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper2).append('<div class="form-group"><label>Imagen de como usar</label><input type="file" name="how_img[]"></div>'); //add input box
          }
        });
    
  
    $(wrapper2).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).next('div').remove(); x--;
    })
});
</script>
</body>
</html>
